<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | Flora Admin</title>

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

        .sidebar-link {
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            background-color: #F8EDEE;
            color: #2D3748;
        }

        .sidebar-link.active {
            background-color: #E8C5C8;
            color: #2D3748;
            font-weight: 600;
        }

        .main-content {
            min-width: 0;
        }

        button, a {
            cursor: pointer;
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen">

    <div class="min-h-screen flex">

        <!-- ================= SIDEBAR ================= -->
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col
                      fixed inset-y-0 left-0 z-40
                      transform -translate-x-full transition-transform duration-200
                      lg:translate-x-0"
               id="sidebar">

            <!-- Logo & Brand -->
            <div class="px-6 py-7 border-b border-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-flora-light text-flora-rose
                                flex items-center justify-center text-xl shadow-sm">
                        <i class="fa-solid fa-spa"></i>
                    </div>

                    <div>
                        <h1 class="text-xl font-bold text-flora-dark tracking-tight">
                            Flora
                        </h1>
                        <p class="text-xs text-gray-400">
                            Admin Panel
                        </p>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-3">
                    Main Menu
                </p>

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm
                          {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-600' }}">
                    <i class="fa-solid fa-chart-line text-base w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Flowers -->
                <a href="{{ route('admin.flowers.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm
                          {{ request()->routeIs('admin.flowers.*') ? 'active' : 'text-gray-600' }}">
                    <i class="fa-solid fa-seedling text-base w-5 text-center"></i>
                    <span>Flowers</span>
                </a>

                <!-- Bouquets -->
                <a href="{{ route('admin.bouquets.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm
                          {{ request()->routeIs('admin.bouquets.*') ? 'active' : 'text-gray-600' }}">
                    <i class="fa-solid fa-wand-magic-sparkles text-base w-5 text-center"></i>
                    <span>Pre-Made Bouquets</span>
                </a>

                <!-- Packaging Options -->
                <a href="{{ route('admin.packaging.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm
                          {{ request()->routeIs('admin.packaging.*') ? 'active' : 'text-gray-600' }}">
                    <i class="fa-solid fa-box-open text-base w-5 text-center"></i>
                    <span>Packaging Options</span>
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="px-6 py-5 border-t border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-flora-dark">
                        {{ session('admin_username', 'Administrator') }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Flora Admin
                    </p>
                </div>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="text-gray-400 hover:text-red-600 p-2 rounded-xl hover:bg-red-50 transition"
                            title="Log Out">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- ================= MOBILE SIDEBAR OVERLAY ================= -->
        <div id="sidebarOverlay"
             class="fixed inset-0 bg-black bg-opacity-30 z-30 hidden lg:hidden"
             onclick="toggleSidebar()">
        </div>

        <!-- ================= MAIN CONTENT WRAPPER ================= -->
        <div class="flex-1 flex flex-col min-h-screen lg:ml-64 main-content">

            <!-- ================= TOP BAR ================= -->
            <header class="bg-white border-b border-gray-100 px-5 md:px-8 py-4 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <!-- Mobile Hamburger Button -->
                    <button type="button"
                            onclick="toggleSidebar()"
                            class="lg:hidden text-gray-600 hover:text-flora-dark text-xl p-2 rounded-lg hover:bg-gray-100 transition"
                            aria-label="Open navigation menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <div>
                        <h2 class="text-lg font-semibold text-flora-dark">
                            @yield('page-heading', 'Dashboard')
                        </h2>
                        <p class="text-xs text-gray-400 mt-0.5">
                            @yield('page-subheading', 'Welcome to Flora administration')
                        </p>
                    </div>
                </div>

                <!-- Admin Information & Actions -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-flora-dark">
                                {{ session('admin_username', 'Administrator') }}
                            </p>
                            <p class="text-xs text-gray-400">
                                Single Admin
                            </p>
                        </div>

                        <div class="w-10 h-10 rounded-full bg-flora-pink text-flora-dark
                                    flex items-center justify-center text-lg shadow-sm">
                            <i class="fa-solid fa-circle-user"></i>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:text-red-600 hover:bg-red-50 border border-gray-200 hover:border-red-100 transition shadow-sm"
                                title="Log out of Flora Admin">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="hidden md:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- ================= PAGE CONTENT ================= -->
            <main class="flex-1 p-5 md:p-8">

                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl flex items-center justify-between"
                         role="alert">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-green-600 text-lg"></i>
                            <p class="text-sm font-medium">
                                {{ session('success') }}
                            </p>
                        </div>
                        <button type="button"
                                onclick="this.parentElement.remove()"
                                class="text-green-600 hover:text-green-800 p-1 text-sm"
                                aria-label="Close notification">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                <!-- General Error Message -->
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl flex items-center justify-between"
                         role="alert">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-exclamation text-red-600 text-lg"></i>
                            <p class="text-sm font-medium">
                                {{ session('error') }}
                            </p>
                        </div>
                        <button type="button"
                                onclick="this.parentElement.remove()"
                                class="text-red-600 hover:text-red-800 p-1 text-sm"
                                aria-label="Close notification">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                <!-- Validation Errors Message -->
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl"
                         role="alert">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-circle-exclamation text-red-600 text-lg"></i>
                            <p class="font-semibold text-sm">
                                Please correct the following errors:
                            </p>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1 ml-7 text-red-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Yielded Content of Individual Pages -->
                @yield('content')

            </main>

            <!-- ================= FOOTER ================= -->
            <footer class="px-8 py-5 text-center text-xs text-gray-400 border-t border-gray-100 bg-white">
                &copy; {{ date('Y') }} Flora Shop Management. All rights reserved.
            </footer>

        </div>

    </div>

    <!-- ================= JAVASCRIPT ================= -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>

    @stack('scripts')

</body>
</html>
