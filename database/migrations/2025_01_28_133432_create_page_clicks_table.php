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
        Schema::create('page_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade');
            $table->foreignId('leaflet_product_id')->nullable()->constrained('leaflet_products')->onDelete('cascade');
            $table->enum('status', ['visible', 'hidden', 'archived'])->default('hidden');
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_to')->nullable();
            $table->string('url');
            $table->integer('x');
            $table->integer('y');
            $table->integer('width');
            $table->integer('height');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_clicks');
    }
};
