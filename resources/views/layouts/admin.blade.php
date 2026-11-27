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

        <!-- ================= COLLAPSIBLE SIDEBAR ================= -->
        <aside class="flora-sidebar sticky top-0 h-screen shrink-0 flex flex-col z-30"
               id="sidebar"
               aria-label="Admin navigation">

            <!-- Brand Logo -->
            <div class="sidebar-brand-wrap px-6 py-5 border-b border-[var(--flora-border-subtle)] flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 min-w-0">
                    <x-app-logo size="md" class="shrink-0" />
                    <span class="sidebar-brand-text text-xl font-bold text-[var(--flora-soldier-green)] tracking-tight">
                        Flora
                    </span>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto">
                <p class="sidebar-section-title text-xs font-semibold text-[var(--flora-text-muted)] uppercase tracking-wider px-3 mb-3">
                    Menu
                </p>

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   data-tooltip="Dashboard"
                   title="Dashboard"
                   aria-label="Dashboard"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm
                          {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line text-base w-5 text-center shrink-0"></i>
                    <span class="sidebar-label">Dashboard</span>
                </a>

                <!-- Sales -->
                <a href="{{ route('admin.sales.index') }}"
                   data-tooltip="Sales"
                   title="Sales"
                   aria-label="Sales"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm
                          {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt text-base w-5 text-center shrink-0"></i>
                    <span class="sidebar-label">Sales</span>
                </a>

                <!-- Flowers -->
                <a href="{{ route('admin.flowers.index') }}"
                   data-tooltip="Flowers"
                   title="Flowers"
                   aria-label="Flowers"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm
                          {{ request()->routeIs('admin.flowers.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-seedling text-base w-5 text-center shrink-0"></i>
                    <span class="sidebar-label">Flowers</span>
                </a>

                <!-- Pre-Made Bouquets -->
                <a href="{{ route('admin.bouquets.index') }}"
                   data-tooltip="Pre-Made Bouquets"
                   title="Pre-Made Bouquets"
                   aria-label="Pre-Made Bouquets"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm
                          {{ request()->routeIs('admin.bouquets.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wand-magic-sparkles text-base w-5 text-center shrink-0"></i>
                    <span class="sidebar-label">Pre-Made Bouquets</span>
                </a>

                <!-- Packaging Options -->
                <a href="{{ route('admin.packaging.index') }}"
                   data-tooltip="Packaging Options"
                   title="Packaging Options"
                   aria-label="Packaging Options"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm
                          {{ request()->routeIs('admin.packaging.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box-open text-base w-5 text-center shrink-0"></i>
                    <span class="sidebar-label">Packaging Options</span>
                </a>
            </nav>

            <!-- Sidebar Footer (Admin Identity Only — Logout is in Header) -->
            <div class="sidebar-footer-wrap px-5 py-4 border-t border-[var(--flora-border-subtle)] flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-[var(--flora-berry-good)]/65 text-[var(--flora-soldier-green)] border border-[var(--flora-border-subtle)] flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="sidebar-user-meta min-w-0">
                    <p class="text-xs font-semibold text-[var(--flora-soldier-green)] truncate">
                        {{ session('admin_username', 'Administrator') }}
                    </p>
                    <p class="text-xs text-[var(--flora-text-muted)]">
                        Administrator
                    </p>
                </div>
            </div>
        </aside>

        <!-- Apply saved sidebar collapse state immediately to avoid layout flicker -->
        <script>
            (function () {
                const sidebar = document.getElementById('sidebar');
                if (!sidebar) return;
                const stored = localStorage.getItem('flora_sidebar_collapsed');
                const shouldCollapse = stored !== null ? stored === 'true' : window.innerWidth < 768;
                if (shouldCollapse) {
                    sidebar.classList.add('is-collapsed');
                }
            })();
        </script>

        <!-- ================= MAIN CONTENT WRAPPER ================= -->
        <div class="flex-1 flex flex-col min-h-screen main-content">

            <!-- ================= TOP BAR ================= -->
            <header class="flora-topbar px-4 sm:px-6 md:px-8 py-4 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                    <!-- Sidebar Collapse / Expand Toggle Button (All Screen Sizes) -->
                    <button type="button"
                            id="sidebarToggleBtn"
                            onclick="toggleSidebar()"
                            class="text-[var(--flora-soldier-green)] hover:bg-[var(--flora-berry-good)]/45 border border-[var(--flora-border-subtle)] text-base w-9 h-9 rounded-xl flex items-center justify-center transition shrink-0"
                            title="Toggle sidebar"
                            aria-label="Toggle sidebar"
                            aria-expanded="true">
                        <i class="fa-solid fa-bars" id="sidebarToggleIcon"></i>
                    </button>

                    <h1 class="text-xl font-bold text-[var(--flora-soldier-green)] tracking-tight truncate">
                        @yield('page-heading', 'Dashboard')
                    </h1>
                </div>

                <!-- Admin Info & Single Icon-Only Logout Button -->
                <div class="flex items-center gap-3 shrink-0">
                    <span class="text-sm font-semibold text-[var(--flora-soldier-green)] hidden sm:inline">
                        {{ session('admin_username', 'Administrator') }}
                    </span>

                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                data-tooltip="Logout"
                                title="Logout"
                                aria-label="Logout"
                                class="flora-icon-tooltip w-9 h-9 rounded-xl inline-flex items-center justify-center text-sm text-[var(--flora-soldier-green)] bg-[var(--flora-bg-surface-elevated)] hover:bg-[var(--flora-status-danger-bg)] hover:text-[var(--flora-status-danger-text)] border border-[var(--flora-border-subtle)] hover:border-[var(--flora-status-danger-border)] transition">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </header>

            <!-- ================= TOAST NOTIFICATIONS ================= -->
            <x-toast-container />

            <!-- ================= PAGE CONTENT WITH BLURRED BACKGROUND ================= -->
            <main class="flora-main-area flex-1 p-5 md:p-8">

                @include('layouts.partials.blurred-background', ['scope' => 'main'])

                <div class="relative z-10 flora-page-enter">
                    <!-- Inline Validation Errors (Form Feedback) -->
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

                    @yield('content')
                </div>

            </main>

            <!-- ================= FOOTER ================= -->
            <footer class="flora-footer px-8 py-4 text-center text-xs relative z-10">
                &copy; {{ date('Y') }} Flora Shop Management
            </footer>

        </div>

    </div>

    <!-- ================= SIDEBAR TOGGLE SCRIPT ================= -->
    <script>
        function syncSidebarToggleButton() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            if (!sidebar || !toggleBtn) return;

            const isCollapsed = sidebar.classList.contains('is-collapsed');
            toggleBtn.setAttribute('aria-expanded', isCollapsed ? 'false' : 'true');
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (!sidebar) return;

            sidebar.classList.toggle('is-collapsed');
            const isCollapsed = sidebar.classList.contains('is-collapsed');
            localStorage.setItem('flora_sidebar_collapsed', isCollapsed ? 'true' : 'false');
            syncSidebarToggleButton();
        }

        document.addEventListener('DOMContentLoaded', syncSidebarToggleButton);
    </script>

    @stack('scripts')

</body>
</html>
