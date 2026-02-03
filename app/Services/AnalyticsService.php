<?php

namespace App\Services;

use App\Models\Book;
use App\Models\PageView;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
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
            $ip = $request->ip();
            $country = $this->getCountryFromIp($ip);

            $visitor = Visitor::create([
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'device' => $parsed['device'],
                'browser' => $parsed['browser'],
                'os' => $parsed['os'],
                'country' => $country,
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
     * Get country from IP address using free API
     */
    protected function getCountryFromIp(string $ip): ?string
    {
        // Skip for local IPs
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost']) || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return 'Local';
        }

        // Cache country lookup for 24 hours
        return Cache::remember("ip_country_{$ip}", 86400, function () use ($ip) {
            try {
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=country");
                if ($response->successful() && $response->json('country')) {
                    return $response->json('country');
                }
            } catch (\Exception $e) {
                // Silently fail
            }
            return 'Unknown';
        });
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
            ->whereNotNull('device')
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
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'browser')
            ->toArray();
    }

    /**
     * Get country breakdown for map
     */
    public function getCountryBreakdown(): array
    {
        return Visitor::selectRaw('country, COUNT(*) as count')
            ->whereNotNull('country')
            ->where('country', '!=', 'Unknown')
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit(10)
            ->get()
            ->map(fn($item) => [
                'country' => $item->country,
                'count' => $item->count,
            ])
            ->toArray();
    }

    /**
     * Get top clicked/viewed books
     */
    public function getTopClickedBooks(int $limit = 5): array
    {
        return Book::select('id', 'title', 'author', 'cover_image', 'views_count')
            ->where('is_published', true)
            ->orderByDesc('views_count')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get recent visitors with details
     */
    public function getRecentVisitors(int $limit = 10): array
    {
        return Visitor::select('id', 'ip_address', 'device', 'browser', 'os', 'country', 'created_at')
            ->latest()
            ->limit($limit)
            ->get()
            ->map(fn($v) => [
                'id' => $v->id,
                'ip' => $this->maskIp($v->ip_address),
                'device' => $v->device,
                'browser' => $v->browser,
                'os' => $v->os,
                'country' => $v->country,
                'time' => $v->created_at->diffForHumans(),
            ])
            ->toArray();
    }

    /**
     * Mask IP address for privacy
     */
    protected function maskIp(string $ip): string
    {
        $parts = explode('.', $ip);
        if (count($parts) === 4) {
            return $parts[0] . '.' . $parts[1] . '.xxx.xxx';
        }
        return $ip;
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
