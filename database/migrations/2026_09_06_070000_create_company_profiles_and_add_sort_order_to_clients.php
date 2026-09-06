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
        // 1. Ensure sort_order exists on ecosystem_clients
        if (Schema::hasTable('ecosystem_clients') && ! Schema::hasColumn('ecosystem_clients', 'sort_order')) {
            Schema::table('ecosystem_clients', function (Blueprint $table) {
                $table->integer('sort_order')->default(0)->after('is_active');
            });
        }

        // 2. Create company_profiles table
        if (! Schema::hasTable('company_profiles')) {
            Schema::create('company_profiles', function (Blueprint $table) {
                $table->id();
                $table->string('hero_badge')->nullable()->default('IDENTITAS RESMI PT YOTA INOVASI NUSANTARA');
                $table->string('company_name')->default('PT Yota Inovasi Nusantara');
                $table->string('tagline')->nullable()->default('Orkestrasi Inovasi Teknologi Berkelanjutan Nusantara');
                $table->text('summary')->nullable();
                $table->longText('content_html')->nullable();
                $table->string('hero_image', 1000)->nullable();
                $table->string('legal_entity_name')->default('PT Yota Inovasi Nusantara');
                $table->text('legal_registration_info')->nullable();
                $table->text('office_address')->nullable();
                $table->string('contact_email')->nullable()->default('hello@yotainovasi.id');
                $table->string('contact_phone')->nullable()->default('0858 6231 9524');
                $table->json('highlights')->nullable();
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');

        if (Schema::hasTable('ecosystem_clients') && Schema::hasColumn('ecosystem_clients', 'sort_order')) {
            Schema::table('ecosystem_clients', function (Blueprint $table) {
                $table->dropColumn('sort_order');
            });
        }
    }
};
