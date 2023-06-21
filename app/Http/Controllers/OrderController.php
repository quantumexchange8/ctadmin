<?php

namespace App\Http\Controllers;

use App\Mail\MailToUser;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\WebTemplateCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Session;
use Spatie\Activitylog\Models\Activity;

class OrderController extends Controller
{
    public function order_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['order_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'date_range' => $request->input('date_range'),
                        'order_status' => $request->input('order_status'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('order_search');
                    break;
            }
        }

        $search = session('order_search') ? session('order_search') : $search;

        return view('pages.order.listing', [
            'submit' => route('order_listing'),
            'title' => 'Listing',
            'heading' => trans('public.order'),
            'get_category_sel' => Category::get_category_sel(),
            'records' => Order::get_record($search, 10),
            'search' =>  $search,
            'get_order_status_sel' => Order::get_order_status_sel(),
            'get_attachment_sel' => ['quotation' => trans('public.quotation'), 'invoice' => trans('public.invoice'), 'receipt' => trans('public.receipt')],
        ]);

    }

    public function order_edit(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        $order_item_id = OrderItem::where('order_id', $order_id)->where('is_deleted', 0)->pluck('order_item_id');
        $post = null;
        $validator = null;

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'order_item_name' => 'required' ,
            ])->setAttributeNames([
                'order_item_name' => 'Item Name',
            ]);

            if (!$validator->fails()) {

                $orderItemNames = $request->input('order_item_name');
                $orderItemDescriptions = $request->input('order_item_description');
                $orderItemPrices = $request->input('order_item_price');
                $orderItemOfferPrices = $request->input('order_item_offer_price');
                $existingOrderItems = OrderItem::whereIn('order_item_id', $order_item_id)->get();

                // update the existing order items and create new ones
                for ($i = 0; $i < count($orderItemNames); $i++) {
                    $orderItemId = $i < $existingOrderItems->count() ? $existingOrderItems[$i]->order_item_id : null;
                    $orderItem = OrderItem::updateOrCreate(
                        [
                            'order_item_id' => $orderItemId,
                            'order_id' => $order_id
                        ],
                        [
                            'order_item_name' => $orderItemNames[$i],
                            'order_item_description' => $orderItemDescriptions[$i],
                            'order_item_price' => $orderItemPrices[$i],
                            'order_item_offer_price' => $orderItemOfferPrices[$i]
                        ]
                    );
                }

                if ($request->input('discount_amount')) {
                    $order->update([
                       'discount_amount' => $request->input('discount_amount'),
                    ]);
                }

                $order->update([
                    'order_total_price' => $request->input('order_total_price'),
                ]);

                Session::flash('success_msg', trans('public.success_update_order'));
                return redirect()->back();
            }

            $post = (object) $request->all();

        }

        return view('pages.order.edit', [
            'title' => 'Edit',
            'heading' => 'Order',
            'order' => $order,
            'post' => $post,
        ])->withErrors($validator);
    }

    public function order_preview($order_id)
    {
        $order = Order::find($order_id);

        return view('pages.order.preview', [
            'title' => 'Preview',
            'heading' => 'Order',
            'order' => $order
        ]);
    }

    public function download_quotation($order_id) {
        $order = Order::find($order_id);

        return view('pages.order.quotation-pdf', [
            'title' => 'Quotation',
            'heading' => 'Order',
            'order' => $order
        ]);
    }

    public function order_quotation($order_id)
    {
        $order = Order::find($order_id);

        return view('pages.order.quotation', [
            'title' => 'Quotation',
            'heading' => 'Order',
            'order' => $order
        ]);
    }

    public function order_item_delete(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->is_deleted = $request->input('is_deleted', 1);
        $orderItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Order item deleted successfully'
        ]);
    }

    public function send_mail(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'attachment_type' => 'required',
            'mail_from' => 'required|email',
            'mail_to' => 'required|email',
            'mail_subject' => 'required|string',
            'mail_attachment' => 'required|mimes:pdf,docx|max:10240', // Example validation for file attachment (PDF and DOCX formats, max 10MB)
            'mail_content' => 'required',
        ])->setAttributeNames([
            'attachment_type' => trans('public.attachment_type'),
            'mail_from' => trans('public.from'),
            'mail_to' => trans('public.to'),
            'mail_subject' => trans('public.subject'),
            'mail_attachment' => trans('public.attachment'),
            'mail_content' => trans('public.content'),
        ]);

        if (!$validator->passes()){
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            // Retrieve the form data
            $data = [
                'mail_from' => $request->input('mail_from'),
                'mail_to' => $request->input('mail_to'),
                'mail_subject' => $request->input('mail_subject'),
                'mail_attachment' => $request->file('mail_attachment'),
                'mail_content' => $request->input('mail_content'),
            ];

            // Send the email
            Mail::to($data['mail_to'])->send(new MailToUser($data));

            $order = Order::find($request->order_id);
            $user = $order->user;

            switch ($request->input('attachment_type')) {
                case 'quotation':
                    $order->update([
                        'order_status' => Order::STATUS_PENDING
                    ]);

                    $order->clearMediaCollection('order_quotation');

                    $order->addMedia($request->file('mail_attachment'))
                        ->toMediaCollection('order_quotation');

                    Activity::create([
                        'log_name' => 'order', // Specify the log name here
                        'description' => Auth::user()->user_fullname . ' has sent ' . $request->input('attachment_type') . ' to ' . $user->user_fullname,
                        'subject_type' => Order::class,
                        'subject_id' => $order->order_id, // Replace with the appropriate subject ID
                        'causer_type' => get_class(auth()->user()),
                        'causer_id' => auth()->id(),
                        'properties' => [
                            'old' => ['order_status' => Order::STATUS_PROCESSING], // Set the old values here
                            'attributes' => ['order_status' => Order::STATUS_PENDING], // Set the new values here
                        ],
                        'event' => 'updated',
                    ]);

                    break;
                case 'invoice':
                    $order->update([
                        'order_status' => Order::STATUS_AWAITING
                    ]);

                    $order->clearMediaCollection('order_invoice');

                    $order->addMedia($request->file('mail_attachment'))
                        ->toMediaCollection('order_invoice');

                    Activity::create([
                        'log_name' => 'order', // Specify the log name here
                        'description' => Auth::user()->user_fullname . ' has sent ' . $request->input('attachment_type') . ' to ' . $user->user_fullname,
                        'subject_type' => Order::class,
                        'subject_id' => $order->order_id, // Replace with the appropriate subject ID
                        'causer_type' => get_class(auth()->user()),
                        'causer_id' => auth()->id(),
                        'properties' => [
                            'old' => ['order_status' => Order::STATUS_PENDING], // Set the old values here
                            'attributes' => ['order_status' => Order::STATUS_AWAITING], // Set the new values here
                        ],
                        'event' => 'updated',
                    ]);

                    break;
                case 'receipt':
                    $order->update([
                        'order_status' => Order::STATUS_COMPLETED,
                        'order_completed_at' => now(),
                    ]);

                    $order->clearMediaCollection('order_receipt');

                    $order->addMedia($request->file('mail_attachment'))
                        ->toMediaCollection('order_receipt');

                    Activity::create([
                        'log_name' => 'order', // Specify the log name here
                        'description' => Auth::user()->user_fullname . ' has sent ' . $request->input('attachment_type') . ' to ' . $user->user_fullname,
                        'subject_type' => Order::class,
                        'subject_id' => $order->order_id, // Replace with the appropriate subject ID
                        'causer_type' => get_class(auth()->user()),
                        'causer_id' => auth()->id(),
                        'properties' => [
                            'old' => ['order_status' => Order::STATUS_AWAITING], // Set the old values here
                            'attributes' => ['order_status' => Order::STATUS_COMPLETED], // Set the new values here
                        ],
                        'event' => 'updated',
                    ]);

                    break;
                default:
                    // Handle the case when attachment_type is not recognized
                    return response()->json([
                        'status' => 2,
                        'error' => trans('public.invalid_attachment_type')
                    ]);
            }

            // Optionally, you can handle the response here (e.g., redirect with a success message)
            return response()->json([
                'status' => 1,
                'msg' => trans('public.success_sent_email')
            ]);
        }
    }

    public function invoice_preview($order_id)
    {
        $order = Order::find($order_id);

        return view('pages.order.invoice', [
            'title' => 'Invoice',
            'heading' => 'Order',
            'order' => $order
        ]);
    }

    public function receipt_preview($order_id)
    {
        $order = Order::find($order_id);

        return view('pages.order.receipt', [
            'title' => 'Receipt',
            'heading' => 'Order',
            'order' => $order
        ]);
    }

    public function order_cancel(Request $request)
    {
        $order_id = $request->input('order_id');
        $order = Order::find($order_id);
        $oldOrderStatus = $order->order_status;

        if (!$order) {
            Session::flash('fail_msg', trans('public.invalid_order'));
            return redirect()->route('order_listing');
        }

        $order->update([
            'order_status' => Order::STATUS_CANCELLED,
        ]);

        Activity::create([
            'log_name' => 'order', // Specify the log name here
            'description' => Auth::user()->user_fullname . ' has cancelled Order Number ' . $order->order_number,
            'subject_type' => Order::class,
            'subject_id' => $order->order_id, // Replace with the appropriate subject ID
            'causer_type' => get_class(auth()->user()),
            'causer_id' => auth()->id(),
            'properties' => [
                'old' => ['order_status' => $oldOrderStatus], // Set the old values here
                'attributes' => ['order_status' => Order::STATUS_CANCELLED], // Set the new values here
            ],
            'event' => 'updated',
        ]);

        Session::flash('success_msg', trans('public.success_cancel_order'));
        return redirect()->route('order_listing');
    }

}
