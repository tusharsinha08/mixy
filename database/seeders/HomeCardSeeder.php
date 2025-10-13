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
                'image' => '/assets/images/cards/card-1.jpg',
                'button_text' => 'Shop Now',
                'button_icon' => 'fas fa-arrow-right',
                'button_url' => '#',
            ],
            [
                'title' => 'Organic Dried Mango',
                'price' => '$15 - $50',
                'image' => '/assets/images/cards/card-2.jpg',
                'button_text' => 'Shop Now',
                'button_icon' => 'fas fa-arrow-right',
                'button_url' => '#',
            ],
            [
                'title' => 'Crunchy Crisps',
                'price' => '$20 - $60',
                'image' => '/assets/images/cards/card-3.jpg',
                'button_text' => 'Shop Now',
                'button_icon' => 'fas fa-arrow-right',
                'button_url' => '#',
            ],
        ]);
    }
}
