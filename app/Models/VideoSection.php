<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoSection extends Model
{
    protected $fillable = [
        'heading',
        'image',
        'youtube_url',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}