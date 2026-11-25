@extends('layouts.auth')

@section('title', 'Administrator Login')

@section('content')

    <!-- Branding Header -->
    <div class="text-center mb-8">
        <div class="w-16 h-16 rounded-2xl bg-flora-light text-flora-rose flex items-center justify-center text-3xl shadow-sm mx-auto mb-4">
            <i class="fa-solid fa-spa"></i>
        </div>

        <h1 class="text-2xl font-bold text-flora-dark tracking-tight">
            Flora Admin
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Please enter your administrator credentials to continue.
        </p>
    </div>

    <!-- Login Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">

        <!-- Flash Success Notification -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3 text-sm"
                 role="alert">
                <i class="fa-solid fa-circle-check text-green-600 text-base"></i>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Flash Error Notification -->
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-3 text-sm"
                 role="alert">
                <i class="fa-solid fa-circle-exclamation text-red-600 text-base"></i>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Username Field -->
            <div>
                <label for="username" class="block text-sm font-semibold text-flora-dark mb-2">
                    Username
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text"
                           id="username"
                           name="username"
                           value="{{ old('username') }}"
                           required
                           autofocus
                           autocomplete="username"
                           placeholder="Enter your admin username"
                           class="w-full rounded-xl border border-gray-200 pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink transition @error('username') border-red-300 ring-2 ring-red-100 @enderror">
                </div>
                @error('username')
                    <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-semibold text-flora-dark mb-2">
                    Password
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password"
                           id="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           placeholder="••••••••"
                           class="w-full rounded-xl border border-gray-200 pl-10 pr-11 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink transition @error('password') border-red-300 ring-2 ring-red-100 @enderror">

                    <!-- Show / Hide Password Toggle -->
                    <button type="button"
                            id="togglePasswordBtn"
                            onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-flora-dark transition"
                            aria-label="Toggle password visibility">
                        <i class="fa-solid fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-flora-pink hover:bg-flora-rose text-flora-dark font-semibold text-sm transition focus:outline-none focus:ring-2 focus:ring-flora-rose shadow-sm mt-2">
                <i class="fa-solid fa-right-to-bracket mr-1"></i>
                Log In to Admin
            </button>
        </form>

    </div>

    <!-- Security Notice -->
    <div class="text-center mt-6">
        <p class="text-xs text-gray-400 flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-shield-halved"></i>
            Restricted administrative area. Authorized access only.
        </p>
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
