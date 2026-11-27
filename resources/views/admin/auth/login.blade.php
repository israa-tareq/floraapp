@extends('layouts.auth')

@section('title', 'Login')

@section('content')

    <!-- Frosted Glass Login Card -->
    <div class="flora-login-card p-6 sm:p-8">

        <!-- Application Brand Header (Noticeably Larger Transparent Logo) -->
        <div class="text-center mb-6">
            <x-app-logo size="xl" class="mx-auto mb-3" />

            <h1 class="text-2xl font-bold text-[var(--flora-soldier-green)] tracking-tight">
                Flora
            </h1>
        </div>

        <form action="{{ route('admin.login.submit') }}" method="POST" novalidate class="space-y-4">
            @csrf

            <!-- Username Field -->
            <div>
                <label for="username" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-1.5">
                    Username
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[var(--flora-text-muted)]">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text"
                           id="username"
                           name="username"
                           value="{{ old('username') }}"
                           aria-required="true"
                           autofocus
                           autocomplete="username"
                           placeholder="Username"
                           class="flora-input flora-input-with-icon @error('username') flora-input-error @enderror">
                </div>
                @error('username')
                    <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5 flex items-center gap-1.5" role="alert">
                        <i class="fa-solid fa-circle-exclamation shrink-0"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-1.5">
                    Password
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[var(--flora-text-muted)]">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password"
                           id="password"
                           name="password"
                           aria-required="true"
                           autocomplete="current-password"
                           placeholder="Password"
                           class="flora-input flora-input-with-icon flora-input-with-toggle @error('password') flora-input-error @enderror">

                    <!-- Show / Hide Password Toggle -->
                    <button type="button"
                            id="togglePasswordBtn"
                            onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[var(--flora-text-muted)] hover:text-[var(--flora-soldier-green)] transition"
                            aria-label="Toggle password visibility">
                        <i class="fa-solid fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5 flex items-center gap-1.5" role="alert">
                        <i class="fa-solid fa-circle-exclamation shrink-0"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Submit Button -->
            <x-button type="submit" variant="primary" class="w-full py-3 mt-1">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>Log In</span>
            </x-button>
        </form>

        <!-- Visual Placeholders Underneath Existing Login Form (Ready for Future Integration) -->
        <div class="mt-5 pt-5 border-t border-[var(--flora-border-subtle)] space-y-4">

            <!-- Simple CAPTCHA-Style Visual Checkbox Placeholder -->
            <label for="captcha_placeholder"
                   class="flora-captcha-box px-4 py-3 flex items-center justify-between gap-3 cursor-pointer">
                <span class="flex items-center gap-3">
                    <input type="checkbox"
                           id="captcha_placeholder"
                           class="w-4 h-4 rounded accent-[var(--flora-usukoubai)]">
                    <span class="text-sm font-medium text-[var(--flora-soldier-green)]">
                        I'm not a robot
                    </span>
                </span>
                <span class="text-[var(--flora-text-muted)] text-base" aria-hidden="true">
                    <i class="fa-solid fa-shield-halved"></i>
                </span>
            </label>

            <!-- Divider -->
            <div class="flex items-center gap-3">
                <span class="flex-1 h-px bg-[var(--flora-border-subtle)]"></span>
                <span class="text-xs font-semibold uppercase tracking-wider text-[var(--flora-text-muted)]">or</span>
                <span class="flex-1 h-px bg-[var(--flora-border-subtle)]"></span>
            </div>

            <!-- Google Sign-In Visual Placeholder Button -->
            <button type="button"
                    data-placeholder-auth="google"
                    onclick="notifyPlaceholder('Google sign-in is not connected yet.')"
                    class="flora-oauth-btn w-full inline-flex items-center justify-center gap-2.5 px-4 py-2.5 text-sm font-semibold">
                <i class="fa-brands fa-google text-base"></i>
                <span>Continue with Google</span>
            </button>

            <!-- Sign Up Visual Placeholder Link -->
            <p class="text-center text-sm text-[var(--flora-text-body)] pt-1">
                Don't have an account?
                <a href="#signup"
                   data-placeholder-auth="signup"
                   onclick="event.preventDefault(); notifyPlaceholder('Account sign-up is not enabled yet.');"
                   class="font-semibold text-[var(--flora-soldier-green)] underline decoration-[var(--flora-usukoubai)] underline-offset-4 hover:text-[var(--flora-usukoubai)] transition ml-1">
                    Sign up
                </a>
            </p>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function notifyPlaceholder(message) {
        if (window.FloraToast) {
            window.FloraToast.show(message, 'warning');
        }
    }
</script>
@endpush
