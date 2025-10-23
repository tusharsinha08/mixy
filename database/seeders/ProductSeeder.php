<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Banana Chips',
                'slug' => 'banana-chips',
                'price_range' => '$12.00 - $40.00',
                'image_primary' => '/assets/images/products/product-image-3-1.jpg',
                'thumbnails' => [
                    '/assets/images/products/product-image-1-2.jpg',
                    '/assets/images/products/product-image-3-2.jpg'
                ],
                'rating' => 4,
                'description_short' => 'Crispy banana chips for healthy snacking.',
                'description_long' => 'Made from fresh bananas, lightly salted and baked.',
                'additional_info' => [
                    'size' => '100g, 200g',
                    'brand' => 'Nature Snacks',
                    'dietary_and_lifestyle' => 'Vegan'
                ],
                'categories' => ['Snacks'],
                'categories_for_homepage' => ['featured'],
                'tags' => ['banana', 'crispy', 'healthy'],
                'sizes' => ['100g', '200g'],
                'reviews' => [
                    [
                        'name' => 'Alice W', 
                        'email' => 'alice@example.com', 
                        'text' => 'My favorite snack!',
                        'rating' => 5
                    ]
                ],
            ],
            [
                'name' => 'Red Dates',
                'slug' => 'red-dates',
                'price_range' => '$20.00 - $60.00',
                'image_primary' => '/assets/images/products/product-image-4-1.jpg',
                'thumbnails' => [
                    '/assets/images/products/product-image-4-1.jpg',
                    '/assets/images/products/product-image-4-2.jpg'
                ],
                'rating' => 4,
                'description_short' => 'Fresh and sweet red dates.',
                'description_long' => 'High-quality dates packed with natural sweetness and nutrients.',
                'additional_info' => [
                    'size' => '250g, 500g',
                    'brand' => 'Healthy Harvest',
                    'dietary_and_lifestyle' => 'Vegan'
                ],
                'categories' => ['Fruits'],
                'categories_for_homepage' => ['best_sellers'],
                'tags' => ['dates', 'healthy'],
                'sizes' => ['250g', '500g'],
                'reviews' => [
                    [
                        'name' => 'Mike B', 
                        'email' => 'mike@example.com', 
                        'text' => 'Sweet and fresh!',
                        'rating' => 4
                    ]
                ],
            ],
            [
                'name' => 'Cranberries',
                'slug' => 'cranberries',
                'price_range' => '$25.00 - $70.00',
                'image_primary' => '/assets/images/products/product-image-5-1.jpg',
                'thumbnails' => [
                    '/assets/images/products/product-image-5-1.jpg',
                    '/assets/images/products/product-image-5-2.jpg'
                ],
                'rating' => 4,
                'description_short' => 'Tangy-sweet dried cranberries.',
                'description_long' => 'Packed with antioxidants, perfect for salads or snacking.',
                'additional_info' => [
                    'size' => '150g',
                    'brand' => 'Healthy Harvest',
                    'dietary_and_lifestyle' => 'Vegan, Gluten-Free'
                ],
                'categories' => ['Dried Fruits'],
                'categories_for_homepage' => ['popular'],
                'tags' => ['cranberry', 'healthy', 'snack'],
                'sizes' => ['150g', '300g'],
                'reviews' => [
                    [
                        'name' => 'Sarah L', 
                        'email' => 'sarah@example.com', 
                        'text' => 'Love the taste!',
                        'rating' => 5
                    ]
                ],
            ],
            [
                'name' => 'Kiwi Juice',
                'slug' => 'kiwi-juice',
                'price_range' => '$8.00 - $25.00',
                'image_primary' => '/assets/images/products/product-image-6-1.jpg',
                'thumbnails' => [
                    '/assets/images/products/product-image-6-1.jpg',
                    '/assets/images/products/product-image-6-2.jpg'
                ],
                'rating' => 5,
                'description_short' => 'Refreshing organic kiwi juice.',
                'description_long' => '100% natural kiwi juice with no preservatives.',
                'additional_info' => [
                    'size' => '250ml, 500ml',
                    'brand' => 'Organic Drinks',
                    'dietary_and_lifestyle' => 'Vegan, Gluten-Free'
                ],
                'categories' => ['Juices'],
                'categories_for_homepage' => ['new_arrivals'],
                'tags' => ['organic', 'kiwi', 'juice'],
                'sizes' => ['250ml', '500ml'],
                'reviews' => [
                    [
                        'name' => 'Anna P', 
                        'email' => 'anna@example.com', 
                        'text' => 'Very refreshing!',
                        'rating' => 5
                    ]
                ],
            ],
            [
                'name' => 'Almonds Pack',
                'slug' => 'almonds-pack',
                'price_range' => '$20.00 - $80.00',
                'image_primary' => '/assets/images/products/product-image-7-1.jpg',
                'thumbnails' => [
                    '/assets/images/products/product-image-7-1.jpg',
                    '/assets/images/products/product-image-7-2.jpg'
                ],
                'rating' => 5,
                'description_short' => 'Premium roasted almonds.',
                'description_long' => 'Perfect snack for energy and protein.',
                'additional_info' => [
                    'size' => '200g, 400g',
                    'brand' => 'NutriDelight',
                    'dietary_and_lifestyle' => 'Vegan, Gluten-Free'
                ],
                'categories' => ['Nuts'],
                'categories_for_homepage' => ['super_deals'],
                'tags' => ['almond', 'healthy', 'snack'],
                'sizes' => ['200g', '400g'],
                'reviews' => [
                    [
                        'name' => 'Tom K', 
                        'email' => 'tom@example.com', 
                        'text' => 'Perfect almonds!',
                        'rating' => 5
                    ]
                ],
            ],
            [
                'name' => 'Cashew Nuts',
                'slug' => 'cashew-nuts',
                'price_range' => '$30.00 - $90.00',
                'image_primary' => '/assets/images/products/product-image-8-1.jpg',
                'thumbnails' => [
                    '/assets/images/products/product-image-8-1.jpg',
                    '/assets/images/products/product-image-8-2.jpg'
                ],
                'rating' => 5,
                'description_short' => 'Organic cashews from premium farms.',
                'description_long' => 'Rich in nutrients and perfect for snacks or baking.',
                'additional_info' => [
                    'size' => '250g, 500g',
                    'brand' => 'NutriFarm',
                    'dietary_and_lifestyle' => 'Vegan'
                ],
                'categories' => ['Nuts'],
                'categories_for_homepage' => ['best_sellers'],
                'tags' => ['cashew', 'organic', 'healthy'],
                'sizes' => ['250g', '500g'],
                'reviews' => [
                    [
                        'name' => 'Emma R', 
                        'email' => 'emma@example.com', 
                        'text' => 'Very fresh!',
                        'rating' => 5
                    ]
                ],
            ],
        ];

        foreach ($products as $productData) {
            Product::firstOrCreate(
                ['slug' => $productData['slug']],
                $productData
            );
        }
    }
}