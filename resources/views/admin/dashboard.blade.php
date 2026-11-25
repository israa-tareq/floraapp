@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-heading', 'Dashboard Overview')
@section('page-subheading', "Here's an overview of your flower shop inventory today.")

@section('content')

    <!-- ================= PAGE INTRODUCTION ================= -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-flora-dark tracking-tight">
            Welcome Back!
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Here's what's happening with your flower shop today.
        </p>
    </div>

    <!-- ================= STATISTICS CARDS ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        <!-- Total Flower Stems -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">
                    Total Flower Stems
                </p>
                <h2 class="text-3xl font-bold text-flora-dark mt-2">
                    {{ number_format($totalStems) }}
                </h2>
                <p class="text-xs text-gray-400 mt-1">
                    Stems in inventory
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-pink-50 text-flora-rose flex items-center justify-center text-2xl shadow-sm">
                <i class="fa-solid fa-seedling"></i>
            </div>
        </div>

        <!-- Total Flower Varieties -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">
                    Flower Varieties
                </p>
                <h2 class="text-3xl font-bold text-flora-dark mt-2">
                    {{ number_format($totalFlowers) }}
                </h2>
                <p class="text-xs text-gray-400 mt-1">
                    Different flower types
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-500 flex items-center justify-center text-2xl shadow-sm">
                <i class="fa-solid fa-spa"></i>
            </div>
        </div>

        <!-- Total Bouquets -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">
                    Pre-Made Bouquets
                </p>
                <h2 class="text-3xl font-bold text-flora-dark mt-2">
                    {{ number_format($totalBouquets) }}
                </h2>
                <p class="text-xs text-gray-400 mt-1">
                    Bouquet records
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-2xl shadow-sm">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
        </div>

        <!-- Total Packaging -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">
                    Packaging Options
                </p>
                <h2 class="text-3xl font-bold text-flora-dark mt-2">
                    {{ number_format($totalPackaging) }}
                </h2>
                <p class="text-xs text-gray-400 mt-1">
                    Available packaging types
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-2xl shadow-sm">
                <i class="fa-solid fa-box-open"></i>
            </div>
        </div>

    </div>

    <!-- ================= LOW STOCK SECTION ================= -->
    <x-card>
        <!-- Section Heading -->
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-flora-dark">
                    Low Stock Alerts
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">
                    Items that have fewer than 10 units remaining.
                </p>
            </div>

            <div>
                @if($lowStockItems->count() > 0)
                    <x-badge variant="danger">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                        {{ $lowStockItems->count() }} Items Need Attention
                    </x-badge>
                @else
                    <x-badge variant="success">
                        <i class="fa-solid fa-circle-check mr-1"></i>
                        All Stock Healthy
                    </x-badge>
                @endif
            </div>
        </div>

        <!-- Low Stock Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Item Name
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Category
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Stock Quantity
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($lowStockItems as $item)
                        <tr class="hover:bg-gray-50/80 transition">
                            <!-- Item Name -->
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-flora-dark">
                                    {{ $item->name }}
                                </p>
                            </td>

                            <!-- Category -->
                            <td class="px-6 py-4">
                                <x-badge variant="neutral">
                                    {{ $item->item_type }}
                                </x-badge>
                            </td>

                            <!-- Stock -->
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold {{ $item->stock_quantity <= 5 ? 'text-red-600' : 'text-amber-600' }}">
                                    {{ $item->stock_quantity }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if($item->stock_quantity == 0)
                                    <x-badge variant="danger">
                                        Out of Stock
                                    </x-badge>
                                @elseif($item->stock_quantity <= 5)
                                    <x-badge variant="danger">
                                        Critical Stock
                                    </x-badge>
                                @else
                                    <x-badge variant="warning">
                                        Low Stock
                                    </x-badge>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-empty-state
                                    icon="fa-circle-check"
                                    title="Everything looks good!"
                                    description="There are currently no items with low or critical stock levels." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            <p class="text-xs text-gray-400">
                Showing all inventory items with stock below 10 units.
            </p>
        </div>
    </x-card>

@endsection
