<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_new_arrivals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('price_range')->nullable();
            $table->string('image')->nullable();
            $table->integer('rating')->default(4);
            $table->string('button_text')->nullable()->default('Add to cart');
            $table->string('button_icon')->nullable()->default('fas fa-shopping-bag');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_new_arrivals');
    }
};
