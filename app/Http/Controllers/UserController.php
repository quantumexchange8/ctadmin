<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['user_search' => [
                        'freetext' =>  $request->input('freetext'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('user_search');
                    break;
            }
        }

        $search = session('user_search') ? session('user_search') : $search;

        return view('pages.user.listing', [
            'title' => 'Listing',
            'heading' => 'User',
            'records' => User::get_record($search, 10),
        ]);
    }
}
