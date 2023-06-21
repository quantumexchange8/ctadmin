<?php

namespace App\Http\Controllers;

use App\Exports\OrderReportExport;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function report_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['report_order_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'date_range' =>  $request->input('date_range'),
                        'order_status' => $request->input('order_status'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new OrderReportExport( Order::get_export_record(session('report_order_search'))), $now . '-deposits-records.xlsx');
                case 'reset':
                    session()->forget('report_order_search');
                    break;
            }
        }

        $search = session('report_order_search') ? session('report_order_search') : $search;

        return view('pages.report.listing', [
            'heading' => trans('public.report'),
            'title' => trans('public.listing'),
            'search' => $search,
            'records' => Order::get_export_record($search)->paginate(10),
            'get_order_status_sel' => Order::get_order_status_sel(),
        ]);
    }
}
