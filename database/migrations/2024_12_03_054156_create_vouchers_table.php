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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_id');
            $table->foreignId('voucher_store_id')->constrained('voucher_stores')->onDelete('cascade');
            $table->string('title');
            $table->string('excerpt')->nullable();
            $table->string('body')->nullable();
            $table->string('offer_url')->nullable();
            $table->string('offer_image')->default('assets/images/vouchers/default.png');
            $table->string('code');
            $table->foreignId('voucher_category_id')->constrained();
            $table->string('conditions')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
