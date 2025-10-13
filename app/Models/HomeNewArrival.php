<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeNewArrival extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_range',
        'image',
        'rating',
        'button_text',
        'button_icon',
    ];
}
