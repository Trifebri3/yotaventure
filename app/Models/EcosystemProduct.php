<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class EcosystemProduct extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'initiative_id',
        'name',
        'slug',
        'type',
        'problem_statement_id',
        'problem_statement_en',
        'solution_statement_id',
        'solution_statement_en',
        'description_id',
        'description_en',
        'story_id',
        'story_en',
        'hero_image',
        'cover_image',
        'website_url',
        'launch_date',
        'status',
        'visibility',
        'sort_order',
        'is_featured',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'launch_date' => 'date',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (EcosystemProduct $product): void {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
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
     * @return HasMany<EcosystemCategory, $this>
     */
    public function categories(): HasMany
    {
        return $this->hasMany(EcosystemCategory::class, 'product_id')->orderBy('sort_order');
    }

    /**
     * Scope for public visibility
     *
     * @param  Builder<EcosystemProduct>  $query
     * @return Builder<EcosystemProduct>
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('visibility', 'public')->orderBy('sort_order');
    }
}
