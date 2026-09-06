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
        // 1. ECOSYSTEM IMPACT METRICS (Controlled via Admin)
        if (! Schema::hasTable('ecosystem_impact_metrics')) {
            Schema::create('ecosystem_impact_metrics', function (Blueprint $table) {
                $table->id();
                $table->string('metric_value', 100); // e.g. "50.000+", "9", "34", "100%"
                $table->string('label_id');
                $table->string('label_en')->nullable();
                $table->text('description_id')->nullable();
                $table->text('description_en')->nullable();
                $table->string('icon', 100)->nullable(); // e.g. "users", "leaf", "globe", "building"
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 2. ADD GALLERY & METRICS TO ECOSYSTEM IMPACT PILLARS
        Schema::table('ecosystem_impact_pillars', function (Blueprint $table) {
            if (! Schema::hasColumn('ecosystem_impact_pillars', 'gallery')) {
                $table->json('gallery')->nullable()->after('photo_image');
            }
            if (! Schema::hasColumn('ecosystem_impact_pillars', 'metric_value')) {
                $table->string('metric_value', 100)->nullable()->after('gallery');
            }
            if (! Schema::hasColumn('ecosystem_impact_pillars', 'metric_label_id')) {
                $table->string('metric_label_id')->nullable()->after('metric_value');
            }
            if (! Schema::hasColumn('ecosystem_impact_pillars', 'metric_label_en')) {
                $table->string('metric_label_en')->nullable()->after('metric_label_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecosystem_impact_metrics');

        Schema::table('ecosystem_impact_pillars', function (Blueprint $table) {
            $table->dropColumn(['gallery', 'metric_value', 'metric_label_id', 'metric_label_en']);
        });
    }
};
