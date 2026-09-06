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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('type')->default('artikel'); // inisiatif, artikel, publikasi, jurnal, blog
            $table->string('tag')->nullable(); // e.g. Kedaulatan Digital • 2026
            $table->string('badge')->nullable(); // e.g. Riset AI & Siber Nasional
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('author_name')->default('Tim Riset YOIN');
            $table->unsignedInteger('reading_time')->default(3); // in minutes
            $table->string('status')->default('published'); // published, draft
            $table->boolean('is_featured')->default(false); // for home slider
            $table->unsignedInteger('views_count')->default(0); // stats tracking

            // SEO Metadata
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();

            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
