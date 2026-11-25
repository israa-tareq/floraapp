<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Flora Admin</title>

    @include('layouts.partials.head-assets')

    @stack('styles')
</head>

<body class="min-h-screen">

    <div class="min-h-screen flex">

        <!-- ================= SIDEBAR ================= -->
        <aside class="w-64 flora-sidebar flex flex-col
                      fixed inset-y-0 left-0 z-40
                      transform -translate-x-full transition-transform duration-200
                      lg:translate-x-0"
               id="sidebar"
               aria-label="Admin navigation">

            <!-- Brand Logo -->
            <div class="px-6 py-6 border-b border-[var(--flora-border-subtle)]">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <x-app-logo size="md" />
                    <span class="text-xl font-bold text-[var(--flora-soldier-green)] tracking-tight">
                        Flora
                    </span>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <p class="text-xs font-semibold text-[var(--flora-text-muted)] uppercase tracking-wider px-3 mb-3">
                    Menu
                </p>

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm
                          {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line text-base w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Flowers -->
                <a href="{{ route('admin.flowers.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm
                          {{ request()->routeIs('admin.flowers.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-seedling text-base w-5 text-center"></i>
                    <span>Flowers</span>
                </a>

                <!-- Bouquets -->
                <a href="{{ route('admin.bouquets.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm
                          {{ request()->routeIs('admin.bouquets.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wand-magic-sparkles text-base w-5 text-center"></i>
                    <span>Pre-Made Bouquets</span>
                </a>

                <!-- Packaging Options -->
                <a href="{{ route('admin.packaging.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm
                          {{ request()->routeIs('admin.packaging.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box-open text-base w-5 text-center"></i>
                    <span>Packaging Options</span>
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="px-6 py-5 border-t border-[var(--flora-border-subtle)] flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-[var(--flora-soldier-green)] truncate">
                        {{ session('admin_username', 'Administrator') }}
                    </p>
                    <p class="text-xs text-[var(--flora-text-muted)] mt-0.5">
                        Administrator
                    </p>
                </div>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="text-[var(--flora-text-muted)] hover:text-[var(--flora-status-danger-text)] p-2 rounded-xl hover:bg-[var(--flora-status-danger-bg)] transition"
                            title="Log Out"
                            aria-label="Log Out">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- ================= MOBILE SIDEBAR OVERLAY ================= -->
        <div id="sidebarOverlay"
             class="fixed inset-0 bg-[var(--flora-soldier-green)]/30 backdrop-blur-[1px] z-30 hidden lg:hidden"
             onclick="toggleSidebar()">
        </div>

        <!-- ================= MAIN CONTENT WRAPPER ================= -->
        <div class="flex-1 flex flex-col min-h-screen lg:ml-64 main-content">

            <!-- ================= TOP BAR ================= -->
            <header class="flora-topbar px-5 md:px-8 py-4 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <!-- Mobile Hamburger Button -->
                    <button type="button"
                            onclick="toggleSidebar()"
                            class="lg:hidden text-[var(--flora-soldier-green)] hover:bg-[var(--flora-bg-subtle)] text-xl p-2 rounded-lg transition"
                            aria-label="Open navigation menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <h2 class="text-lg font-bold text-[var(--flora-soldier-green)] tracking-tight">
                        @yield('page-heading', 'Dashboard')
                    </h2>
                </div>

                <!-- Admin Information & Actions -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full bg-[var(--flora-berry-good)]/70 text-[var(--flora-soldier-green)] border border-[var(--flora-border-subtle)]
                                    flex items-center justify-center text-base">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <span class="text-sm font-semibold text-[var(--flora-soldier-green)] hidden sm:inline">
                            {{ session('admin_username', 'Administrator') }}
                        </span>
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold text-[var(--flora-soldier-green)] bg-[var(--flora-bg-surface-elevated)] hover:bg-[var(--flora-status-danger-bg)] hover:text-[var(--flora-status-danger-text)] border border-[var(--flora-border-subtle)] hover:border-[var(--flora-status-danger-border)] transition"
                                title="Log out">
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
                    <div class="mb-6 bg-[var(--flora-status-success-bg)] border border-[var(--flora-status-success-border)] text-[var(--flora-status-success-text)] px-5 py-4 rounded-xl flex items-center justify-between gap-4"
                         role="status">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-lg shrink-0"></i>
                            <p class="text-sm font-medium">
                                {{ session('success') }}
                            </p>
                        </div>
                        <button type="button"
                                onclick="this.parentElement.remove()"
                                class="p-1 text-sm opacity-75 hover:opacity-100"
                                aria-label="Close notification">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                <!-- General Error Message -->
                @if(session('error'))
                    <div class="mb-6 bg-[var(--flora-status-danger-bg)] border border-[var(--flora-status-danger-border)] text-[var(--flora-status-danger-text)] px-5 py-4 rounded-xl flex items-center justify-between gap-4"
                         role="alert">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-exclamation text-lg shrink-0"></i>
                            <p class="text-sm font-medium">
                                {{ session('error') }}
                            </p>
                        </div>
                        <button type="button"
                                onclick="this.parentElement.remove()"
                                class="p-1 text-sm opacity-75 hover:opacity-100"
                                aria-label="Close notification">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                <!-- Validation Errors Message -->
                @if($errors->any())
                    <div class="mb-6 bg-[var(--flora-status-danger-bg)] border border-[var(--flora-status-danger-border)] text-[var(--flora-status-danger-text)] px-5 py-4 rounded-xl"
                         role="alert">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-circle-exclamation text-lg shrink-0"></i>
                            <p class="font-semibold text-sm">
                                Please correct the following errors:
                            </p>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1 ml-7">
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
            <footer class="flora-footer px-8 py-4 text-center text-xs">
                &copy; {{ date('Y') }} Flora Shop Management
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
