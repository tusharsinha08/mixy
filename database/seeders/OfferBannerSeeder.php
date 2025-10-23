<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferBannerSeeder extends Seeder
{
   public function run(): void
{
    \App\Models\OfferBanner::create([
        'title' => 'Choclate Cookies Best Cookies in Town',
        'subtitle' => 'Up to 50% OFF',
        'image' => '/assets/images/banners/img1_banner1_mixy1.webp',
    ]);
    
    \App\Models\OfferBanner::create([
        'title' => 'Capture the Delicious Moments', 
        'subtitle' => 'Up to 30% OFF',
        'image' => '/assets/images/banners/img1_banner1_mixy2.webp',
    ]);
}
}
