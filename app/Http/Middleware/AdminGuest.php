<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminGuest
{
    /**
     * Handle an incoming request.
     *
     * Ensures an already-authenticated administrator visiting the login page
     * is redirected directly to the admin dashboard.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('admin_authenticated')) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
