<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAchievement extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'category',
        'issuer',
        'year',
        'image',
        'photos',
        'description',
        'credential_url',
        'badge_label',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'photos' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Get all photos for this achievement, combining primary image and additional photos.
     *
     * @return list<string>
     */
    public function getAllPhotosAttribute(): array
    {
        $photos = is_array($this->photos) ? $this->photos : [];
        if (! empty($this->image) && ! in_array($this->image, $photos, true)) {
            array_unshift($photos, $this->image);
        }

        return array_values(array_filter($photos));
    }

    /**
     * @param  Builder<CompanyAchievement>  $query
     * @return Builder<CompanyAchievement>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @param  Builder<CompanyAchievement>  $query
     * @return Builder<CompanyAchievement>
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
}
