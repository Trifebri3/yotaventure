<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'session_id',
        'url',
        'path',
        'method',
        'referer',
        'user_agent',
        'device',
        'browser',
        'os',
        'country',
        'city',
        'country_code',
        'is_bot',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_bot' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope for real human visitors (excluding search bots/crawlers)
     */
    public function scopeRealVisitors(Builder $query): Builder
    {
        return $query->where('is_bot', false);
    }

    /**
     * Scope for search bots and crawlers (Googlebot, Bingbot, etc.)
     */
    public function scopeBots(Builder $query): Builder
    {
        return $query->where('is_bot', true);
    }

    /**
     * Filter logs for today
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    /**
     * Filter logs for the current week
     */
    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ]);
    }

    /**
     * Filter logs for the current month
     */
    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ]);
    }

    /**
     * Filter by given period key: today, 7d, 30d, all
     */
    public function scopeForPeriod(Builder $query, ?string $period): Builder
    {
        return match ($period) {
            'today' => $query->whereDate('created_at', Carbon::today()),
            '7d' => $query->where('created_at', '>=', Carbon::now()->subDays(7)),
            '30d' => $query->where('created_at', '>=', Carbon::now()->subDays(30)),
            default => $query,
        };
    }

    /**
     * Get masked IP address for public display or compliance
     */
    public function getMaskedIpAttribute(): string
    {
        if (filter_var($this->ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $parts = explode('.', $this->ip_address);
            if (count($parts) === 4) {
                return $parts[0].'.'.$parts[1].'.*.*';
            }
        }

        return substr($this->ip_address, 0, 8).'...';
    }

    /**
     * Formatted location string (e.g. "Jakarta, Indonesia")
     */
    public function getLocationStringAttribute(): string
    {
        if ($this->city && $this->country) {
            return "{$this->city}, {$this->country}";
        }

        return $this->country ?? ($this->city ?? 'Unknown');
    }
}
