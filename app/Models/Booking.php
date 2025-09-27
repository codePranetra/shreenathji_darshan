<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone_number',
        'time',
        'date',
        'members',
        'amount',
        'darshan_id',
        'package_id',
        'is_active',
        'is_deleted'
    ];
}
