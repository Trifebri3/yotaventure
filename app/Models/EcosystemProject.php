<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class EcosystemProject extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'initiative_id',
        'category_id',
        'type_id',
        'client_id',
        'name',
        'slug',
        'problem_statement_id',
        'problem_statement_en',
        'solution_statement_id',
        'solution_statement_en',
        'purpose_id',
        'purpose_en',
        'result_outcome_id',
        'result_outcome_en',
        'description_id',
        'description_en',
        'story_id',
        'story_en',
        'services_provided',
        'technologies',
        'hero_image',
        'cover_image',
        'gallery',
        'external_url',
        'launch_date',
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
            'services_provided' => 'array',
            'technologies' => 'array',
            'gallery' => 'array',
            'launch_date' => 'date',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (EcosystemProject $project): void {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->name);
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
     * @return BelongsTo<EcosystemCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EcosystemCategory::class, 'category_id');
    }

    /**
     * @return BelongsTo<EcosystemType, $this>
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(EcosystemType::class, 'type_id');
    }

    /**
     * @return BelongsTo<EcosystemClient, $this>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(EcosystemClient::class, 'client_id');
    }

    /**
     * Scope for public visibility
     *
     * @param  Builder<EcosystemProject>  $query
     * @return Builder<EcosystemProject>
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('visibility', 'public')->orderBy('sort_order');
    }
}
