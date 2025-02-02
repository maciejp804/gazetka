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
        Schema::create('leaflet_insert', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leaflet_id')->constrained('leaflets')->onDelete('cascade');
            $table->foreignId('insert_id')->constrained('inserts')->onDelete('cascade');
            $table->integer('after');
            $table->timestamp('display_from')->nullable();
            $table->timestamp('display_to')->nullable();
            $table->enum('status', ['draft', 'published', 'archive'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaflet_insert');
    }
};
