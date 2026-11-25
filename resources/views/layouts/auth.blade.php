<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Login') | Flora Admin</title>

    <!-- Font Awesome 6 Free (Icons) -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Theme Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        flora: {
                            beige: '#FDFBF7',
                            pink: '#E8C5C8',
                            rose: '#D9A0A7',
                            dark: '#2D3748',
                            muted: '#718096',
                            light: '#F8EDEE',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #FDFBF7;
            color: #2D3748;
            font-family: Arial, Helvetica, sans-serif;
        }

        button, a {
            cursor: pointer;
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <div class="w-full max-w-md">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
