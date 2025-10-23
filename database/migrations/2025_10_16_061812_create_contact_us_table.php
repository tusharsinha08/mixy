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
      

    Schema::create('contact_us', function (Blueprint $table) {
        $table->id();
        $table->string('page_title')->nullable();
        $table->string('breadcrumb_title')->nullable();
        $table->string('office_location')->nullable();
        $table->string('phone_numbers')->nullable(); 
        $table->string('emails')->nullable(); 
        $table->string('map_title')->nullable();
        $table->string('map_address')->nullable();
        $table->string('newsletter_title')->nullable();
        $table->string('newsletter_subtitle')->nullable();
        $table->string('call_us_text')->nullable();
        $table->string('call_us_number')->nullable();
        $table->json('features')->nullable(); 
        $table->timestamps();
    });
}

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_us');
    }
};
