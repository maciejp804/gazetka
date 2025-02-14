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
        Schema::create('leaflet_covers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leaflet_id')->constrained('leaflets')->onDelete('cascade');
            $table->string('original_name');
            $table->string('path');
            $table->string('webp_path')->nullable();   // Ścieżka do WebP
            $table->string('avif_path')->nullable();   // Ścieżka do AVIF
            $table->integer('width');         // Szerokość obrazu
            $table->integer('height');        // Wysokość obrazu
            $table->string('alt_text')->nullable();  // SEO-friendly tekst alternatywny
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaflet_covers');
    }
};
