<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('header_settings', function (Blueprint $table) {
    $table->id();
    
    // Topbar - ✅ Perfect
    $table->string('topbar_text')->nullable();
    $table->string('topbar_help_text')->nullable();
    $table->string('topbar_phone')->nullable();
   


    $table->string('logo')->nullable();
    $table->string('logo_url')->nullable();

   
    $table->string('search_placeholder')->nullable();

    
    $table->string('icon_user')->nullable();
    $table->string('icon_wishlist')->nullable();
    $table->string('icon_cart')->nullable();

    $table->json('nav_links')->nullable();

    $table->timestamps(); 
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_settings');
    }
};
