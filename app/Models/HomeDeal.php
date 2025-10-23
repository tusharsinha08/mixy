<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeDeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'price_range',
        'image',
        'sold',
        'available',
        'progress',
        'rating',
        'start_date',
        'end_date',
        'is_active',
        'timer_text'
    ];

    protected $casts = [
        'timer_units' => 'array',
        'timer_values' => 'array',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}