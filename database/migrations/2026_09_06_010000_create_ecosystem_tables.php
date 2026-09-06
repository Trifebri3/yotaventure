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
        // 1. DOMAINS: The macro arenas where YOTA builds (Digital, Agriculture, Impact, etc.)
        Schema::create('ecosystem_domains', function (Blueprint $table) {
            $table->id();
            $table->string('name_id');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->string('tagline_id')->nullable();
            $table->string('tagline_en')->nullable();

            // Clear Problem Statement & Solution Direction
            $table->text('problem_statement_id')->nullable();
            $table->text('problem_statement_en')->nullable();
            $table->text('solution_statement_id')->nullable();
            $table->text('solution_statement_en')->nullable();

            $table->text('short_description_id')->nullable();
            $table->text('short_description_en')->nullable();
            $table->longText('long_description_id')->nullable();
            $table->longText('long_description_en')->nullable();

            $table->string('hero_image', 1000)->nullable();
            $table->string('cover_image', 1000)->nullable();
            $table->string('icon', 255)->nullable();
            $table->json('gallery')->nullable();

            $table->string('status', 50)->default('OPERATING'); // IDEA, PLANNING, BUILDING, DEVELOPING, OPERATING, COMPLETED, ARCHIVED
            $table->string('visibility', 50)->default('public'); // public, private, draft, archived
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        // 2. INITIATIVES / BRANDS: The entities living under Domains (YOIN Digital, AGRONEX, YAC, etc.)
        Schema::create('ecosystem_initiatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('domain_id')->constrained('ecosystem_domains')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('stage', 100)->default('Venture'); // Venture, Social Initiative, Tech Brand, Product Brand, Movement, Foundation

            $table->string('tagline_id')->nullable();
            $table->string('tagline_en')->nullable();

            // Clear Problem Statement: Why this initiative/brand exists
            $table->text('problem_statement_id')->nullable();
            $table->text('problem_statement_en')->nullable();

            $table->text('mission_id')->nullable();
            $table->text('mission_en')->nullable();
            $table->longText('story_id')->nullable();
            $table->longText('story_en')->nullable();

            $table->json('focus_areas')->nullable(); // JSON array of focus badges
            $table->json('sdgs')->nullable();
            $table->json('government_issues')->nullable();
            $table->string('locus')->nullable();

            $table->string('logo_image', 1000)->nullable();
            $table->string('hero_image', 1000)->nullable();
            $table->string('cover_image', 1000)->nullable();
            $table->json('gallery')->nullable();

            // Gateway to official brand website
            $table->string('external_website_url', 1000)->nullable();
            $table->string('external_url_label')->default('Visit Website →');

            $table->json('social_links')->nullable();
            $table->string('contact_email')->nullable();

            $table->string('status', 50)->default('OPERATING');
            $table->string('visibility', 50)->default('public');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        // 3. PRODUCTS / MOVEMENTS: Products, programs, or movements spawned by an Initiative
        Schema::create('ecosystem_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('initiative_id')->constrained('ecosystem_initiatives')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type', 50)->default('product'); // product, movement, platform, program, service

            // Clear Problem Statement: The real problem this product/movement solves
            $table->text('problem_statement_id')->nullable();
            $table->text('problem_statement_en')->nullable();
            $table->text('solution_statement_id')->nullable();
            $table->text('solution_statement_en')->nullable();

            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->longText('story_id')->nullable();
            $table->longText('story_en')->nullable();

            $table->string('hero_image', 1000)->nullable();
            $table->string('cover_image', 1000)->nullable();
            $table->string('website_url', 1000)->nullable();
            $table->date('launch_date')->nullable();

            $table->string('status', 50)->default('OPERATING');
            $table->string('visibility', 50)->default('public');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        // 4. CATEGORIES: Grouping of activities/products under a Product/Movement
        Schema::create('ecosystem_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('ecosystem_products')->cascadeOnDelete();
            $table->string('name_id');
            $table->string('name_en');
            $table->string('slug');
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 5. TYPES: Granular classifications under a Category
        Schema::create('ecosystem_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('ecosystem_categories')->cascadeOnDelete();
            $table->string('name_id');
            $table->string('name_en');
            $table->string('slug');
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 6. CLIENTS: Client / Partner directory
        Schema::create('ecosystem_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo_image', 1000)->nullable();
            $table->string('client_type', 100)->default('Enterprise'); // Enterprise, Government, NGO, Community, Individual, Internal
            $table->string('industry', 100)->nullable();
            $table->string('location')->nullable();
            $table->string('website_url', 1000)->nullable();
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 7. PROJECTS / PORTFOLIO / WORKS: Real tangible works produced in the ecosystem
        Schema::create('ecosystem_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('initiative_id')->constrained('ecosystem_initiatives')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('ecosystem_categories')->cascadeOnDelete();
            $table->foreignId('type_id')->nullable()->constrained('ecosystem_types')->nullOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('ecosystem_clients')->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();

            // Clear Problem Statement: Real field/client challenge tackled
            $table->text('problem_statement_id')->nullable();
            $table->text('problem_statement_en')->nullable();

            // Solution & Purpose
            $table->text('solution_statement_id')->nullable();
            $table->text('solution_statement_en')->nullable();
            $table->text('purpose_id')->nullable();
            $table->text('purpose_en')->nullable();

            // Measurable Outcome & Real Impact
            $table->text('result_outcome_id')->nullable();
            $table->text('result_outcome_en')->nullable();

            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->longText('story_id')->nullable();
            $table->longText('story_en')->nullable();

            $table->json('services_provided')->nullable(); // JSON array
            $table->json('technologies')->nullable(); // JSON array

            $table->string('hero_image', 1000)->nullable();
            $table->string('cover_image', 1000)->nullable();
            $table->json('gallery')->nullable();
            $table->string('external_url', 1000)->nullable();
            $table->date('launch_date')->nullable();

            $table->string('status', 50)->default('COMPLETED'); // PLANNING, BUILDING, OPERATING, COMPLETED, ARCHIVED
            $table->string('visibility', 50)->default('public'); // public, private, draft, archived
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecosystem_projects');
        Schema::dropIfExists('ecosystem_clients');
        Schema::dropIfExists('ecosystem_types');
        Schema::dropIfExists('ecosystem_categories');
        Schema::dropIfExists('ecosystem_products');
        Schema::dropIfExists('ecosystem_initiatives');
        Schema::dropIfExists('ecosystem_domains');
    }
};
