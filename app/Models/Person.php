<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Person extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'people';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'category',
        'name',
        'slug',
        'role_id',
        'role_en',
        'bio_id',
        'bio_en',
        'photo',
        'initiative_id',
        'is_active',
        'contribution_type',
        'organization',
        'period',
        'social_links',
        'meta',
        'story_html',
        'sort_order',
        'visibility',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'social_links' => 'array',
            'meta' => 'array',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Person $person): void {
            if (empty($person->slug)) {
                $person->slug = Str::slug($person->name);
            }
        });
    }

    /**
     * @return BelongsTo<EcosystemInitiative, $this>
     */
    public function initiative(): BelongsTo
    {
        return $this->belongsTo(EcosystemInitiative::class, 'initiative_id');
    }

    /**
     * @return HasMany<FounderStory, $this>
     */
    public function stories(): HasMany
    {
        return $this->hasMany(FounderStory::class, 'person_id');
    }

    /**
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     */
    public function scopeFounders(Builder $query): Builder
    {
        return $query->where('category', 'founder');
    }

    /**
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     */
    public function scopeTeam(Builder $query): Builder
    {
        return $query->where('category', 'tim');
    }

    /**
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     */
    public function scopeContributors(Builder $query): Builder
    {
        return $query->where('category', 'kontributor');
    }

    /**
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('visibility', 'public');
    }

    /**
     * Helper to retrieve social link URL safely.
     */
    public function getSocialLink(string $platform): ?string
    {
        return $this->social_links[$platform] ?? null;
    }

    /**
     * Helper to retrieve meta property safely.
     */
    public function getMeta(string $key, mixed $default = null): mixed
    {
        return $this->meta[$key] ?? $default;
    }
}
