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
            $table->foreignId('category_id')->default(null)->constrained('categories')->onDelete('cascade');
            $table->foreignId('voucher_store_id')->constrained('voucher_stores')->onDelete('cascade');
            $table->string('voucher_id')->nullable();
            $table->string('title')->nullable();
            $table->string('excerpt')->nullable();
            $table->string('body')->nullable();
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->string('code')->nullable();
            $table->string('conditions')->nullable();
            $table->enum('status', ['active', 'expired', 'draft'])->default('active');
            $table->integer('usage_count')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
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
