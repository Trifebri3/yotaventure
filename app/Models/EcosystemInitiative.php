<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class EcosystemInitiative extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'domain_id',
        'name',
        'slug',
        'stage',
        'tagline_id',
        'tagline_en',
        'problem_statement_id',
        'problem_statement_en',
        'mission_id',
        'mission_en',
        'story_id',
        'story_en',
        'focus_areas',
        'sdgs',
        'government_issues',
        'locus',
        'logo_image',
        'hero_image',
        'cover_image',
        'gallery',
        'external_website_url',
        'external_url_label',
        'social_links',
        'contact_email',
        'status',
        'visibility',
        'sort_order',
        'is_featured',
        'meta_title',
        'meta_description',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'focus_areas' => 'array',
            'sdgs' => 'array',
            'government_issues' => 'array',
            'gallery' => 'array',
            'social_links' => 'array',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (EcosystemInitiative $initiative): void {
            if (empty($initiative->slug)) {
                $initiative->slug = Str::slug($initiative->name);
            }
            if (empty($initiative->external_url_label)) {
                $initiative->external_url_label = 'Visit Website →';
            }
        });
    }

    /**
     * @return BelongsTo<EcosystemDomain, $this>
     */
    public function domain(): BelongsTo
    {
        return $this->belongsTo(EcosystemDomain::class, 'domain_id');
    }

    /**
     * @return HasMany<EcosystemProduct, $this>
     */
    public function products(): HasMany
    {
        return $this->hasMany(EcosystemProduct::class, 'initiative_id')->orderBy('sort_order');
    }

    /**
     * @return HasMany<EcosystemProject, $this>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(EcosystemProject::class, 'initiative_id')->orderBy('sort_order');
    }

    /**
     * Scope for public visibility
     *
     * @param  Builder<EcosystemInitiative>  $query
     * @return Builder<EcosystemInitiative>
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('visibility', 'public')->orderBy('sort_order');
    }
}
