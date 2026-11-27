{{-- Reusable Sales Analytics Widgets (used on Dashboard & Sales Page) --}}

<!-- Sales KPI Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
    <div class="flora-card flora-card-interactive p-6 flex items-center justify-between">
        <div>
            <p class="text-sm text-[var(--flora-text-muted)] font-medium">
                Total Sales Revenue
            </p>
            <p class="text-3xl font-bold text-[var(--flora-soldier-green)] mt-2">
                ${{ number_format($totalRevenue, 2) }}
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[var(--flora-usukoubai)]/20 text-[var(--flora-soldier-green)] border border-[var(--flora-border-subtle)] flex items-center justify-center text-xl shrink-0">
            <i class="fa-solid fa-coins"></i>
        </div>
    </div>

    <div class="flora-card flora-card-interactive p-6 flex items-center justify-between">
        <div>
            <p class="text-sm text-[var(--flora-text-muted)] font-medium">
                Completed Sales
            </p>
            <p class="text-3xl font-bold text-[var(--flora-soldier-green)] mt-2">
                {{ number_format($completedSalesCount) }}
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[var(--flora-meadow-mauve)]/25 text-[var(--flora-soldier-green)] border border-[var(--flora-border-subtle)] flex items-center justify-center text-xl shrink-0">
            <i class="fa-solid fa-circle-check"></i>
        </div>
    </div>

    <div class="flora-card flora-card-interactive p-6 flex items-center justify-between">
        <div>
            <p class="text-sm text-[var(--flora-text-muted)] font-medium">
                Units Sold
            </p>
            <p class="text-3xl font-bold text-[var(--flora-soldier-green)] mt-2">
                {{ number_format($totalUnitsSold) }}
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[var(--flora-berry-good)]/60 text-[var(--flora-soldier-green)] border border-[var(--flora-border-subtle)] flex items-center justify-center text-xl shrink-0">
            <i class="fa-solid fa-bag-shopping"></i>
        </div>
    </div>
</div>

<!-- Sales Trends Chart & Most Popular Products -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">

    <!-- Sales Trends Over Time (14 Days) -->
    <x-card class="xl:col-span-2 p-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <h2 class="text-base font-bold text-[var(--flora-soldier-green)]">
                Sales Trends (Last 14 Days)
            </h2>
            <span class="text-xs font-semibold text-[var(--flora-text-muted)]">
                Completed sales revenue
            </span>
        </div>

        @php
            $maxTrendRevenue = max(1, (float) $salesTrend->max('revenue'));
            $hasTrendData = $salesTrend->sum('revenue') > 0;
            $pointCount = $salesTrend->count();
            $svgPoints = $salesTrend->values()->map(function ($day, $idx) use ($pointCount, $maxTrendRevenue) {
                $x = $pointCount > 1 ? round(($idx / ($pointCount - 1)) * 100, 2) : 50;
                $y = round(92 - (($day->revenue / $maxTrendRevenue) * 76), 2);
                return "{$x},{$y}";
            })->implode(' ');
        @endphp

        @if($hasTrendData)
            <div class="space-y-3">
                <!-- Animated SVG Sparkline Overlay + Interactive Daily Columns -->
                <div class="relative h-48 pt-4 pb-2 px-1">
                    <svg viewBox="0 0 100 100"
                         preserveAspectRatio="none"
                         class="absolute inset-0 w-full h-40 pointer-events-none opacity-65"
                         aria-hidden="true">
                        <polyline fill="none"
                                  stroke="var(--flora-soldier-green)"
                                  stroke-width="1.35"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  class="flora-trend-line"
                                  points="{{ $svgPoints }}" />
                    </svg>

                    <div class="relative z-10 h-40 flex items-end gap-1.5 sm:gap-2 border-b border-[var(--flora-border-subtle)] pb-1">
                        @foreach($salesTrend as $index => $day)
                            @php
                                $heightPercent = $day->revenue > 0
                                    ? max(8, round(($day->revenue / $maxTrendRevenue) * 100))
                                    : 3;
                            @endphp
                            <div class="flex-1 h-full flex flex-col justify-end items-center group relative">
                                <!-- Hover Tooltip -->
                                <div class="hidden group-hover:flex flex-col items-center absolute -top-11 left-1/2 -translate-x-1/2 bg-[var(--flora-soldier-green)] text-[var(--flora-text-on-accent)] text-[11px] font-semibold px-2.5 py-1 rounded-lg shadow-md whitespace-nowrap z-20 pointer-events-none">
                                    <span>{{ $day->label }}: ${{ number_format($day->revenue, 2) }}</span>
                                    <span class="opacity-85">{{ $day->count }} {{ \Illuminate\Support\Str::plural('sale', $day->count) }}</span>
                                </div>

                                <div class="w-full max-w-[26px] rounded-t-md flora-column-fill transition-colors {{ $day->revenue > 0 ? 'bg-[var(--flora-usukoubai)]/85 group-hover:bg-[var(--flora-soldier-green)]' : 'bg-[var(--flora-border-subtle)]' }}"
                                     style="height: {{ $heightPercent }}%; animation-delay: {{ $index * 25 }}ms;">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-between text-[11px] text-[var(--flora-text-muted)] font-medium mt-2">
                        <span>{{ $salesTrend->first()->label }}</span>
                        <span>{{ $salesTrend->get((int) floor($pointCount / 2))->label }}</span>
                        <span>{{ $salesTrend->last()->label }}</span>
                    </div>
                </div>
            </div>
        @else
            <x-empty-state
                icon="fa-chart-area"
                title="No completed sales in the last 14 days">
                <x-slot:action>
                    <x-button href="{{ route('admin.sales.create') }}" variant="primary">
                        <i class="fa-solid fa-plus"></i>
                        <span>Record Sale</span>
                    </x-button>
                </x-slot:action>
            </x-empty-state>
        @endif
    </x-card>

    <!-- Most Popular Products -->
    <x-card class="p-6">
        <div class="flex items-center justify-between gap-3 mb-5">
            <h2 class="text-base font-bold text-[var(--flora-soldier-green)]">
                Most Popular Products
            </h2>
            <span class="text-xs font-semibold text-[var(--flora-text-muted)]">
                By units sold
            </span>
        </div>

        @if($mostPopularProducts->count() > 0)
            @php
                $maxPopularUnits = max(1, (int) $mostPopularProducts->max('total_sold'));
            @endphp
            <div class="space-y-4">
                @foreach($mostPopularProducts as $idx => $product)
                    @php
                        $widthPct = max(8, round(($product->total_sold / $maxPopularUnits) * 100));
                    @endphp
                    <div>
                        <div class="flex items-center justify-between gap-2 text-sm mb-1.5">
                            <span class="font-semibold text-[var(--flora-soldier-green)] truncate">
                                {{ $product->name }}
                            </span>
                            <span class="text-xs font-semibold text-[var(--flora-text-muted)] shrink-0">
                                {{ $product->total_sold }} sold
                            </span>
                        </div>
                        <div class="w-full h-2.5 rounded-full bg-[var(--flora-bg-subtle)] overflow-hidden">
                            <div class="h-full rounded-full flora-bar-fill {{ $product->item_type === 'flower' ? 'bg-[var(--flora-usukoubai)]' : 'bg-[var(--flora-meadow-mauve)]' }}"
                                 style="width: {{ $widthPct }}%; animation-delay: {{ $idx * 60 }}ms;">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <x-empty-state
                icon="fa-award"
                title="No product sales recorded yet" />
        @endif
    </x-card>

