<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcosystemImpactMetric extends Model
{
    use HasFactory;

    protected $table = 'ecosystem_impact_metrics';

    protected $fillable = [
        'metric_value',
        'label_id',
        'label_en',
        'description_id',
        'description_en',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope for active metrics
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Dynamic label accessor based on app locale
     */
    public function getLabelAttribute(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && ! empty($this->label_en)) {
            return $this->label_en;
        }

        return $this->label_id ?? '';
    }

    /**
     * Dynamic description accessor based on app locale
     */
    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && ! empty($this->description_en)) {
            return $this->description_en;
        }

        return $this->description_id;
    }
}
