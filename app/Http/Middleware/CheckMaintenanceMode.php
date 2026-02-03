<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if maintenance mode is enabled
        if (Setting::isMaintenanceMode()) {
            // Allow admin users to bypass maintenance mode
            if (auth()->check() && auth()->user()->hasRole('Super-Admin')) {
                return $next($request);
            }

            // Show maintenance page for everyone else
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
