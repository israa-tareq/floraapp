<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Login') | Flora Admin</title>

    @include('layouts.partials.head-assets')

    @stack('styles')
</head>

<body class="min-h-screen relative flex items-center justify-center p-4 sm:p-6 lg:p-8">

    @php
        $bgCandidates = [
            'images/login-bg.jpg',
            'images/login-bg.jpeg',
            'images/login-bg.png',
            'images/login-bg.webp',
        ];
        $loginBgPath = collect($bgCandidates)->first(fn (string $path) => file_exists(public_path($path)));
    @endphp

    <!-- Full-Screen Blurred Background Area -->
    <div class="flora-login-bg-wrapper" aria-hidden="true">
        @if($loginBgPath)
            <div class="flora-login-bg-image"
                 style="background-image: url('{{ asset($loginBgPath) }}');"></div>
        @else
            <div class="flora-login-bg-placeholder"></div>
        @endif
        <div class="flora-login-bg-overlay"></div>
    </div>

    <!-- Login Container -->
    <main class="relative z-10 w-full max-w-md">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
