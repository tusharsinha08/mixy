<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBestSeller extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_setting_id',
        'name',
        'price_range',
        'image',
        'rating',
        'button_text',
        'button_icon',
    ];

    public function homeSetting()
    {
        return $this->belongsTo(HomeSetting::class);
    }
}
