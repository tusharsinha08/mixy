<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image_primary');
            $table->json('thumbnails')->nullable();
            $table->integer('rating')->default(0);
            $table->string('price_range');
            $table->text('description_short')->nullable();
            $table->longText('description_long')->nullable();
            $table->json('additional_info')->nullable();
            $table->json('reviews')->nullable();
            $table->json('categories')->nullable();
            $table->json('categories_for_homepage')->nullable();
            $table->json('tags')->nullable();
            $table->json('sizes')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
