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
                'title' => 'Fresh Organic Kiwi',
                'subtitle' => 'Healthy & Delicious',
                'price' => '$10.00 - $70.00',
                'image' => '/uploads/banners/kiwi.jpg',
            ],
            [
                'position' => 'right',
                'title' => 'Dried Mango',
                'subtitle' => 'Natural Sweetness',
                'price' => '$8.00 - $30.00',
                'image' => '/uploads/banners/mango.jpg',
            ],
        ];

        HomeBanner::insert($banners);
    }
}
