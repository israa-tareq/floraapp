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

    @include('layouts.partials.blurred-background', ['scope' => 'auth'])

    <x-toast-container />

    <!-- Login Container -->
    <main class="relative z-10 w-full max-w-md">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
