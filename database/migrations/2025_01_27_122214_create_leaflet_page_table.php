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
        Schema::create('leaflet_page', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leaflet_id')->constrained('leaflets')->onDelete('cascade');
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['leaflet_id', 'page_id']); // zpobiega duplikacji powiązań
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaflet_page');
    }
};
