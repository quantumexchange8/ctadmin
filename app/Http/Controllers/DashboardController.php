<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $order = Order::where('is_deleted', 0)->first();

        return view('pages.dashboard.analytics', [
            'title' => 'Dashboard',
            'order' => $order,
        ]);
    }
}
