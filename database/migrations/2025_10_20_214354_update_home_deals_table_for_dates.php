<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('home_deals', function (Blueprint $table) {
            // Remove old timer columns
            $table->dropColumn(['timer_units', 'timer_values']);
            
            // Add new date columns
            $table->timestamp('start_date')->nullable()->after('rating');
            $table->timestamp('end_date')->nullable()->after('start_date');
            $table->boolean('is_active')->default(true)->after('end_date');
        });
    }

    public function down(): void
    {
        Schema::table('home_deals', function (Blueprint $table) {
            $table->json('timer_units')->nullable();
            $table->json('timer_values')->nullable();
            $table->dropColumn(['start_date', 'end_date', 'is_active']);
        });
    }
};