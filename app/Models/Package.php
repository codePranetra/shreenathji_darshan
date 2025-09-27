<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'price',
        'description' => 'array',
        'is_active',
        'is_deleted'
    ];
}