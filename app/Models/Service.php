<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $appends = [
        'image_url',
    ];

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

    protected function imageUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            if ($this->image === null || $this->image === '') {
                return null;
            }

            return asset('uploads/services/' . ltrim($this->image, '/'));
        });
    }
}
