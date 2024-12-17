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
        Schema::table('voucher_categories', function (Blueprint $table) {
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('value')->unique();
            $table->boolean('status')->default(0);
            $table->string('logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voucher_categories', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('slug');
            $table->dropColumn('value');
            $table->dropColumn('status');
            $table->dropColumn('logo');
        });
    }
};
