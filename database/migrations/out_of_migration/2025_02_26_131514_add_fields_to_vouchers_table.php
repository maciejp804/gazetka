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
        Schema::table('vouchers', function (Blueprint $table) {
            $table->enum('status', ['active', 'expired', 'draft'])->default('active')->after('end_date');
            $table->integer('usage_count')->default(0)->after('status');
            $table->tinyInteger('is_featured')->default(0)->after('usage_count');
            $table->string('offer_image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('is_featured');
            $table->dropColumn('usage_count');
        });
    }
};
