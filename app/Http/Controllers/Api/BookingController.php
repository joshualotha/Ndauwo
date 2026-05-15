<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['inquiry', 'package:id,title', 'user:id,name,email']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->get();
        return response()->json($bookings);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $booking = Booking::with(['inquiry', 'package', 'user'])->findOrFail($id);
        return response()->json($booking);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'status' => 'sometimes|string',
            'payment_status' => 'sometimes|string',
            'total_amount' => 'nullable|numeric',
            'paid_amount' => 'nullable|numeric',
            'payment_due_date' => 'nullable|date',
            'internal_notes' => 'nullable|string',
            'traveler_info' => 'nullable|array',
        ]);

        $booking->update($validated);

        if ($request->has('status') && $request->status === 'confirmed') {
            try {
                // Determine recipient email
                $email = $booking->user ? $booking->user->email : ($booking->traveler_info[0]['email'] ?? null);
                if ($email) {
                    \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\BookingConfirmed($booking));
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to send booking confirmation: " . $e->getMessage());
            }
        }

        return response()->json($booking);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Booking::destroy($id);
        return response()->json(null, 204);
    }
}
