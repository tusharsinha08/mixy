<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeBanner;

class HomeBannersSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'position' => 'left',
                'title' => 'Strawberry Velvet Cake',
                'subtitle' => '100% Natural Organic',
                'price' => '$70.00',
                'image' => '/assets/images/banners/img1_banner3_mixy1.webp',
            ],
            [
                'position' => 'right',
                'title' => 'Organic Nuts',
                'subtitle' => '',
                'price' => ' $30.00',
                'image' => '/assets/images/banners/img2_banner3_mixy1.webp',
            ],
        ];

        HomeBanner::insert($banners);
    }
}
