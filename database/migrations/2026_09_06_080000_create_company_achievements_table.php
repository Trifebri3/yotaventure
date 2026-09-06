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
        // 1. Create company_achievements table
        if (! Schema::hasTable('company_achievements')) {
            Schema::create('company_achievements', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('category', 100)->default('Penghargaan'); // Penghargaan, Sertifikasi, Rekognisi Pemerintah, HAKI & Paten, Prestasi, Kemitraan
                $table->string('issuer')->nullable(); // Badan / Lembaga Penerbit (BRIN, Kemenkomdigi, ISO, dsb.)
                $table->string('year', 50)->nullable(); // Tahun atau bulan perolehan
                $table->string('image', 1000)->nullable(); // Foto sertifikat / plakat / piala
                $table->json('photos')->nullable(); // Galeri banyak foto
                $table->text('description')->nullable(); // Deskripsi bebas pencapaian
                $table->string('credential_url', 1000)->nullable(); // Link verifikasi digital / berita
                $table->string('badge_label', 100)->nullable(); // Label kecil seperti "Nasional", "Internasional", "Terakreditasi"
                $table->integer('sort_order')->default(0);
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            if (! Schema::hasColumn('company_achievements', 'photos')) {
                Schema::table('company_achievements', function (Blueprint $table) {
                    $table->json('photos')->nullable()->after('image');
                });
            }
        }

        // 2. Add achievement narrative fields to company_profiles table
        if (Schema::hasTable('company_profiles')) {
            Schema::table('company_profiles', function (Blueprint $table) {
                if (! Schema::hasColumn('company_profiles', 'achievement_badge')) {
                    $table->string('achievement_badge')->nullable()->default('REKOGNISI & REKAM JEJAK NUSANTARA');
                }
                if (! Schema::hasColumn('company_profiles', 'achievement_title')) {
                    $table->string('achievement_title')->nullable()->default('Pencapaian, Penghargaan & Sertifikasi Resmi');
                }
                if (! Schema::hasColumn('company_profiles', 'achievement_summary')) {
                    $table->text('achievement_summary')->nullable();
                }
                if (! Schema::hasColumn('company_profiles', 'achievement_content_html')) {
                    $table->longText('achievement_content_html')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_achievements');

        if (Schema::hasTable('company_profiles')) {
            Schema::table('company_profiles', function (Blueprint $table) {
                $columns = ['achievement_badge', 'achievement_title', 'achievement_summary', 'achievement_content_html'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('company_profiles', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
