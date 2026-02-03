<?php

namespace App\Http\Middleware;

use App\Services\AnalyticsService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    protected AnalyticsService $analytics;

    public function __construct(AnalyticsService $analytics)
    {
        $this->analytics = $analytics;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking for admin routes and AJAX requests
        if ($request->is('admin/*') || $request->ajax() || $request->is('api/*')) {
            return $next($request);
        }

        // Skip tracking for bots
        $userAgent = $request->userAgent();
        if ($userAgent && preg_match('/bot|crawl|spider|slurp|bingpreview/i', $userAgent)) {
            return $next($request);
        }

        // Track the visitor
        $visitor = $this->analytics->trackVisitor($request);

        // Store visitor in request for later use (e.g., in controllers)
        $request->attributes->set('visitor', $visitor);

        return $next($request);
    }
}
