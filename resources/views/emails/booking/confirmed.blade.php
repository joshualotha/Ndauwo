<x-mail::message>
# Booking Confirmation

Dear {{ $booking->user->name ?? $booking->traveler_info[0]['name'] ?? 'Guest' }},

We are pleased to confirm your booking!

**Booking ID:** #{{ $booking->id }}  
**Package:** {{ $booking->package ? $booking->package->title : 'Custom Trip' }}  
**Total Amount:** ${{ number_format($booking->total_amount, 2) }}  
**Status:** {{ ucfirst($booking->status) }}

We will be in touch shortly with more details about your upcoming adventure.

<x-mail::button :url="config('app.frontend_url')">
View My Trip
</x-mail::button>

Safe Travels,<br>
{{ config('app.name') }} Team
</x-mail::message>
