<?php

namespace App\Services;

use App\Models\Book;
use App\Models\PageView;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnalyticsService
{
    /**
     * Track a visitor and return the visitor model
     */
    public function trackVisitor(Request $request): Visitor
    {
        $sessionId = $request->session()->getId() ?: Str::uuid()->toString();

        // Try to find existing visitor by session
        $visitor = Visitor::where('session_id', $sessionId)->first();

        if (!$visitor) {
            $userAgent = $request->userAgent();
            $parsed = $this->parseUserAgent($userAgent);

            $visitor = Visitor::create([
                'ip_address' => $request->ip(),
                'user_agent' => $userAgent,
                'device' => $parsed['device'],
                'browser' => $parsed['browser'],
                'os' => $parsed['os'],
                'referrer' => $request->header('referer'),
                'session_id' => $sessionId,
                'user_id' => auth()->id(),
            ]);
        } else {
            // Update last activity
            $visitor->touch();
            
            // Update user_id if they logged in
            if (auth()->check() && !$visitor->user_id) {
                $visitor->update(['user_id' => auth()->id()]);
            }
        }

        return $visitor;
    }

    /**
     * Track a page view
     */
    public function trackPageView(Request $request, Visitor $visitor, $viewable = null, ?string $pageTitle = null): PageView
    {
        $data = [
            'visitor_id' => $visitor->id,
            'url' => $request->fullUrl(),
            'page_title' => $pageTitle,
            'created_at' => now(),
        ];

        if ($viewable) {
            $data['viewable_type'] = get_class($viewable);
            $data['viewable_id'] = $viewable->id;

            // Increment view count on the model if it has views_count
            if ($viewable instanceof Book) {
                $viewable->increment('views_count');
            }
        }

        return PageView::create($data);
    }

    /**
     * Parse user agent to extract device, browser, and OS
     */
    protected function parseUserAgent(?string $userAgent): array
    {
        if (!$userAgent) {
            return ['device' => 'unknown', 'browser' => 'unknown', 'os' => 'unknown'];
        }

        // Device detection
        $device = 'desktop';
        if (preg_match('/mobile|android|iphone|ipad|ipod|blackberry|opera mini|iemobile/i', $userAgent)) {
            $device = preg_match('/ipad|tablet/i', $userAgent) ? 'tablet' : 'mobile';
        }

        // Browser detection
        $browser = 'unknown';
        if (preg_match('/MSIE|Trident/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent) && !preg_match('/Edge|Edg/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edge|Edg/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/Opera|OPR/i', $userAgent)) {
            $browser = 'Opera';
        }

        // OS detection
        $os = 'unknown';
        if (preg_match('/Windows NT 10/i', $userAgent)) {
            $os = 'Windows 10/11';
        } elseif (preg_match('/Windows NT/i', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/Mac OS X/i', $userAgent)) {
            $os = 'macOS';
        } elseif (preg_match('/Linux/i', $userAgent) && !preg_match('/Android/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $os = 'Android';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            $os = 'iOS';
        }

        return compact('device', 'browser', 'os');
    }

    /**
     * Get analytics summary
     */
    public function getSummary(): array
    {
        return [
            'total_visitors' => Visitor::count(),
            'visitors_today' => Visitor::today()->count(),
            'visitors_this_week' => Visitor::thisWeek()->count(),
            'visitors_this_month' => Visitor::thisMonth()->count(),
            'total_page_views' => PageView::count(),
            'page_views_today' => PageView::today()->count(),
            'page_views_this_week' => PageView::thisWeek()->count(),
            'page_views_this_month' => PageView::thisMonth()->count(),
            'unique_visitors_today' => Visitor::today()->distinct('ip_address')->count('ip_address'),
        ];
    }

    /**
     * Get device breakdown
     */
    public function getDeviceBreakdown(): array
    {
        return Visitor::selectRaw('device, COUNT(*) as count')
            ->groupBy('device')
            ->pluck('count', 'device')
            ->toArray();
    }

    /**
     * Get browser breakdown
     */
    public function getBrowserBreakdown(): array
    {
        return Visitor::selectRaw('browser, COUNT(*) as count')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'browser')
            ->toArray();
    }

    /**
     * Get daily views for chart
     */
    public function getDailyViewsChart(int $days = 7): array
    {
        $labels = [];
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('D');
            $data[] = PageView::whereDate('created_at', $date->format('Y-m-d'))->count();
        }

        return compact('labels', 'data');
    }
}
