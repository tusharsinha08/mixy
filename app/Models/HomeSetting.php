<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'topbar_text',
        'topbar_phone',
        'logo',
        'hero_title',
        'hero_subtitle',
        'hero_price',
        'hero_image',
        'hero_button_text',
        'nav_links',
        'offer_banners',
        'categories',
        'featured_category',
        'newsletter',
        'footer',
        'icons',
    ];

    protected $casts = [
        'nav_links' => 'array',
        'offer_banners' => 'array',
        'categories' => 'array',
        'featured_category' => 'array',
        'newsletter' => 'array',
        'footer' => 'array',
        'icons' => 'array',
    ];
    public function bestSellers()
{
    return $this->hasMany(HomeBestSeller::class);
}

}
