<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class EcosystemClient extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'logo_image',
        'client_type',
        'industry',
        'location',
        'website_url',
        'description_id',
        'description_en',
        'is_active',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (EcosystemClient $client): void {
            if (empty($client->slug)) {
                $client->slug = Str::slug($client->name);
            }
        });
    }

    /**
     * @param  Builder<EcosystemClient>  $query
     * @return Builder<EcosystemClient>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @return HasMany<EcosystemProject, $this>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(EcosystemProject::class, 'client_id');
    }

    /**
     * Accessor aliases for ecosystem compatibility
     */
    public function getCategoryAttribute(): ?string
    {
        return $this->client_type;
    }

    public function getLogoAttribute(): ?string
    {
        return $this->logo_image;
    }

    public function getWebsiteAttribute(): ?string
    {
        return $this->website_url;
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->description_id;
    }
}
