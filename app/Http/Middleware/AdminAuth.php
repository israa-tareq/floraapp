<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * Ensures only authenticated administrators can access protected admin routes.
     * Also applies anti-caching headers so browser history cannot display protected pages after logout.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('admin_authenticated')) {
            return redirect()->guest(route('admin.login'));
        }

        $response = $next($request);

        // Prevent browser caching of sensitive admin pages
        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }
}
