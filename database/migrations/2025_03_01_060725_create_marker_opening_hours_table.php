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
        Schema::create('marker_opening_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marker_id')->constrained('markers')->onDelete('cascade');
            $table->enum('day_of_work',['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'trading_sunday', 'non_trading_sunday']);
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marker_opening_hours');
    }
};
