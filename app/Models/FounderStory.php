<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class FounderStory extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'founder_stories';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'person_id',
        'chapter_number',
        'title',
        'slug',
        'subtitle',
        'cover_image',
        'reading_time',
        'excerpt',
        'content_html',
        'status',
        'published_at',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (FounderStory $story): void {
            if (empty($story->slug)) {
                $story->slug = Str::slug(($story->chapter_number ? $story->chapter_number.'-' : '').$story->title);
            }
        });
    }

    /**
     * @return BelongsTo<Person, $this>
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    /**
     * @return BelongsTo<Person, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    /**
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}
