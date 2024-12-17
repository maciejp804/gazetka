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
        Schema::create('voucher_stores', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->nullable();
            $table->string('name');
            $table->string('program_id');
            $table->string('logo_url')->nullable();
            $table->foreignId('voucher_store_category_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_stores');
    }
};
