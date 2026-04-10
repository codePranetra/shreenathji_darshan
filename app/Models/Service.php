<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'category',
        'rating',
        'mobile_number',
        'website_url',
        'google_map_link',
        'is_active',
        'is_deleted',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
    ];
}
