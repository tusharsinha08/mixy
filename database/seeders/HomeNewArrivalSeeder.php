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
           
        ]);
    }
}
