<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /** @use HasFactory<\Database\Factories\PackageFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'inclusions' => 'array',
        'exclusions' => 'array',
        'highlights' => 'array',
        'accommodation_details' => 'array',
        'special_interests' => 'array',
        'seasonal_pricing' => 'array',
        'daily_itinerary' => 'array',
        'gallery' => 'array',
        'related_packages' => 'array',
        'feature_icons' => 'array',
        'active' => 'boolean',
        'featured' => 'boolean',
    ];
}
