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
        Schema::table('hot_spots', function (Blueprint $table) {
            $table->string('name')->nullable()->after('product_id');
            $table->string('brand')->nullable()->after('promo_price');
            $table->string('sku')->nullable()->after('brand');
            $table->string('ean')->nullable()->after('sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hot_spots', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('brand');
            $table->dropColumn('sku');
            $table->dropColumn('ean');
        });
    }
};
