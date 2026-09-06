<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcosystemImpactPillar extends Model
{
    use HasFactory;

    protected $table = 'ecosystem_impact_pillars';

    protected $fillable = [
        'pillar_number',
        'code',
        'name',
        'title_id',
        'title_en',
        'description_id',
        'description_en',
        'why_it_matters_id',
        'why_it_matters_en',
        'what_we_do_id',
        'what_we_do_en',
        'sdgs',
        'global_programs',
        'national_programs',
        'target_beneficiaries',
        'youtube_url',
        'photo_image',
        'gallery',
        'metric_value',
        'metric_label_id',
        'metric_label_en',
        'target_url',
        'action_label',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'pillar_number' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'gallery' => 'array',
        'sdgs' => 'array',
        'global_programs' => 'array',
        'national_programs' => 'array',
    ];

    protected $appends = [
        'youtube_embed_url',
    ];

    /**
     * Scope only active pillars ordered by pillar number
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('pillar_number');
    }

    /**
     * Ensure gallery is always an array of image URLs
     *
     * @return array<int, string>
     */
    public function getGalleryAttribute($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return [];
    }

    /**
     * Dynamic title accessor
     */
    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && ! empty($this->title_en)) {
            return $this->title_en;
        }

        return $this->title_id ?? '';
    }

    /**
     * Dynamic description accessor
     */
    public function getDescriptionAttribute(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && ! empty($this->description_en)) {
            return $this->description_en;
        }

        return $this->description_id ?? '';
    }

    /**
     * Dynamic why_it_matters accessor
     */
    public function getWhyItMattersAttribute(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && ! empty($this->why_it_matters_en)) {
            return $this->why_it_matters_en;
        }

        return $this->why_it_matters_id ?? '';
    }

    /**
     * Dynamic what_we_do accessor
     */
    public function getWhatWeDoAttribute(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && ! empty($this->what_we_do_en)) {
            return $this->what_we_do_en;
        }

        return $this->what_we_do_id ?? '';
    }

    /**
     * Dynamic metric_label accessor
     */
    public function getMetricLabelAttribute(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && ! empty($this->metric_label_en)) {
            return $this->metric_label_en;
        }

        return $this->metric_label_id ?? '';
    }

    /**
     * Extract responsive YouTube embed URL from standard/shortened YouTube links
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (empty($this->youtube_url)) {
            return null;
        }

        $url = trim($this->youtube_url);

        // Pattern matching standard watch, shortened youtu.be, embed, or shorts
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            return 'https://www.youtube-nocookie.com/embed/'.$matches[1].'?rel=0';
        }

        // If it's already an embed URL
        if (str_contains($url, 'youtube.com/embed/') || str_contains($url, 'youtube-nocookie.com/embed/')) {
            return $url;
        }

        return null;
    }
}
