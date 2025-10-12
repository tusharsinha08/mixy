<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('topbar_text')->nullable();
            $table->string('topbar_phone')->nullable();
            $table->string('logo')->nullable();
            $table->json('nav_links')->nullable();
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_price')->nullable();
            $table->string('hero_image')->nullable();

            // Sections
            $table->json('offer_banners')->nullable();
            $table->json('deals')->nullable();
            $table->json('new_arrivals')->nullable();
            $table->json('cards')->nullable();
            $table->json('natural_left')->nullable();
            $table->json('natural_right')->nullable();
            $table->json('categories')->nullable();
            $table->json('featured_category')->nullable();
            $table->json('newsletter')->nullable();
            $table->json('services')->nullable();
            $table->json('footer')->nullable();
            $table->json('icons')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};
