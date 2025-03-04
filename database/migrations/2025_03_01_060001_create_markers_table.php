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
        Schema::create('markers', function (Blueprint $table) {
            $table->id();
            $table->integer('old_id')->unique();
            $table->foreignId('shop_id')->constrained('shops')->onDelete('cascade');
            $table->foreignId('place_id')->constrained('places')->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->string('slug');
            $table->decimal('lat',10,8);
            $table->decimal('lng',10,8);
            $table->json('default_opening_hours')->nullable();
            $table->string('timezone')->default('Europe/Warsaw');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markers');
    }
};
