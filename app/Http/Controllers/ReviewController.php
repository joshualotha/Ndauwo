<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Review::where('active', true)->orderBy('created_at', 'desc');

        if ($request->has('safari_type') && $request->safari_type != 'All') {
            $query->where('safari_type', $request->safari_type);
        }

        if ($request->has('rating') && $request->rating > 0) {
            $query->where('rating', '>=', $request->rating);
        }

        if ($request->has('featured') && $request->featured == 'true') {
            $query->where('featured', true);
        }

        return response()->json($query->get());
    }

    // Admin endpoint
    public function adminIndex()
    {
        return response()->json(Review::orderBy('created_at', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email', // Honey pot or future use
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
            'source' => 'nullable|string', // Internal use mostly
            'safari_type' => 'nullable|string',
        ]);

        // Default to 'Website' source if not provided (e.g. from public form)
        if (empty($validated['source'])) {
            $validated['source'] = 'Website';
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reviews', 'public');
            $validated['image'] = $path;
        }

        // Default active to false for public submissions
        $validated['active'] = false;

        $review = Review::create($validated);

        return response()->json(['message' => 'Review submitted successfully! It will be visible after moderation.', 'review' => $review], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return response()->json($review);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'rating' => 'sometimes|integer|min:1|max:5',
            'content' => 'sometimes|string',
            'active' => 'boolean',
            'featured' => 'boolean',
            'source' => 'sometimes|string',
            'safari_type' => 'nullable|string',
        ]);

        $review->update($validated);

        return response()->json($review);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        if ($review->image) {
            Storage::disk('public')->delete($review->image);
        }
        $review->delete();
        return response()->json(['message' => 'Review deleted']);
    }
}
