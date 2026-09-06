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
        Schema::table('ecosystem_impact_pillars', function (Blueprint $table) {
            $table->string('youtube_url')->nullable()->after('target_beneficiaries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecosystem_impact_pillars', function (Blueprint $table) {
            $table->dropColumn('youtube_url');
        });
    }
};
