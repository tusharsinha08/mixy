<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeNewArrival;

class HomeNewArrivalSeeder extends Seeder
{
    public function run(): void
    {
        HomeNewArrival::truncate();

        HomeNewArrival::insert([
            ['name' => 'Fresh organic kiwi', 'price_range' => '$10.00 - $70.00', 'image' => '/assets/images/products/product-image-2-1.jpg', 'rating' => 5],
            ['name' => 'Dried mango', 'price_range' => '$10.00 - $70.00', 'image' => '/assets/images/products/product-image-1-1.jpg', 'rating' => 4],
            ['name' => 'Dried banana', 'price_range' => '$60.00 - $80.00', 'image' => '/assets/images/products/product-image-3-1.jpg', 'rating' => 4],
            ['name' => 'Crunchy crisps', 'price_range' => '$50.00 - $90.00', 'image' => '/assets/images/products/product-image-4-1.jpg', 'rating' => 5],
            ['name' => 'Jewel cranberries', 'price_range' => '$60.00 - $67.00', 'image' => '/assets/images/products/product-image-5-1.jpg', 'rating' => 5],
            ['name' => 'Fresh Broccoli', 'price_range' => '$60.00 - $67.00', 'image' => '/assets/images/products/product-image-6-1.jpg', 'rating' => 4],
        ]);
    }
}
