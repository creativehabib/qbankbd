<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class FrontendController extends Controller
{
    public function home()
    {
        return view('welcome');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $results = null;
        
        if (!empty($query) && strlen($query) > 1) {
            $results = Question::where('title', 'like', '%' . $query . '%')
                ->paginate(20);
        }
        
        return view('frontend.search', compact('results', 'query'));
    }

    public function apiSearch(Request $request)
    {
        $query = $request->input('q');
        $results = [];
        
        if (!empty($query) && strlen($query) > 1) {
            $results = Question::where('title', 'like', '%' . $query . '%')
                ->limit(5)
                ->get()
                ->map(function ($q) {
                    return [
                        'title' => strip_tags(preg_replace('/<a\b[^>]*>(.*?)<\/a>/i', '<span>$1</span>', $q->title)),
                        'slug' => $q->slug
                    ];
                });
        }
        
        return response()->json(['results' => $results]);
    }
}
