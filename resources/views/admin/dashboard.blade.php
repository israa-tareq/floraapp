@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-heading', 'Dashboard')

@section('content')

    <!-- ================= INVENTORY STATISTICS CARDS ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        <!-- Total Flower Stems -->
        <a href="{{ route('admin.flowers.index') }}"
           class="flora-card flora-card-interactive p-6 flex items-center justify-between">
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
           class="flora-card flora-card-interactive p-6 flex items-center justify-between">
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
           class="flora-card flora-card-interactive p-6 flex items-center justify-between">
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
           class="flora-card flora-card-interactive p-6 flex items-center justify-between">
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

    <!-- ================= SALES & STATISTICS SECTION ================= -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
        <h2 class="text-lg font-bold text-[var(--flora-soldier-green)]">
            Sales Overview
        </h2>

        <div class="flex items-center gap-2.5">
            <x-button href="{{ route('admin.sales.index') }}" variant="secondary">
                <i class="fa-solid fa-chart-column"></i>
                <span>All Sales</span>
            </x-button>
            <x-button href="{{ route('admin.sales.create') }}" variant="primary">
                <i class="fa-solid fa-plus"></i>
                <span>Record Sale</span>
            </x-button>
        </div>
    </div>

    @include('admin.sales.partials.analytics-widgets')

    <!-- ================= RECENT SALES & LOW STOCK SECTION ================= -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <!-- Recent Sales -->
        <x-card>
            <div class="px-6 py-4 border-b border-[var(--flora-border-subtle)] flex items-center justify-between gap-3">
                <h2 class="text-base font-bold text-[var(--flora-soldier-green)]">
                    Recent Sales
                </h2>
                <a href="{{ route('admin.sales.index') }}"
                   class="text-xs font-semibold text-[var(--flora-soldier-green)] hover:text-[var(--flora-usukoubai)] transition">
                    View All
                </a>
            </div>

            @if($recentSales->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="flora-table-head">
                            <tr>
                                <th class="px-5 py-3">Sale #</th>
                                <th class="px-5 py-3">Customer</th>
                                <th class="px-5 py-3 text-right">Total</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="flora-table-body">
                            @foreach($recentSales as $sale)
                                <tr>
                                    <td class="px-5 py-3.5 text-sm font-semibold text-[var(--flora-soldier-green)]">
                                        <a href="{{ route('admin.sales.show', $sale) }}"
                                           class="hover:text-[var(--flora-usukoubai)] transition">
                                            {{ $sale->sale_number }}
                                        </a>
                                    </td>
                                    <td class="px-5 py-3.5 text-sm text-[var(--flora-text-body)]">
                                        {{ $sale->customer_name ?: 'Walk-in' }}
                                    </td>
                                    <td class="px-5 py-3.5 text-sm font-semibold text-right text-[var(--flora-soldier-green)]">
                                        ${{ number_format((float) $sale->total_amount, 2) }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if($sale->status === 'completed')
                                            <x-badge variant="success">Completed</x-badge>
                                        @elseif($sale->status === 'pending')
                                            <x-badge variant="warning">Pending</x-badge>
                                        @else
                                            <x-badge variant="danger">Cancelled</x-badge>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-empty-state
                    icon="fa-receipt"
                    title="No recent sales" />
            @endif
        </x-card>

        <!-- Low Stock Alerts -->
        <x-card>
            <div class="px-6 py-4 border-b border-[var(--flora-border-subtle)] flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-base font-bold text-[var(--flora-soldier-green)]">
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
                            <th class="px-5 py-3">Item Name</th>
                            <th class="px-5 py-3">Category</th>
                            <th class="px-5 py-3">Stock</th>
                            <th class="px-5 py-3">Status</th>
                        </tr>
                    </thead>

                    <tbody class="flora-table-body">
                        @forelse($lowStockItems as $item)
                            <tr>
                                <td class="px-5 py-3.5">
                                    <p class="text-sm font-semibold text-[var(--flora-soldier-green)]">
                                        {{ $item->name }}
                                    </p>
                                </td>

                                <td class="px-5 py-3.5">
                                    <x-badge variant="neutral">
                                        {{ $item->item_type }}
                                    </x-badge>
                                </td>

                                <td class="px-5 py-3.5">
                                    <span class="text-sm font-bold {{ $item->stock_quantity <= 5 ? 'text-[var(--flora-status-danger-text)]' : 'text-[var(--flora-status-warning-text)]' }}">
                                        {{ $item->stock_quantity }}
                                    </span>
                                </td>

                                <td class="px-5 py-3.5">
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

    </div>

@endsection
