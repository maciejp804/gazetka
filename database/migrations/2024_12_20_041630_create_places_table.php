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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voivodeship_id')->constrained('voivodeships');
            $table->foreignId('county_id')->constrained('counties');
            $table->foreignId('commune_id')->constrained('communes');
            $table->string('name');
            $table->string('name_genitive');
            $table->string('name_locative');
            $table->string('slug')->unique();
            $table->bigInteger('population')->nullable();
            $table->double('surface')->nullable();
            $table->integer('foundation')->nullable();
            $table->decimal('lat', 10,8)->nullable();
            $table->decimal('lng', 10,8)->nullable();
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
