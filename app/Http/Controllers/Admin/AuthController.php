<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Display the single administrator login view.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Authenticate the administrator credentials.
     */
    public function login(Request $request)
    {
        // 1. Validate incoming form inputs
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Protect against brute-force attacks (5 attempts per minute per IP)
        $throttleKey = Str::transliterate(Str::lower($credentials['username']) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => "Too many failed login attempts. Please try again in {$seconds} seconds.",
                ]);
        }

        // 3. Load configured administrator credentials
        $expectedUsername = (string) config('admin.username');
        $expectedHash = (string) config('admin.password_hash');
        $expectedPlain = (string) config('admin.password');

        // 4. Verify username with constant-time comparison to prevent timing attacks
        $usernameValid = hash_equals($expectedUsername, $credentials['username']);

        // 5. Verify password against Bcrypt hash or plain-text fallback
        $passwordValid = false;

        if (! empty($expectedHash) && Hash::check($credentials['password'], $expectedHash)) {
            $passwordValid = true;
        } elseif (! empty($expectedPlain) && hash_equals($expectedPlain, $credentials['password'])) {
            $passwordValid = true;
        }

        // 6. If either check fails, record attempt and reject
        if (! $usernameValid || ! $passwordValid) {
            RateLimiter::hit($throttleKey, 60);

            return back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => 'The provided credentials do not match our records.',
                ]);
        }

        // 7. Successful authentication: clear rate limiter
        RateLimiter::clear($throttleKey);

        // 8. Regenerate session ID to prevent session fixation attacks
        $request->session()->regenerate();

        // 9. Store authenticated session flag
        $request->session()->put([
            'admin_authenticated' => true,
            'admin_username' => $expectedUsername,
            'admin_logged_in_at' => now()->toIso8601String(),
        ]);

        // 10. Redirect to intended protected page or default dashboard
        return redirect()->intended(route('admin.dashboard'))
            ->with('success', "Welcome back, {$expectedUsername}!");
    }

    /**
     * Log out the administrator and invalidate the session.
     */
    public function logout(Request $request)
    {
        // 1. Remove admin session variables
        $request->session()->forget([
            'admin_authenticated',
            'admin_username',
            'admin_logged_in_at',
        ]);

        // 2. Invalidate entire session and flush all data
        $request->session()->invalidate();

        // 3. Regenerate CSRF token
        $request->session()->regenerateToken();

        // 4. Redirect to login page with feedback
        return redirect()->route('admin.login')
            ->with('success', 'You have been successfully logged out.');
    }
}
