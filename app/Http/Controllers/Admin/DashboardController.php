<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flower;
use App\Models\PreMadeBouquet;
use App\Models\PackagingOption;

class DashboardController extends Controller
{
    public function index()
    {
        // Total number of flower stems available in stock.
        $totalStems = Flower::sum('stock_quantity');

        // Total number of different flower varieties.
        $totalFlowers = Flower::count();

        // Total number of pre-made bouquet records.
        $totalBouquets = PreMadeBouquet::count();

        // Total number of packaging options.
        $totalPackaging = PackagingOption::count();


        // Retrieve flowers with stock below 10.
        $lowStockFlowers = Flower::where('stock_quantity', '<', 10)
            ->get()
            ->map(function ($flower) {
                $flower->item_type = 'Flower';
                return $flower;
            });


        // Retrieve bouquets with stock below 10.
        $lowStockBouquets = PreMadeBouquet::where('stock_quantity', '<', 10)
            ->get()
            ->map(function ($bouquet) {
                $bouquet->item_type = 'Bouquet';
                return $bouquet;
            });


        // Retrieve packaging options with stock below 10.
        $lowStockPackaging = PackagingOption::where('stock_quantity', '<', 10)
            ->get()
            ->map(function ($option) {
                $option->item_type = 'Packaging';
                return $option;
            });


        // Combine all low-stock items into one collection.
        $lowStockItems = $lowStockFlowers
            ->concat($lowStockBouquets)
            ->concat($lowStockPackaging)
            ->sortBy('stock_quantity')
            ->values();


        // Send all dashboard information to the Blade view.
        return view('admin.dashboard', compact(
            'totalStems',
            'totalFlowers',
            'totalBouquets',
            'totalPackaging',
            'lowStockItems'
        ));
    }
}