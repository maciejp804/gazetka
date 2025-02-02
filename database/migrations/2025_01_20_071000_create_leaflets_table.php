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
        Schema::create('leaflets', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->foreignId('shop_id')->constrained('shops')->onDelete('cascade');
            $table->string('title');
            $table->text('description_short')->nullable();
            $table->text('description_long')->nullable();
            $table->string('slug');
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
            $table->timestamp('display_from')->nullable();
            $table->timestamp('display_to')->nullable();
            $table->boolean('require_age_verification')->default(false);
            $table->boolean('pinned')->default(false);
            $table->integer('priority')->default(0);
            // $table->integer('pages'); // Rozważ usunięcie, jeśli używasz tabeli łącznikowej
            $table->enum('status', ['draft', 'published', 'archive'])->default('published');
            $table->boolean('for_all_stores')->default(true);
            $table->string('image_cover')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Dodaj indeksy dla lepszej wydajności
            $table->index('shop_id');
            $table->index('status');
            $table->index(['valid_from', 'valid_to']);
            $table->index(['display_from', 'display_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaflets');
    }
};
