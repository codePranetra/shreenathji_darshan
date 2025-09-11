<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DarshanTiming extends Model
{
    use HasFactory;
    protected $fillable = [
        'time',
        'title',
        'type',
        'is_active',
        'is_deleted',
    ];
}
