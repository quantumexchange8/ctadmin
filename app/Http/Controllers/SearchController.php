<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;
use Spatie\Searchable\SearchResult;

class SearchController extends Controller
{
    public function search(Request $request)
    {
//        $query = $request->input('query');
//        $results = (new Search())
//            ->registerModel(Product::class, function(ModelSearchAspect $modelSearchAspect) {
//                $modelSearchAspect
//                    ->addSearchableAttribute('name') // return results for partial matches on usernames
//                    ->addExactSearchableAttribute('email') // only return results that exactly match the e-mail address
//                    ->active()
//                    ->has('posts')
//                    ->with('roles');
//            });
//
//        return view('pages.dashboard.analytics', [
//            'query' => $query,
//            'results' => $results,
//            'title' => 'Dashboard'
//        ]);
    }
}
