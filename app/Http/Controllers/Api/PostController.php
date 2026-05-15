<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get(); // Admin sees all
        return response()->json($posts);
    }
    
    // Public method to get published posts
    public function publicIndex()
    {
         $posts = Post::where('published', true)
            ->where(function($query) {
                $query->whereNull('published_at')
                      ->orWhere('published_at', '<=', now());
            })
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'published' => 'boolean',
            
            // New Fields
            'author' => 'nullable|string',
            'category' => 'nullable|string',
            'tags' => 'nullable|array',
            'summary' => 'nullable|string',
            'published_at' => 'nullable|date',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'allow_comments' => 'boolean',
            'featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        $post = Post::create($validated);

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($idOrSlug)
    {
        $post = Post::where('id', $idOrSlug)
            ->orWhere('slug', $idOrSlug)
            ->firstOrFail();
            
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'image' => 'nullable|image|max:2048',
            'published' => 'boolean',
            
            // New Fields
            'author' => 'nullable|string',
            'category' => 'nullable|string',
            'tags' => 'nullable|array',
            'summary' => 'nullable|string',
            'published_at' => 'nullable|date',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'allow_comments' => 'boolean',
            'featured' => 'boolean',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
             if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        $post->update($validated);

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
