<?php
// database/migrations/xxxx_xx_xx_create_home_best_sellers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
       Schema::create('home_best_sellers', function (Blueprint $table) {
    $table->id();
    $table->string('name')->nullable();
    $table->string('price_range')->nullable();
    $table->string('image')->nullable();
    $table->integer('rating')->default(5);
    $table->string('button_text')->default('Buy Now');
    $table->string('button_icon')->default('fas fa-shopping-bag');
    $table->timestamps();
});

    }

    public function down(): void {
        Schema::dropIfExists('home_best_sellers');
    }
};

