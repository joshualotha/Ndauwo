<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::where('active', true)
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($packages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jsonFields = ['highlights', 'inclusions', 'exclusions', 'daily_itinerary', 'accommodation_details', 'special_interests', 'feature_icons', 'seasonal_pricing', 'related_packages'];
        foreach ($jsonFields as $field) {
            if ($request->has($field) && is_string($request->input($field))) {
                $request->merge([$field => json_decode($request->input($field), true)]);
            }
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'duration_days' => 'required|integer',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'difficulty' => 'nullable|string|in:Easy,Moderate,Strenuous',
            'min_people' => 'nullable|integer|min:1',
            'max_people' => 'nullable|integer|gt:min_people',
            'highlights' => 'nullable|array',
            'best_time_to_visit' => 'nullable|string',
            'accommodation_details' => 'nullable|array', // e.g. [{"name": "Lodge A", "type": "Luxury"}]
            'special_interests' => 'nullable|array',
            'image' => 'nullable|file|image|max:20480', // 20MB max
            'itinerary' => 'nullable|string',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
            'featured' => 'boolean',
            'active' => 'boolean',
            
            // Display Meta Fields
            'hero_label' => 'nullable|string|max:255',
            'location_summary' => 'nullable|string|max:255',
            'duration_label' => 'nullable|string|max:255',
            'group_size' => 'nullable|string|max:255',
            'badge' => 'nullable|string|max:255',
            'signature_experience' => 'nullable|string|max:255',
            'pull_quote' => 'nullable|string',
            'feature_icons' => 'nullable|array',

            'difficulty_level' => 'nullable|string',
            'seasonal_pricing' => 'nullable|array',
            'daily_itinerary' => 'nullable|array',
            'gallery' => 'nullable|array',
            'pdf_path' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'related_packages' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('packages', 'public');
            $validated['image'] = $path;
        }

        if ($request->hasFile('pdf_path')) {
             $path = $request->file('pdf_path')->store('packages/docs', 'public');
             $validated['pdf_path'] = $path;
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('packages/gallery', 'public');
            }
            $validated['gallery'] = $galleryPaths;
        }

        $package = Package::create($validated);

        return response()->json($package, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($idOrSlug)
    {
        $package = Package::where('id', $idOrSlug)
            ->orWhere('slug', $idOrSlug)
            ->firstOrFail();
            
        return response()->json($package);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $package = Package::findOrFail($id);

        $jsonFields = ['highlights', 'inclusions', 'exclusions', 'daily_itinerary', 'accommodation_details', 'special_interests', 'feature_icons', 'seasonal_pricing', 'related_packages'];
        foreach ($jsonFields as $field) {
            if ($request->has($field) && is_string($request->input($field))) {
                $request->merge([$field => json_decode($request->input($field), true)]);
            }
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'type' => 'sometimes|string',
            'duration_days' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
            'description' => 'sometimes|string',
            'difficulty' => 'sometimes|string|in:Easy,Moderate,Strenuous',
            'min_people' => 'sometimes|integer|min:1',
            'max_people' => 'sometimes|integer|gt:min_people',
            'highlights' => 'nullable|array',
            'best_time_to_visit' => 'nullable|string',
            'accommodation_details' => 'nullable|array',
            'special_interests' => 'nullable|array',
            'image' => 'nullable|file|image|max:20480',
            'itinerary' => 'nullable|string',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
            'featured' => 'nullable|in:true,false,1,0',
            'active' => 'nullable|in:true,false,1,0',

            // Display Meta Fields
            'hero_label' => 'nullable|string|max:255',
            'location_summary' => 'nullable|string|max:255',
            'duration_label' => 'nullable|string|max:255',
            'group_size' => 'nullable|string|max:255',
            'badge' => 'nullable|string|max:255',
            'signature_experience' => 'nullable|string|max:255',
            'pull_quote' => 'nullable|string',
            'feature_icons' => 'nullable|array',

            'difficulty_level' => 'nullable|string',
            'seasonal_pricing' => 'nullable|array',
            'daily_itinerary' => 'nullable|array',
            'gallery' => 'nullable|array', 
            'pdf_path' => 'nullable|file|mimes:pdf|max:10240',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'related_packages' => 'nullable|array',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($package->image) {
                Storage::disk('public')->delete($package->image);
            }
            $path = $request->file('image')->store('packages', 'public');
            $validated['image'] = $path;
        }

        if ($request->hasFile('pdf_path')) {
             if ($package->pdf_path) {
                Storage::disk('public')->delete($package->pdf_path);
            }
             $path = $request->file('pdf_path')->store('packages/docs', 'public');
             $validated['pdf_path'] = $path;
        }

        // Handle Gallery: Merge existing and new
        // Note: This logic assumes 'gallery' input contains new files. 
        // Existing gallery items should be preserved if not explicitly removed.
        // For a true "manager", we'd pass 'existing_gallery' array of paths to keep.
        // Let's implement a simple append for now, or check for 'existing_gallery' input if we want to delete.
        // Creating a full gallery manager is complex. Let's assume append for new files.
        // If the user wants to delete, they might need a separate endpoint or we need complex logic here.
        
        $currentGallery = $package->gallery ?? [];
        
        if ($request->hasFile('gallery')) {
            $newGalleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $newGalleryPaths[] = $file->store('packages/gallery', 'public');
            }
            // Append new images
            $validated['gallery'] = array_merge($currentGallery, $newGalleryPaths);
        } else {
             // If 'gallery' is passed as array of strings (existing), we use that.
             // If not passed, we keep current? Or set to empty?
             // usually 'sometimes' validation handles this, but here we need to be careful.
             // If we want to allow deleting images, the frontend should send the list of *remaining* images (strings).
             // But file uploads (objects) can't be mixed easily in same field if using validation rules strictly.
             
             // Workaround: Use 'existing_gallery' for list of retained paths.
             // $validated['gallery'] will be overwritten if present.
             if ($request->has('existing_gallery')) {
                 $validated['gallery'] = $request->input('existing_gallery');
             }
        }

        if (isset($validated['featured'])) {
            $validated['featured'] = in_array($validated['featured'], ['true', '1', 1, true], true);
        }
        if (isset($validated['active'])) {
            $validated['active'] = in_array($validated['active'], ['true', '1', 1, true], true);
        }

        $package->update($validated);

        return response()->json($package);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $package = Package::findOrFail($id);
        
        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }

        $package->delete();

        return response()->json(['message' => 'Package deleted successfully']);
    }
}
