<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'preferences' => 'array',
        'flexible_dates' => 'boolean',
        'travel_date' => 'date',
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    //
}
