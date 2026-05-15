<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Subscribe to the newsletter.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ]);

        $subscriber = NewsletterSubscriber::create([
            'email' => $validated['email'],
            'status' => 'active',
        ]);

        return response()->json(['message' => 'Subscribed successfully', 'subscriber' => $subscriber], 201);
    }

    /**
     * Display a listing of subscribers (Admin only).
     */
    public function index()
    {
        $subscribers = NewsletterSubscriber::orderBy('created_at', 'desc')->get();
        return response()->json($subscribers);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        NewsletterSubscriber::destroy($id);
        return response()->json(null, 204);
    }
}
