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
        Schema::create('people', function (Blueprint $table): void {
            $table->id();
            $table->string('category', 50)->index(); // founder, tim, kontributor
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('role_id');
            $table->string('role_en')->nullable();
            $table->text('bio_id')->nullable();
            $table->text('bio_en')->nullable();
            $table->string('photo', 1000)->nullable();
            $table->foreignId('initiative_id')->nullable()->constrained('ecosystem_initiatives')->nullOnDelete();
            $table->boolean('is_active')->default(true)->index();
            $table->string('contribution_type', 100)->nullable()->index(); // magang, riset, kerjasama, fellowship, komunitas
            $table->string('organization', 255)->nullable(); // Universitas, instansi, atau asal institusi
            $table->string('period', 100)->nullable(); // Periode / Batch
            $table->json('social_links')->nullable(); // instagram, linkedin, github, twitter, website, email
            $table->json('meta')->nullable(); // quote, skills, achievements, trajectory, philosophy, etc.
            $table->longText('story_html')->nullable(); // Personal manifesto / full story
            $table->integer('sort_order')->default(0)->index();
            $table->string('visibility', 50)->default('public')->index();
            $table->timestamps();
        });

        Schema::create('founder_stories', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('person_id')->nullable()->constrained('people')->nullOnDelete();
            $table->string('chapter_number', 50)->nullable(); // Prolog, Bab 01, Episode 1
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle', 500)->nullable();
            $table->string('cover_image', 1000)->nullable();
            $table->string('reading_time', 50)->nullable(); // "8 Menit Baca"
            $table->text('excerpt')->nullable();
            $table->longText('content_html'); // Novel / Cerpen panjang
            $table->string('status', 50)->default('published')->index();
            $table->dateTime('published_at')->nullable();
            $table->integer('sort_order')->default(0)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('founder_stories');
        Schema::dropIfExists('people');
    }
};
