<?php

namespace Database\Seeders;

use App\Models\HomeBanner;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Home-related seeders
        $this->call([
            HomeSettingsSeeder::class,
            HomeBestSellerSeeder::class,
            HomeDealSeeder::class,
            HomeCardSeeder::class,
            HomeBannersSeeder::class,
            HomeCategorySeeder::class,
            HomeNewArrivalSeeder::class,
            ProductSeeder::class,
        ]);

        // Create or update the test user safely
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );
    }
}
