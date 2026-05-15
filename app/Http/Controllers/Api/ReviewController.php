<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('all')) {
            return Review::orderBy('created_at', 'desc')->get();
        }
        return Review::where('active', true)->orderBy('created_at', 'desc')->get();
    }

    public function toggleActive($id)
    {
        $review = Review::findOrFail($id);
        $review->active = !$review->active;
        $review->save();

        return response()->json(['active' => $review->active]);
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
