<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all files from the 'packages', 'destinations', 'posts' directories for now
        // Or better, just scan the public disk?
        // Let's scan specific folders to keep it clean.
        
        $directories = ['packages', 'destinations', 'posts', 'uploads'];
        $files = [];

        foreach ($directories as $dir) {
            $filePaths = Storage::disk('public')->files($dir);
            foreach ($filePaths as $path) {
                $files[] = [
                    'path' => $path,
                    'url' => asset('storage/' . $path),
                    'name' => basename($path),
                    'size' => Storage::disk('public')->size($path),
                    'last_modified' => Storage::disk('public')->lastModified($path),
                ];
            }
        }
        
        // Sort by last modified descending
        usort($files, function($a, $b) {
            return $b['last_modified'] - $a['last_modified'];
        });

        return response()->json($files);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // 10MB max
            'folder' => 'nullable|string|in:packages,destinations,posts,uploads'
        ]);

        $folder = $request->input('folder', 'uploads');
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store($folder, 'public');
            
            return response()->json([
                'message' => 'Image uploaded successfully',
                'path' => $path,
                'url' => asset('storage/' . $path),
            ], 201);
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $path = $request->input('path');
        
        if (!$path) {
             return response()->json(['message' => 'Path is required'], 400);
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['message' => 'File deleted successfully']);
        }

        return response()->json(['message' => 'File not found'], 404);
    }
}
