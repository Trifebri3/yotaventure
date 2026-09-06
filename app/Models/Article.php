<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'title_en',
        'slug',
        'type',
        'tag',
        'tag_en',
        'badge',
        'badge_en',
        'excerpt',
        'excerpt_en',
        'content',
        'content_en',
        'cover_image',
        'author_name',
        'reading_time',
        'status',
        'is_featured',
        'views_count',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'published_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'views_count' => 'integer',
            'reading_time' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Bootstrap the model and its traits.
     */
    protected static function booted(): void
    {
        static::saving(function (Article $article): void {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }

            if (! empty($article->content) && ($article->reading_time <= 1 || $article->isDirty('content'))) {
                $wordCount = str_word_count(strip_tags($article->content));
                $article->reading_time = max(1, (int) ceil($wordCount / 180));
            }

            if ($article->status === 'published' && empty($article->published_at)) {
                $article->published_at = now();
            }
        });
    }

    /**
     * Scope a query to only include published articles.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include featured articles for sliders/showcase.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query by category type.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Increment the views count safely.
     */
    public function recordView(): void
    {
        $this->increment('views_count');
    }

    /**
     * Get translated title based on active language or parameter.
     */
    public function getTitle(string $lang = 'id'): string
    {
        if (strtolower($lang) === 'en' && ! empty($this->title_en)) {
            return $this->title_en;
        }

        return $this->title;
    }

    /**
     * Get translated excerpt.
     */
    public function getExcerpt(string $lang = 'id'): ?string
    {
        if (strtolower($lang) === 'en' && ! empty($this->excerpt_en)) {
            return $this->excerpt_en;
        }

        return $this->excerpt;
    }

    /**
     * Get translated content.
     */
    public function getContent(string $lang = 'id'): ?string
    {
        if (strtolower($lang) === 'en' && ! empty($this->content_en)) {
            return $this->content_en;
        }

        return $this->content;
    }

    /**
     * Get translated tag.
     */
    public function getTag(string $lang = 'id'): ?string
    {
        if (strtolower($lang) === 'en' && ! empty($this->tag_en)) {
            return $this->tag_en;
        }

        return $this->tag;
    }

    /**
     * Get translated badge.
     */
    public function getBadge(string $lang = 'id'): ?string
    {
        if (strtolower($lang) === 'en' && ! empty($this->badge_en)) {
            return $this->badge_en;
        }

        return $this->badge;
    }
}
