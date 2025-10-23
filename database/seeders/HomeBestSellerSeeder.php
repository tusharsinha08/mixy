<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeBestSeller;
use App\Models\Product;

class HomeBestSellerSeeder extends Seeder
{
    public function run(): void
    {
        // Clear table before inserting
        HomeBestSeller::truncate();

        // Get some products to use as best sellers
        $products = Product::limit(8)->get();

        foreach ($products as $product) {
            HomeBestSeller::create([
                'product_id' => $product->id,
                'bs_title' => $product->name,
                'bs_subtitle' => 'Best Seller',
                'status' => true,
            ]);
        }
    }
}