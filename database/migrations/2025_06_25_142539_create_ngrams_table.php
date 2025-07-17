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
        Schema::create('ngrams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('ngram'); // np. "chipsy paprykowe"
            $table->enum('type', ['bigram', 'trigram'])->default('bigram');
            $table->decimal('weight', 5,2)->default(1.0);
            $table->timestamps();

            $table->index(['ngram', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ngrams');
    }
};
