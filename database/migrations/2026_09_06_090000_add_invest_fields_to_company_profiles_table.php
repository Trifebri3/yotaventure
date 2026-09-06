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
        if (Schema::hasTable('company_profiles')) {
            Schema::table('company_profiles', function (Blueprint $table) {
                if (! Schema::hasColumn('company_profiles', 'invest_badge')) {
                    $table->string('invest_badge')->nullable()->default('VENTURE ECOSYSTEM BUILDER');
                }
                if (! Schema::hasColumn('company_profiles', 'invest_title')) {
                    $table->string('invest_title')->nullable()->default('Building Companies From the Ground Up');
                }
                if (! Schema::hasColumn('company_profiles', 'invest_subtitle')) {
                    $table->string('invest_subtitle')->nullable()->default('YOTA Inovasi Nusantara');
                }
                if (! Schema::hasColumn('company_profiles', 'invest_summary')) {
                    $table->text('invest_summary')->nullable();
                }
                if (! Schema::hasColumn('company_profiles', 'invest_content_html')) {
                    $table->longText('invest_content_html')->nullable();
                }
                if (! Schema::hasColumn('company_profiles', 'invest_metrics')) {
                    $table->json('invest_metrics')->nullable();
                }
                if (! Schema::hasColumn('company_profiles', 'invest_deck_url')) {
                    $table->string('invest_deck_url', 1000)->nullable();
                }
                if (! Schema::hasColumn('company_profiles', 'invest_data_room_url')) {
                    $table->string('invest_data_room_url', 1000)->nullable();
                }
                if (! Schema::hasColumn('company_profiles', 'invest_resources')) {
                    $table->json('invest_resources')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('company_profiles')) {
            Schema::table('company_profiles', function (Blueprint $table) {
                $columns = [
                    'invest_badge',
                    'invest_title',
                    'invest_subtitle',
                    'invest_summary',
                    'invest_content_html',
                    'invest_metrics',
                    'invest_deck_url',
                    'invest_data_room_url',
                    'invest_resources',
                ];
                foreach ($columns as $col) {
                    if (Schema::hasColumn('company_profiles', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
