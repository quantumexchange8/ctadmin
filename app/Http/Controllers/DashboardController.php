<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $total_visits = DB::table('views')->count('viewable_id');

        return view('pages.dashboard.analytics', [
            'title' => 'Dashboard',
            'total_visits' => $total_visits,
        ]);
    }
}
