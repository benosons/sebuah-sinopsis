<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PageView extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'visitor_id',
        'viewable_type',
        'viewable_id',
        'url',
        'page_title',
        'time_on_page',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the visitor for this page view
     */
    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }

    /**
     * Get the viewable model (Book, etc.)
     */
    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope for today's page views
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope for this week's page views
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    /**
     * Scope for this month's page views
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    /**
     * Scope for a specific viewable type
     */
    public function scopeForType($query, string $type)
    {
        return $query->where('viewable_type', $type);
    }

    /**
     * Get daily views for the last N days
     */
    public static function getDailyViews(int $days = 7): array
    {
        $result = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $result[$date] = self::whereDate('created_at', $date)->count();
        }

        return $result;
    }
}
