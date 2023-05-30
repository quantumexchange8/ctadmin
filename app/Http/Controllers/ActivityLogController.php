<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ActivityLogController extends Controller
{
    public function activity_log_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['activity_log_search' => [
                        'freetext' =>  $request->input('freetext'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('activity_log_search');
                    break;
            }
        }

        $search = session('activity_log_search') ?? $search;

        $records = Activity::with('causer');

        if (isset($search['freetext'])) {
            $records->where('log_name', 'like', '%' . $search['freetext'] . '%')
                ->orWhere('description', 'like', '%' . $search['freetext'] . '%');
        }

        $records = $records->orderBy('created_at', 'desc');

        return view('pages.activity_log.listing', [
            'heading' => 'Activity Log',
            'title' => 'Listing',
            'records' => $records->paginate(10),
            'search' => $search,
        ]);
    }
}
