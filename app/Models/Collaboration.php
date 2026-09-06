<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaboration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'slug',
        'title_id',
        'title_en',
        'badge_id',
        'badge_en',
        'subtitle_id',
        'subtitle_en',
        'description_id',
        'description_en',
        'terms_id',
        'terms_en',
        'requirements_id',
        'requirements_en',
        'steps_id',
        'steps_en',
        'email_to',
        'email_subject',
        'email_template',
        'sort_order',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'terms_id' => 'array',
            'terms_en' => 'array',
            'requirements_id' => 'array',
            'requirements_en' => 'array',
            'steps_id' => 'array',
            'steps_en' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Scope a query to only include active collaboration tracks.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by sort_order.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
