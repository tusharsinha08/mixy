<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeDeal;

class HomeDealSeeder extends Seeder
{
    public function run(): void
    {
        HomeDeal::truncate();

        HomeDeal::insert([
            [
                'name' => 'Organic Apple Juice',
                'price_range' => '$20 - $40',
                'image' => '/assets/images/products/deal-1.jpg',
                'sold' => 50,
                'available' => 100,
                'progress' => 50,
                'rating' => 5,
                'timer_text' => 'Hurry up! Offer ends in:',
                'timer_units' => json_encode(['Hours', 'Mins', 'Secs']),
                'timer_values' => json_encode(['12', '45', '30']),
            ],
            [
                'name' => 'Fresh Orange Pack',
                'price_range' => '$10 - $30',
                'image' => '/assets/images/products/deal-2.jpg',
                'sold' => 30,
                'available' => 70,
                'progress' => 43,
                'rating' => 4,
                'timer_text' => 'Limited time deal!',
                'timer_units' => json_encode(['Hours', 'Mins', 'Secs']),
                'timer_values' => json_encode(['05', '20', '55']),
            ],
        ]);
    }
}
