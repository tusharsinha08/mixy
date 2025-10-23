<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('home_new_arrivals', function (Blueprint $table) {
            // ✅ Add the new column only if it doesn’t already exist
            if (!Schema::hasColumn('home_new_arrivals', 'product_id')) {
                $table->unsignedBigInteger('product_id')->nullable()->after('id');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('home_new_arrivals', function (Blueprint $table) {
            // ✅ Rollback: drop the foreign key and column
            if (Schema::hasColumn('home_new_arrivals', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
        });
    }
};
