<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollaborationInquiry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'category',
        'message',
        'status',
        'admin_notes',
        'ip_address',
        'user_agent',
        'read_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    /**
     * Scope for unread inquiries.
     */
    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at')->where('status', 'baru');
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }

        return $query;
    }

    /**
     * Helper to get clean WhatsApp link if phone is provided.
     */
    public function getWhatsappUrlAttribute(): ?string
    {
        if (empty($this->phone)) {
            return null;
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', $this->phone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62'.substr($cleanPhone, 1);
        } elseif (str_starts_with($cleanPhone, '8')) {
            $cleanPhone = '62'.$cleanPhone;
        }

        $text = rawurlencode("Halo {$this->name}, terima kasih telah mengajukan formulir kolaborasi di YOIN ({$this->category}). Kami dari Tim Kemitraan Strategis ingin berdiskusi lebih lanjut.");

        return "https://wa.me/{$cleanPhone}?text={$text}";
    }
}
