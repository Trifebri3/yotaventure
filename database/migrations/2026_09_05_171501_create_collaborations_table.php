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
        Schema::create('collaborations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_id');
            $table->string('title_en');
            $table->string('badge_id')->nullable();
            $table->string('badge_en')->nullable();
            $table->text('subtitle_id')->nullable();
            $table->text('subtitle_en')->nullable();
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->json('terms_id')->nullable();
            $table->json('terms_en')->nullable();
            $table->json('requirements_id')->nullable();
            $table->json('requirements_en')->nullable();
            $table->json('steps_id')->nullable();
            $table->json('steps_en')->nullable();
            $table->string('email_to')->default('hello@yotainovasi.id');
            $table->string('email_subject')->nullable();
            $table->text('email_template')->nullable();
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
        Schema::dropIfExists('collaborations');
    }
};
