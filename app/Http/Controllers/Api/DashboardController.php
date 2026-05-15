<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalInquiries = Inquiry::count();
        $pendingInquiries = Inquiry::where('status', 'new')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_amount');

        // Recent Activity (Inquiries)
        $recentInquiries = Inquiry::latest()->take(5)->get();

        // Upcoming Departures (Bookings or Inquiries with travel dates)
        // For now using Inquiries as bookings usually come from them
        $upcomingDepartures = Inquiry::whereNotNull('travel_date')
            ->where('travel_date', '>=', now())
            ->orderBy('travel_date', 'asc')
            ->take(5)
            ->get();

        return response()->json([
            'stats' => [
                'total_inquiries' => $totalInquiries,
                'pending_inquiries' => $pendingInquiries,
                'confirmed_bookings' => $confirmedBookings,
                'total_revenue' => $totalRevenue,
            ],
            'recent_inquiries' => $recentInquiries,
            'upcoming_departures' => $upcomingDepartures
        ]);
    }
}
