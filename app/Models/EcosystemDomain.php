<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

class EcosystemDomain extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name_id',
        'name_en',
        'slug',
        'tagline_id',
        'tagline_en',
        'problem_statement_id',
        'problem_statement_en',
        'solution_statement_id',
        'solution_statement_en',
        'short_description_id',
        'short_description_en',
        'long_description_id',
        'long_description_en',
        'hero_image',
        'cover_image',
        'icon',
        'icon_image',
        'gallery',
        'sdgs',
        'issues',
        'program_logos',
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
            'gallery' => 'array',
            'sdgs' => 'array',
            'issues' => 'array',
            'program_logos' => 'array',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (EcosystemDomain $domain): void {
            if (empty($domain->slug)) {
                $domain->slug = Str::slug($domain->name_en ?: $domain->name_id);
            }
        });
    }

    /**
     * @return HasMany<EcosystemInitiative, $this>
     */
    public function initiatives(): HasMany
    {
        return $this->hasMany(EcosystemInitiative::class, 'domain_id')->orderBy('sort_order');
    }

    /**
     * @return HasManyThrough<EcosystemProject, EcosystemInitiative, $this>
     */
    public function projects(): HasManyThrough
    {
        return $this->hasManyThrough(EcosystemProject::class, EcosystemInitiative::class, 'domain_id', 'initiative_id');
    }

    /**
     * Scope for public visibility
     *
     * @param  Builder<EcosystemDomain>  $query
     * @return Builder<EcosystemDomain>
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('visibility', 'public')->orderBy('sort_order');
    }
}
