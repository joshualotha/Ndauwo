<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = GalleryItem::where('active', true)->orderBy('created_at', 'desc');

        if ($request->has('category') && $request->category != 'All') {
            $query->where('category', $request->category);
        }

        if ($request->has('type') && $request->type != 'All') {
            $query->where('type', $request->type);
        }

        return response()->json($query->get());
    }

    // Admin index
    public function adminIndex()
    {
        return response()->json(GalleryItem::orderBy('created_at', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:image,video,360',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'required_if:type,image|image|max:10240', // 10MB
            'video_url' => 'required_if:type,video,360|nullable|url',
            'active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('gallery', 'public');
            $validated['file_path'] = $path;
        }

        $item = GalleryItem::create($validated);

        return response()->json($item, 201);
    }

    /**
     * Bulk upload gallery items.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|max:10240',
        ]);

        $items = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('gallery', 'public');
                $items[] = GalleryItem::create([
                    'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'type' => 'image',
                    'category' => 'Uncategorized',
                    'file_path' => $path,
                    'active' => true,
                ]);
            }
        }

        return response()->json($items, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(GalleryItem $galleryItem)
    {
        return response()->json($galleryItem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GalleryItem $galleryItem)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'category' => 'sometimes|string',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $galleryItem->update($validated);

        return response()->json($galleryItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GalleryItem $galleryItem)
    {
        if ($galleryItem->file_path) {
            Storage::disk('public')->delete($galleryItem->file_path);
        }
        $galleryItem->delete();
        return response()->json(['message' => 'Gallery item deleted']);
    }
}
