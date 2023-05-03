<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function invoice_preview(Request $request)
    {
        $orders = Order::query()
            ->where('is_deleted', 0)
            ->get()
            ->groupBy('user_id');

//        foreach ($orders as $key => $order)
//        {
//            foreach ($order as $invoice)
//            {
//                dd($key, $invoice->product->product_title);
//            }
//        }

        return view('pages.order.preview', [
            'title' => 'Preview',
            'heading' => 'Invoice',
            'orders' => $orders,
        ]);
    }
}
