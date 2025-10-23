<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'thumbnails' => 'array',
        'additional_info' => 'array',
        'reviews' => 'array',
        'categories' => 'array',
        'categories_for_homepage' => 'array',
        'tags' => 'array',
        'sizes' => 'array',
    ];

    protected $fillable = [
        'name',
        'slug',
        'image_primary',
        'thumbnails',
        'rating',
        'price_range',
        'description_short',
        'description_long',
        'additional_info',
        'reviews',
        'categories',
        'categories_for_homepage',
        'tags',
        'sizes',
    ];
}