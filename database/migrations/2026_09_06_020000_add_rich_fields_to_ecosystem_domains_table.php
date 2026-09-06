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
        Schema::table('ecosystem_domains', function (Blueprint $table) {
            if (! Schema::hasColumn('ecosystem_domains', 'icon_image')) {
                $table->string('icon_image', 1000)->nullable()->after('icon');
            }
            if (! Schema::hasColumn('ecosystem_domains', 'sdgs')) {
                $table->json('sdgs')->nullable()->after('gallery');
            }
            if (! Schema::hasColumn('ecosystem_domains', 'issues')) {
                $table->json('issues')->nullable()->after('sdgs');
            }
            if (! Schema::hasColumn('ecosystem_domains', 'program_logos')) {
                $table->json('program_logos')->nullable()->after('issues');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecosystem_domains', function (Blueprint $table) {
            $columnsToDrop = [];
            foreach (['icon_image', 'sdgs', 'issues', 'program_logos'] as $column) {
                if (Schema::hasColumn('ecosystem_domains', $column)) {
                    $columnsToDrop[] = $column;
                }
            }
            if (! empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
