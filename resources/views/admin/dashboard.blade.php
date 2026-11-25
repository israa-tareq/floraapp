@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-heading', 'Dashboard')

@section('content')

    <!-- Page Title -->
    <x-page-header title="Dashboard" />

    <!-- ================= STATISTICS CARDS ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        <!-- Total Flower Stems -->
        <a href="{{ route('admin.flowers.index') }}"
           class="flora-card p-6 flex items-center justify-between hover:border-[var(--flora-usukoubai)] transition">
            <div>
                <p class="text-sm text-[var(--flora-text-muted)] font-medium">
                    Flower Stems
                </p>
                <p class="text-3xl font-bold text-[var(--flora-soldier-green)] mt-2">
                    {{ number_format($totalStems) }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[var(--flora-berry-good)]/55 text-[var(--flora-soldier-green)] border border-[var(--flora-border-subtle)] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-seedling"></i>
            </div>
        </a>

        <!-- Flower Varieties -->
        <a href="{{ route('admin.flowers.index') }}"
           class="flora-card p-6 flex items-center justify-between hover:border-[var(--flora-usukoubai)] transition">
            <div>
                <p class="text-sm text-[var(--flora-text-muted)] font-medium">
                    Flower Varieties
                </p>
                <p class="text-3xl font-bold text-[var(--flora-soldier-green)] mt-2">
                    {{ number_format($totalFlowers) }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[var(--flora-meadow-mauve)]/20 text-[var(--flora-soldier-green)] border border-[var(--flora-border-subtle)] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-spa"></i>
            </div>
        </a>

        <!-- Pre-Made Bouquets -->
        <a href="{{ route('admin.bouquets.index') }}"
           class="flora-card p-6 flex items-center justify-between hover:border-[var(--flora-usukoubai)] transition">
            <div>
                <p class="text-sm text-[var(--flora-text-muted)] font-medium">
                    Pre-Made Bouquets
                </p>
                <p class="text-3xl font-bold text-[var(--flora-soldier-green)] mt-2">
                    {{ number_format($totalBouquets) }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[var(--flora-usukoubai)]/20 text-[var(--flora-soldier-green)] border border-[var(--flora-border-subtle)] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
        </a>

        <!-- Packaging Options -->
        <a href="{{ route('admin.packaging.index') }}"
           class="flora-card p-6 flex items-center justify-between hover:border-[var(--flora-usukoubai)] transition">
            <div>
                <p class="text-sm text-[var(--flora-text-muted)] font-medium">
                    Packaging Options
                </p>
                <p class="text-3xl font-bold text-[var(--flora-soldier-green)] mt-2">
                    {{ number_format($totalPackaging) }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[var(--flora-bg-subtle)] text-[var(--flora-soldier-green)] border border-[var(--flora-border-subtle)] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-box-open"></i>
            </div>
        </a>

    </div>

    <!-- ================= LOW STOCK SECTION ================= -->
    <x-card>
        <div class="px-6 py-5 border-b border-[var(--flora-border-subtle)] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="text-lg font-bold text-[var(--flora-soldier-green)]">
                Low Stock Alerts
            </h2>

            <div>
                @if($lowStockItems->count() > 0)
                    <x-badge variant="danger">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>{{ $lowStockItems->count() }} {{ \Illuminate\Support\Str::plural('Item', $lowStockItems->count()) }} Below 10 Units</span>
                    </x-badge>
                @else
                    <x-badge variant="success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>All Stock Healthy</span>
                    </x-badge>
                @endif
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="flora-table-head">
                    <tr>
                        <th class="px-6 py-3.5">Item Name</th>
                        <th class="px-6 py-3.5">Category</th>
                        <th class="px-6 py-3.5">Stock Quantity</th>
                        <th class="px-6 py-3.5">Status</th>
                    </tr>
                </thead>

                <tbody class="flora-table-body">
                    @forelse($lowStockItems as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-[var(--flora-soldier-green)]">
                                    {{ $item->name }}
                                </p>
                            </td>

                            <td class="px-6 py-4">
                                <x-badge variant="neutral">
                                    {{ $item->item_type }}
                                </x-badge>
                            </td>

                            <td class="px-6 py-4">
                                <span class="text-sm font-bold {{ $item->stock_quantity <= 5 ? 'text-[var(--flora-status-danger-text)]' : 'text-[var(--flora-status-warning-text)]' }}">
                                    {{ $item->stock_quantity }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                @if($item->stock_quantity == 0)
                                    <x-badge variant="danger">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                        <span>Out of Stock</span>
                                    </x-badge>
                                @elseif($item->stock_quantity <= 5)
                                    <x-badge variant="danger">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        <span>Critical Stock</span>
                                    </x-badge>
                                @else
                                    <x-badge variant="warning">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>Low Stock</span>
                                    </x-badge>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-empty-state
                                    icon="fa-circle-check"
                                    title="All stock levels are healthy" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

@endsection
