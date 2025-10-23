<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'image',
        'button_text',
        'button_icon',
        'button_url'
    ];
}