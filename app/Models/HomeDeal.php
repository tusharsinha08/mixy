<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeDeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price_range', 'image', 'sold', 'available', 'progress',
        'rating', 'timer_text', 'timer_units', 'timer_values'
    ];

    protected $casts = [
        'timer_units' => 'array',
        'timer_values' => 'array',
    ];
}
