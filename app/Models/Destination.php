<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    /** @use HasFactory<\Database\Factories\DestinationFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'intro' => 'array',
        'highlights' => 'array',
        'wildlife' => 'array',
        'wildlife_checklist' => 'array',
        'accommodation_details' => 'array',
        'trekking_data' => 'array',
        'gallery' => 'array',
        'map_coordinates' => 'array',
        'related_packages' => 'array',
        'seasonal_data' => 'array',
    ];
}
