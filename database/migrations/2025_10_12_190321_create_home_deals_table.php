<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_deals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('price_range')->nullable();
            $table->string('image')->nullable();
            $table->integer('sold')->default(0);
            $table->integer('available')->default(0);
            $table->integer('progress')->default(0);
            $table->integer('rating')->default(5);
            $table->string('timer_text')->nullable();
            $table->json('timer_units')->nullable();
            $table->json('timer_values')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_deals');
    }
};
