<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryReceived;
use Illuminate\Support\Facades\Log;

class InquiryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ... (validation logic from previous version needs to be preserved or re-implemented here if I'm replacing the whole method, 
        // but wait, I only wrote the Admin InquiryController earlier. 
        // I need to check if there's a PUBLIC store method or if I need to add it to the ADMIN controller which seemed to be the only one I created.)
        
        // Actually, looking back, I created `InquiryController` in `App/Http/Controllers/Api` and it had `index`, `show`, `update`, `destroy`, `convertToBooking`.
        // I did NOT implement the PUBLIC `store` method in that file yet (or maybe I did in a previous turn but I don't see it in the `InquiryController` I wrote in step 997).
        // Wait, step 997 `InquiryController` has `index`, `show`, `update`, `destroy`, `convertToBooking`. It DOES NOT have `store`.
        // However, `api.php` route `Route::post('/inquiries', [InquiryController::class, 'store']);` exists.
        // So I need to ADD `store` to `InquiryController`.
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'nullable|string',
            'package_id' => 'nullable|exists:packages,id',
            'travel_date' => 'nullable|date',
            'adults' => 'nullable|integer|min:1',
            'children' => 'nullable|integer|min:0',
        ]);

        $inquiry = Inquiry::create($validated);
        
        // Send Email to Admin (and optionally to user)
        // For now, let's just log it or send to a fixed admin email
        try {
            Mail::to(config('mail.from.address'))->send(new InquiryReceived($inquiry));
        } catch (\Exception $e) {
            Log::error("Failed to send inquiry email: " . $e->getMessage());
        }

        return response()->json($inquiry, 201);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inquiry::with('package:id,title');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $inquiries = $query->orderBy('created_at', 'desc')->get();
        return response()->json($inquiries);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inquiry = Inquiry::with(['package', 'assignedUser'])->findOrFail($id);
        return response()->json($inquiry);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $inquiry = Inquiry::findOrFail($id);

        $validated = $request->validate([
            'status' => 'sometimes|string',
            'priority' => 'sometimes|string',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $inquiry->update($validated);
        
        // Return refreshed data with relations
        return response()->json($inquiry->load(['package', 'assignedUser']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Inquiry::destroy($id);
        return response()->json(null, 204);
    }

    /**
     * Convert inquiry to booking.
     */
    public function convertToBooking(Request $request, $id)
    {
        $inquiry = Inquiry::findOrFail($id);

        if ($inquiry->status === 'converted') {
            return response()->json(['message' => 'Inquiry already converted'], 400);
        }

        // Logic to create booking
        // We might want to look for an existing user by email or create a new one?
        // For now, let's just create the booking record linked to this inquiry.
        
        $user = User::where('email', $inquiry->email)->first();
        
        $booking = Booking::create([
            'inquiry_id' => $inquiry->id,
            'user_id' => $user ? $user->id : null, 
            'package_id' => $inquiry->package_id,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'traveler_info' => [
                ['name' => $inquiry->name, 'email' => $inquiry->email, 'phone' => $inquiry->phone]
            ],
            'internal_notes' => "Converted from inquiry #{$inquiry->id}",
        ]);

        $inquiry->update(['status' => 'converted']);

        return response()->json($booking, 201);
    }
}
