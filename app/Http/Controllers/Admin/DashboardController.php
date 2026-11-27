<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flower;
use App\Models\PackagingOption;
use App\Models\PreMadeBouquet;
use App\Services\SaleAnalyticsService;

class DashboardController extends Controller
{
    public function __construct(
        protected SaleAnalyticsService $analyticsService
    ) {
    }

    public function index()
    {
        // Inventory metrics
        $totalStems = Flower::sum('stock_quantity');
        $totalFlowers = Flower::count();
        $totalBouquets = PreMadeBouquet::count();
        $totalPackaging = PackagingOption::count();

        // Low stock alerts (stock below 10)
        $lowStockFlowers = Flower::where('stock_quantity', '<', 10)
            ->get()
            ->map(function ($flower) {
                $flower->item_type = 'Flower';
                return $flower;
            });

        $lowStockBouquets = PreMadeBouquet::where('stock_quantity', '<', 10)
            ->get()
            ->map(function ($bouquet) {
                $bouquet->item_type = 'Bouquet';
                return $bouquet;
            });

        $lowStockPackaging = PackagingOption::where('stock_quantity', '<', 10)
            ->get()
            ->map(function ($option) {
                $option->item_type = 'Packaging';
                return $option;
            });

        $lowStockItems = $lowStockFlowers
            ->concat($lowStockBouquets)
            ->concat($lowStockPackaging)
            ->sortBy('stock_quantity')
            ->values();

        // Real sales analytics from database records
        $salesAnalytics = $this->analyticsService->getAnalytics(14);

        return view('admin.dashboard', array_merge([
            'totalStems' => $totalStems,
            'totalFlowers' => $totalFlowers,
            'totalBouquets' => $totalBouquets,
            'totalPackaging' => $totalPackaging,
            'lowStockItems' => $lowStockItems,
        ], $salesAnalytics));
    }
}
