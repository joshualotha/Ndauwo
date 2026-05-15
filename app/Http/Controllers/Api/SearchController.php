<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Destination;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Perform global search.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query || strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = [
            'packages' => Package::where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->select('id', 'title', 'slug', 'image', 'price')
                ->limit(5)
                ->get(),
            
            'destinations' => Destination::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->select('id', 'name', 'slug', 'image')
                ->limit(5)
                ->get(),

            'posts' => Post::where('title', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%") // Content search might be slow on huge DBs, use fulltext later if needed
                ->select('id', 'title', 'slug', 'image', 'created_at')
                ->limit(5)
                ->get(),
        ];

        return response()->json($results);
    }
}
