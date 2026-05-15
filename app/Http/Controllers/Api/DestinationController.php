<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations = Destination::orderBy('name', 'asc')->get();
        return response()->json($destinations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'required|string',
            'best_time_to_visit' => 'nullable|string',
            'highlights' => 'nullable|array',
            'wildlife' => 'nullable|array',
            'trekking_data' => 'nullable|array',
            'image' => 'nullable|image|max:2048',
            
            // New Fields
            'label' => 'nullable|string|max:255',
            'signature_experience' => 'nullable|string|max:255',
            'pull_quote' => 'nullable|string',
            'geography' => 'nullable|string',
            'ecology' => 'nullable|string',
            'accommodation_details' => 'nullable|array',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|max:2048',
            'wildlife_checklist' => 'nullable|array',
            'map_coordinates' => 'nullable|array',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'related_packages' => 'nullable|array',
            'seasonal_data' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('destinations', 'public');
            $validated['image'] = $path;
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('destinations/gallery', 'public');
            }
            $validated['gallery'] = $galleryPaths;
        }

        $destination = Destination::create($validated);

        return response()->json($destination, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($idOrSlug)
    {
        $destination = Destination::where('id', $idOrSlug)
            ->orWhere('slug', $idOrSlug)
            ->firstOrFail();
            
        return response()->json($destination);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $destination = Destination::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string',
            'description' => 'sometimes|string',
            'best_time_to_visit' => 'nullable|string',
            'highlights' => 'nullable|array',
            'wildlife' => 'nullable|array',
            'trekking_data' => 'nullable|array',
            'image' => 'nullable|image|max:2048',
            
            // New Fields
            'label' => 'nullable|string|max:255',
            'signature_experience' => 'nullable|string|max:255',
            'pull_quote' => 'nullable|string',
            'geography' => 'nullable|string',
            'ecology' => 'nullable|string',
            'accommodation_details' => 'nullable|array',
            'gallery' => 'nullable|array', 
            'gallery.*' => 'image|max:2048',
            'wildlife_checklist' => 'nullable|array',
            'map_coordinates' => 'nullable|array',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'related_packages' => 'nullable|array',
            'seasonal_data' => 'nullable|array',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('image')) {
             if ($destination->image) {
                Storage::disk('public')->delete($destination->image);
            }
            $path = $request->file('image')->store('destinations', 'public');
            $validated['image'] = $path;
        }

        $currentGallery = $destination->gallery ?? [];
        if ($request->hasFile('gallery')) {
            $newGalleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $newGalleryPaths[] = $file->store('destinations/gallery', 'public');
            }
            $validated['gallery'] = array_merge($currentGallery, $newGalleryPaths);
        } else {
             if ($request->has('existing_gallery')) {
                 $validated['gallery'] = $request->input('existing_gallery');
             }
        }

        $destination->update($validated);

        return response()->json($destination);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destination = Destination::findOrFail($id);
        
        if ($destination->image) {
            Storage::disk('public')->delete($destination->image);
        }

        $destination->delete();

        return response()->json(['message' => 'Destination deleted successfully']);
    }
}