</div>

<!-- Best-Selling Flowers & Best-Selling Pre-Made Bouquets -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    <!-- Best-Selling Flowers -->
    <x-card>
        <div class="px-6 py-4 border-b border-[var(--flora-border-subtle)] flex items-center justify-between gap-3">
            <h2 class="text-base font-bold text-[var(--flora-soldier-green)]">
                Best-Selling Flowers
            </h2>
            <i class="fa-solid fa-seedling text-[var(--flora-usukoubai)]"></i>
        </div>

        @if($bestSellingFlowers->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="flora-table-head">
                        <tr>
                            <th class="px-6 py-3">Flower</th>
                            <th class="px-6 py-3 text-right">Units Sold</th>
                            <th class="px-6 py-3 text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="flora-table-body">
                        @foreach($bestSellingFlowers as $flower)
                            <tr>
                                <td class="px-6 py-3.5 text-sm font-semibold text-[var(--flora-soldier-green)]">
                                    {{ $flower->name }}
                                </td>
                                <td class="px-6 py-3.5 text-sm font-semibold text-right text-[var(--flora-text-body)]">
                                    {{ number_format($flower->total_sold) }}
                                </td>
                                <td class="px-6 py-3.5 text-sm font-semibold text-right text-[var(--flora-soldier-green)]">
                                    ${{ number_format($flower->total_revenue, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-empty-state
                icon="fa-seedling"
                title="No flower sales recorded yet" />
        @endif
    </x-card>

    <!-- Best-Selling Pre-Made Bouquets -->
    <x-card>
        <div class="px-6 py-4 border-b border-[var(--flora-border-subtle)] flex items-center justify-between gap-3">
            <h2 class="text-base font-bold text-[var(--flora-soldier-green)]">
                Best-Selling Pre-Made Bouquets
            </h2>
            <i class="fa-solid fa-wand-magic-sparkles text-[var(--flora-meadow-mauve)]"></i>
        </div>

        @if($bestSellingBouquets->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="flora-table-head">
                        <tr>
                            <th class="px-6 py-3">Bouquet</th>
                            <th class="px-6 py-3 text-right">Units Sold</th>
                            <th class="px-6 py-3 text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="flora-table-body">
                        @foreach($bestSellingBouquets as $bouquet)
                            <tr>
                                <td class="px-6 py-3.5 text-sm font-semibold text-[var(--flora-soldier-green)]">
                                    {{ $bouquet->name }}
                                </td>
                                <td class="px-6 py-3.5 text-sm font-semibold text-right text-[var(--flora-text-body)]">
                                    {{ number_format($bouquet->total_sold) }}
                                </td>
                                <td class="px-6 py-3.5 text-sm font-semibold text-right text-[var(--flora-soldier-green)]">
                                    ${{ number_format($bouquet->total_revenue, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-empty-state
                icon="fa-wand-magic-sparkles"
                title="No bouquet sales recorded yet" />
        @endif
    </x-card>

</div>
