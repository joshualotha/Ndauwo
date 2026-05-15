<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
    ];
    //
}
