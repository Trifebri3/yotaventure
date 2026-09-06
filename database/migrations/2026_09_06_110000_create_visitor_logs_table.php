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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->index();
            $table->string('session_id', 100)->nullable()->index();
            $table->string('url', 2048);
            $table->string('path', 255)->index();
            $table->string('method', 10)->default('GET');
            $table->text('referer')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device', 50)->nullable()->index(); // Desktop, Mobile, Tablet
            $table->string('browser', 50)->nullable()->index(); // Chrome, Safari, Firefox, Edge, etc.
            $table->string('os', 50)->nullable()->index(); // Windows, macOS, Android, iOS, Linux
            $table->string('country', 100)->nullable()->index();
            $table->string('city', 100)->nullable()->index();
            $table->string('country_code', 10)->nullable();
            $table->boolean('is_bot')->default(false)->index();
            $table->timestamps();

            // Compound index for time-series analytics
            $table->index(['created_at', 'is_bot']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
