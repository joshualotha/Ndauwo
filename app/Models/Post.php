<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'published' => 'boolean',
        'tags' => 'array',
        'published_at' => 'datetime',
        'allow_comments' => 'boolean',
        'featured' => 'boolean',
    ];
}
