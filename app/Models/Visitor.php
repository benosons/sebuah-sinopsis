<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'device',
        'browser',
        'os',
        'country',
        'referrer',
        'session_id',
        'user_id',
    ];

    /**
     * Get the user associated with this visitor (if logged in)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all page views for this visitor
     */
    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }

    /**
     * Scope for today's visitors
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope for this week's visitors
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    /**
     * Scope for this month's visitors
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    /**
     * Scope for unique visitors (by IP)
     */
    public function scopeUnique($query)
    {
        return $query->distinct('ip_address');
    }
}
