<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Courier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'vehicle_type',
        'vehicle_plate',
        'level',
        'joined_at'
    ];

    protected $casts = [
        'joined_at' => 'date',
    ];
}
