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
                'name' => 'Dried Fruits',
                'image' => '/assets/images/categories/fresh_vegetables.webp',
                'products' => 1,
            ],
            [
                'name' => 'Fruits',
                'image' => '/assets/images/categories/fresh_fruits.webp',
                'products' => 1,
            ],
            [
                'name' => 'Juices',
                'image' => '/assets/images/categories/fresh_fruits.webp',
                'products' => 1,
            ],
            [
                'name' => 'Nuts',
                'image' => '/assets/images/categories/fresh_fruits.webp',
                'products' => 2,
            ],
        ]);
    }
}
