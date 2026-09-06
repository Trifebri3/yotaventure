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
            $table->text('why_it_matters_id')->nullable()->after('description_en');
            $table->text('why_it_matters_en')->nullable()->after('why_it_matters_id');
            $table->text('what_we_do_id')->nullable()->after('why_it_matters_en');
            $table->text('what_we_do_en')->nullable()->after('what_we_do_id');
            $table->json('sdgs')->nullable()->after('what_we_do_en');
            $table->json('global_programs')->nullable()->after('sdgs');
            $table->json('national_programs')->nullable()->after('global_programs');
            $table->string('target_beneficiaries')->nullable()->after('national_programs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecosystem_impact_pillars', function (Blueprint $table) {
            $table->dropColumn([
                'why_it_matters_id',
                'why_it_matters_en',
                'what_we_do_id',
                'what_we_do_en',
                'sdgs',
                'global_programs',
                'national_programs',
                'target_beneficiaries',
            ]);
        });
    }
};
