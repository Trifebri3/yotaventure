<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class EcosystemCategory extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'product_id',
        'name_id',
        'name_en',
        'slug',
        'description_id',
        'description_en',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (EcosystemCategory $category): void {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name_en ?: $category->name_id);
            }
        });
    }

    /**
     * @return BelongsTo<EcosystemProduct, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(EcosystemProduct::class, 'product_id');
    }

    /**
     * @return HasMany<EcosystemType, $this>
     */
    public function types(): HasMany
    {
        return $this->hasMany(EcosystemType::class, 'category_id')->orderBy('sort_order');
    }

    /**
     * @return HasMany<EcosystemProject, $this>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(EcosystemProject::class, 'category_id')->orderBy('sort_order');
    }
}
