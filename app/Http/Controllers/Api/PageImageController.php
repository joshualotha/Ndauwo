<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageImageController extends Controller
{
    /**
     * Get all images for a specific page
     */
    public function index($page)
    {
        $images = PageImage::where('page', $page)->get();
        return response()->json($images);
    }
    
    /**
     * Get all images grouped by page for the admin panel
     */
    public function all()
    {
        $images = PageImage::orderBy('page')->orderBy('section')->get();
        $grouped = $images->groupBy('page');
        return response()->json($grouped);
    }

    /**
     * Update an image for a specific page and section
     */
    public function update(Request $request)
    {
        $request->validate([
            'page' => 'required|string',
            'section' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
        ]);

        $pageImage = PageImage::where('page', $request->page)
                              ->where('section', $request->section)
                              ->firstOrFail();
        
        \Log::info("Updating PageImage: ID {$pageImage->id}, Page {$request->page}, Section {$request->section}");

        if ($request->hasFile('image')) {
            // Delete old image if it's stored locally
            if ($pageImage->image_path && !str_starts_with($pageImage->image_path, 'http') && !str_starts_with($pageImage->image_path, '/image-')) {
                // Remove leading slash if present
                $oldPath = ltrim($pageImage->image_path, '/');
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Store new image
            $path = $request->file('image')->store('page_images', 'public');
            $pageImage->update([
                'image_path' => '/storage/' . $path
            ]);
        }

        return response()->json([
            'message' => 'Image updated successfully!',
            'image' => $pageImage
        ]);
    }
}
