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
        // 1. ECOSYSTEM DOCUMENTS / ESG REPORTS (PDF & Links with mandatory cover)
        Schema::create('ecosystem_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title_id');
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->string('category', 100)->default('Laporan ESG'); // Laporan ESG, Whitepaper, Katalog Program, Audit Dampak, Riset Kebijakan, Lainnya
            $table->string('cover_image', 1000); // Wajib ada cover
            $table->string('file_path', 1000)->nullable(); // Uploaded file in storage
            $table->string('file_url', 1000)->nullable(); // External link or cloud URL
            $table->string('file_type', 50)->default('pdf'); // pdf, link, external
            $table->string('file_size', 50)->nullable(); // e.g. 4.8 MB
            $table->string('year', 20)->nullable(); // e.g. 2026
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('download_count')->default(0);
            $table->timestamps();
        });

        // 2. ECOSYSTEM 9 IMPACT PILLARS (Terhubung ke https://siyota.org)
        Schema::create('ecosystem_impact_pillars', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('pillar_number')->unique(); // 1 to 9
            $table->string('code', 100)->unique();
            $table->string('name'); // e.g. YOUTH DEVELOPMENT
            $table->string('title_id');
            $table->string('title_en')->nullable();
            $table->text('description_id');
            $table->text('description_en')->nullable();
            $table->string('photo_image', 1000);
            $table->string('target_url', 1000)->default('https://siyota.org');
            $table->string('action_label')->default('Lihat Aksi di siyota.org →');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecosystem_impact_pillars');
        Schema::dropIfExists('ecosystem_documents');
    }
};
