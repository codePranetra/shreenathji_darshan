<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'is_active',
        'is_deleted'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'description' => 'array'
    ];
}