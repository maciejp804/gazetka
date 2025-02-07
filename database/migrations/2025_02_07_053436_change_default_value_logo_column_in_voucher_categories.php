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
        Schema::table('voucher_categories', function (Blueprint $table) {
            $table->string('logo')->nullable()->default('assets/images/categories/default.webp')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voucher_categories', function (Blueprint $table) {
            $table->string('logo')->nullable()->change();
        });
    }
};
