<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn([
                'deals',
                'new_arrivals',
                'cards',
                'natural_left',
                'natural_right',
                'categories',
               
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->json('deals')->nullable();
            $table->json('new_arrivals')->nullable();
            $table->json('cards')->nullable();
            $table->json('natural_left')->nullable();
            $table->json('natural_right')->nullable();
            $table->json('categories')->nullable();
        });
    }
};
