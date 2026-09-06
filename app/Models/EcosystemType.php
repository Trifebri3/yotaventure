<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class EcosystemType extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
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
        static::saving(function (EcosystemType $type): void {
            if (empty($type->slug)) {
                $type->slug = Str::slug($type->name_en ?: $type->name_id);
            }
        });
    }

    /**
     * @return BelongsTo<EcosystemCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EcosystemCategory::class, 'category_id');
    }

    /**
     * @return HasMany<EcosystemProject, $this>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(EcosystemProject::class, 'type_id')->orderBy('sort_order');
    }
}
