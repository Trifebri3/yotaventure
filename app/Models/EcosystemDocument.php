<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcosystemDocument extends Model
{
    use HasFactory;

    protected $table = 'ecosystem_documents';

    protected $fillable = [
        'title_id',
        'title_en',
        'slug',
        'category',
        'cover_image',
        'file_path',
        'file_url',
        'file_type',
        'file_size',
        'year',
        'description_id',
        'description_en',
        'is_active',
        'sort_order',
        'download_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'download_count' => 'integer',
    ];

    /**
     * Scope only active documents
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get effective target link (file upload path or external url)
     */
    public function getDownloadUrlAttribute(): string
    {
        if ($this->file_path) {
            return $this->file_path;
        }

        return $this->file_url ?: '#';
    }

    /**
     * Check if document has a direct downloadable PDF file
     */
    public function getIsPdfAttribute(): bool
    {
        return $this->file_type === 'pdf' || str_ends_with(strtolower((string) $this->file_path), '.pdf') || str_ends_with(strtolower((string) $this->file_url), '.pdf');
    }
}
