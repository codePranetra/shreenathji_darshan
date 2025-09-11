<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'customer_name',
        'email',
        'phone_number',
        'time',
        'date',
        'members',
        'amount',
        'darshan_id',
        'package_id',
    ];
}
