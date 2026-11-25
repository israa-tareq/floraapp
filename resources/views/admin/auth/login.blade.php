@extends('layouts.auth')

@section('title', 'Login')

@section('content')

    <!-- Login Card -->
    <div class="flora-login-card p-6 sm:p-8">

        <!-- Application Brand Header -->
        <div class="text-center mb-7">
            <x-app-logo size="lg" class="mx-auto mb-3" />

            <h1 class="text-2xl font-bold text-[var(--flora-soldier-green)] tracking-tight">
                Flora
            </h1>
        </div>

        <!-- Flash Success Notification (e.g. after logout) -->
        @if(session('success'))
            <div class="mb-5 bg-[var(--flora-status-success-bg)] border border-[var(--flora-status-success-border)] text-[var(--flora-status-success-text)] px-4 py-3 rounded-xl flex items-center gap-3 text-sm"
                 role="status">
                <i class="fa-solid fa-circle-check text-base shrink-0"></i>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Flash Error Notification -->
        @if(session('error'))
            <div class="mb-5 bg-[var(--flora-status-danger-bg)] border border-[var(--flora-status-danger-border)] text-[var(--flora-status-danger-text)] px-4 py-3 rounded-xl flex items-center gap-3 text-sm"
                 role="alert">
                <i class="fa-solid fa-circle-exclamation text-base shrink-0"></i>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" novalidate class="space-y-5">
            @csrf

            <!-- Username Field -->
            <div>
                <label for="username" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
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
                <label for="password" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
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
            <x-button type="submit" variant="primary" class="w-full py-3">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>Log In</span>
            </x-button>
        </form>

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
</script>
@endpush
