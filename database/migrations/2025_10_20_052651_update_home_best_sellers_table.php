<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop the old table completely
        Schema::dropIfExists('home_best_sellers');
        
        // Create new table with correct structure
        Schema::create('home_best_sellers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('bs_title')->nullable();
            $table->string('bs_subtitle')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            
            // Foreign key
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_best_sellers');
    }
};