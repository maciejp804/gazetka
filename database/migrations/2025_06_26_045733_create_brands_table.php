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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->json('aliases')->nullable();
            $table->string('logo')->nullable(); // ścieżka do logotypu (np. "brands/lays.png")
            $table->text('description')->nullable(); // opis marki (opcjonalny)
            $table->boolean('is_featured')->default(false); // np. dla wyróżnionych marek
            $table->enum('status',['active', 'inactive', 'archive'])->default('active'); // np. dla wyróżnionych marek
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
