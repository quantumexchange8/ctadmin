<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\WebTemplateCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

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
                        'category_id' => $request->input('category_id'),
                            'order_status' => $request->input('order_status'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('order_search');
                    break;
            }
        }

        $search = session('order_search') ? session('order_search') : $search;

        // dd($search);

        return view('pages.order.listing', [
            'submit' => route('order_listing'),
            'title' => 'Listing',
            'heading' => 'Order',
            'get_category_sel' => Category::get_category_sel(),
            'records' => Order::get_record($search, 15),
            'search' =>  $search,
            'get_status_sel' => [Order::STATUS_PENDING => 'Pending', Order::STATUS_REPLIED => 'Replied'],
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
                            'order_item_price' => $orderItemPrices[$i]
                        ]
                    );
                }

                Session::flash('success_msg', 'Successfully Updated Order!');
                return redirect()->route('order_listing');
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
//        $order_item_id = OrderItem::where('order_id', $order_id)->where('is_deleted', 0)->pluck('order_item_id');

        return view('pages.order.preview', [
            'title' => 'Preview',
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

}
