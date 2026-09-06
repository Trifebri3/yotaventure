<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->randomNumber(4),
            'type' => fake()->randomElement(['inisiatif', 'artikel', 'publikasi', 'jurnal', 'blog']),
            'tag' => 'Kedaulatan Digital • '.fake()->year(),
            'badge' => fake()->randomElement(['Riset AI Nasional', 'Inisiatif Strategis', 'Sains Maritim']),
            'excerpt' => fake()->paragraph(2),
            'content' => '<p>'.fake()->paragraphs(4, true).'</p>',
            'cover_image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=1200&auto=format&fit=crop',
            'author_name' => 'Tim Riset YOIN',
            'reading_time' => fake()->numberBetween(2, 8),
            'status' => 'published',
            'is_featured' => fake()->boolean(30),
            'views_count' => fake()->numberBetween(10, 1500),
            'meta_title' => $title.' | YOIN',
            'meta_description' => fake()->sentence(12),
            'meta_keywords' => 'inovasi, teknologi, digital, nusantara, riset',
            'canonical_url' => null,
            'published_at' => now()->subDays(fake()->numberBetween(0, 30)),
        ];
    }
}
