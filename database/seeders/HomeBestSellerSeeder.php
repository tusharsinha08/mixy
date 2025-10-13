<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeBestSeller;

class HomeBestSellerSeeder extends Seeder
{
    public function run(): void
    {
        // Clear table before inserting (so you don’t get duplicates)
        HomeBestSeller::truncate();

        // Insert your original best_sellers JSON items as rows
        HomeBestSeller::insert([
            [
                'name' => 'Fresh organic kiwi',
                'price_range' => '$10.00 - $70.00',
                'image' => '/assets/images/products/product-image-2-1.jpg',
                'rating' => 5,
                'button_text' => 'Add to cart',
                'button_icon' => 'fas fa-shopping-bag',
            ],
            [
                'name' => 'Dried mango',
                'price_range' => '$10.00 - $70.00',
                'image' => '/assets/images/products/product-image-1-1.jpg',
                'rating' => 5,
                'button_text' => 'Add to cart',
                'button_icon' => 'fas fa-shopping-bag',
            ],
            [
                'name' => 'Dried banana',
                'price_range' => '$60.00 - $80.00',
                'image' => '/assets/images/products/product-image-3-1.jpg',
                'rating' => 5,
                'button_text' => 'Add to cart',
                'button_icon' => 'fas fa-shopping-bag',
            ],
            [
                'name' => 'Crunchy crisps',
                'price_range' => '$50.00 - $90.00',
                'image' => '/assets/images/products/product-image-4-1.jpg',
                'rating' => 4,
                'button_text' => 'Add to cart',
                'button_icon' => 'fas fa-shopping-bag',
            ],
            [
                'name' => 'Jewel cranberries',
                'price_range' => '$60.00 - $67.00',
                'image' => '/assets/images/products/product-image-5-1.jpg',
                'rating' => 5,
                'button_text' => 'Add to cart',
                'button_icon' => 'fas fa-shopping-bag',
            ],
        ]);
    }
}
