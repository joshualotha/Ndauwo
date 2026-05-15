<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'traveler_info' => 'array',
        'payment_due_date' => 'date',
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
