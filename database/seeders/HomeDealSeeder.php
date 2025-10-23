<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeDeal;
use Carbon\Carbon;

class HomeDealSeeder extends Seeder
{
    public function run(): void
    {
        HomeDeal::truncate();

        HomeDeal::insert([
            [
                'name' => 'Organic Apple Juice',
                'price_range' => '$20 - $40',
                'image' => '/assets/images/products/product-image-7-2.jpg',
                'sold' => 50,
                'available' => 100,
                'progress' => 50,
                'rating' => 5,
                'timer_text' => 'Hurry up! Offer ends in:',
                'start_date' => Carbon::now(),               // current timestamp
                'end_date' => Carbon::now()->addDays(1),    // 1 day later
                'is_active' => 1,
            ],
            [
                'name' => 'Fresh Orange Pack',
                'price_range' => '$10 - $30',
                'image' => '/assets/images/products/product-image-7-2.jpg',
                'sold' => 30,
                'available' => 70,
                'progress' => 43,
                'rating' => 4,
                'timer_text' => 'Limited time deal!',
                'start_date' => Carbon::now(),               // current timestamp
                'end_date' => Carbon::now()->addDays(1),    // 1 day later
                'is_active' => 1,
            ],
        ]);
    }
}
