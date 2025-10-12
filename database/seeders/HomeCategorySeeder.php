<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeCategory;

class HomeCategorySeeder extends Seeder
{
    public function run(): void
    {
        HomeCategory::truncate();

        HomeCategory::insert([
            [
                'name' => 'Fresh Vegetables',
                'image' => '/assets/images/categories/vegetables.jpg',
                'products' => 20,
            ],
            [
                'name' => 'Fresh Fruits',
                'image' => '/assets/images/categories/fruits.jpg',
                'products' => 25,
            ],
            [
                'name' => 'Dried Fruits',
                'image' => '/assets/images/categories/dried-fruits.jpg',
                'products' => 15,
            ],
            [
                'name' => 'Organic Juices',
                'image' => '/assets/images/categories/juices.jpg',
                'products' => 10,
            ],
        ]);
    }
}
