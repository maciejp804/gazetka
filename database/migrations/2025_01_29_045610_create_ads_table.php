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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('ad_unit_id')->nullable(); // ID reklamy (dla Google Ads)
            $table->string('network'); // Sieć reklamowa (np. google, tradedoubler, monitizemore)
            $table->string('ad_type'); // Typ reklamy (banner, iframe, script)
            $table->string('target_url')->nullable(); // Docelowy URL
            $table->text('code')->nullable(); // Pełny kod reklamy (dla TradeDoubler)
            $table->string('size')->nullable(); // Rozmiar reklamy (np. 300x600)
            $table->integer('timeout')->default(200); // Timeout ładowania
            $table->enum('status',['draft', 'published', 'archive'])->default('published'); // Aktywność reklamy
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
