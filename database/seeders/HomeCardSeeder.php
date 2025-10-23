<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeCard;

class HomeCardSeeder extends Seeder
{
    public function run(): void
    {
        HomeCard::truncate();

        HomeCard::insert([
            [
                'title' => 'Fresh Fruit Kiwis',
                'price' => '$10 - $40',
                'image' => '/assets/images/banners/img1_banner2_mixy1.webp',
                'button_text' => 'Shop Now',
                'button_icon' => 'fas fa-arrow-right',
                'button_url' => '#',
            ],
            [
                'title' => 'Organic Dried Mango',
                'price' => '$15 - $50',
                'image' => '/assets/images/banners/img2_banner2_mixy1.webp',
                'button_text' => 'Shop Now',
                'button_icon' => 'fas fa-arrow-right',
                'button_url' => '#',
            ],
            [
                'title' => 'Crunchy Crisps',
                'price' => '$20 - $60',
                'image' => '/assets/images/banners/img3_banner2_mixy1.webp',
                'button_text' => 'Shop Now',
                'button_icon' => 'fas fa-arrow-right',
                'button_url' => '#',
            ],
        ]);
    }
}
