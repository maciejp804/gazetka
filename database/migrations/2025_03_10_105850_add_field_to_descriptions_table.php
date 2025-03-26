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
        Schema::table('descriptions', function (Blueprint $table) {
            $table->string('h1_title')->after('faq')->nullable();
            $table->foreignId('shop_id')->after('place_id')->nullable()->constrained('shops')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('descriptions', function (Blueprint $table) {
            $table->dropColumn('h1_title');
            $table->dropForeign(['shop_id']); // najpierw usuwa klucz obcy
            $table->dropColumn('shop_id');    // następnie usuwa kolumnę
        });
    }
};
