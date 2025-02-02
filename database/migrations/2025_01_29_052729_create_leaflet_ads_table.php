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
        Schema::create('leaflet_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leaflet_id')->constrained('leaflets')->onDelete('cascade');
            $table->foreignId('ad_id')->constrained('ads')->onDelete('cascade');
            $table->integer('after_page');
            $table->integer('priority')->default(0);
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaflet_ads');
    }
};
