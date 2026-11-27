<?php

namespace App\Services;

use App\Models\Flower;
use App\Models\PreMadeBouquet;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SaleAnalyticsService
{
    /**
     * Build complete sales statistics from actual database records.
     */
    public function getAnalytics(int $trendDays = 14): array
    {
        $totalRevenue = (float) Sale::where('status', 'completed')->sum('total_amount');
        $completedSalesCount = Sale::where('status', 'completed')->count();

        $totalUnitsSold = (int) SaleItem::whereHas('sale', function ($query) {
            $query->where('status', 'completed');
        })->sum('quantity');

        $bestSellingFlowers = $this->getBestSellingByType('flower', 5);
        $bestSellingBouquets = $this->getBestSellingByType('bouquet', 5);
        $mostPopularProducts = $this->getMostPopularProducts(6);
        $salesTrend = $this->getSalesTrend($trendDays);
        $recentSales = Sale::withCount('items')
            ->with('items')
            ->latest('sold_at')
            ->latest('id')
            ->take(6)
            ->get();

        return [
            'totalRevenue' => $totalRevenue,
            'completedSalesCount' => $completedSalesCount,
            'totalUnitsSold' => $totalUnitsSold,
            'bestSellingFlowers' => $bestSellingFlowers,
            'bestSellingBouquets' => $bestSellingBouquets,
            'mostPopularProducts' => $mostPopularProducts,
            'salesTrend' => $salesTrend,
            'recentSales' => $recentSales,
        ];
    }

    /**
     * Aggregate best-selling items for a specific product type ('flower' or 'bouquet').
     */
    protected function getBestSellingByType(string $type, int $limit = 5): Collection
    {
        $foreignKey = $type === 'flower' ? 'flower_id' : 'pre_made_bouquet_id';

        $rows = SaleItem::query()
            ->selectRaw("{$foreignKey} as product_id, MAX(item_name) as product_name, SUM(quantity) as total_sold, SUM(subtotal) as total_revenue")
            ->where('item_type', $type)
            ->whereHas('sale', function ($query) {
                $query->where('status', 'completed');
            })
            ->groupBy($foreignKey)
            ->orderByDesc('total_sold')
            ->orderByDesc('total_revenue')
            ->take($limit)
            ->get();

        $ids = $rows->pluck('product_id')->filter()->values();

        $liveNames = $type === 'flower'
            ? Flower::whereIn('id', $ids)->pluck('name', 'id')
            : PreMadeBouquet::whereIn('id', $ids)->pluck('name', 'id');

        return $rows->map(function ($row) use ($type, $liveNames) {
            return (object) [
                'product_id' => $row->product_id,
                'item_type' => $type,
                'name' => $liveNames[$row->product_id] ?? $row->product_name,
                'total_sold' => (int) $row->total_sold,
                'total_revenue' => (float) $row->total_revenue,
            ];
        });
    }

    /**
     * Combine flowers and bouquets into one ranked list of most popular products.
     */
    protected function getMostPopularProducts(int $limit = 6): Collection
    {
        $flowers = $this->getBestSellingByType('flower', $limit);
        $bouquets = $this->getBestSellingByType('bouquet', $limit);

        return $flowers
            ->concat($bouquets)
            ->sortByDesc('total_sold')
            ->values()
            ->take($limit);
    }

    /**
     * Build daily revenue and completed sales counts for the last N days.
     */
    protected function getSalesTrend(int $days = 14): Collection
    {
        $startDate = Carbon::today()->subDays($days - 1)->startOfDay();
        $endDate = Carbon::today()->endOfDay();

        $completedSales = Sale::query()
            ->where('status', 'completed')
            ->whereBetween('sold_at', [$startDate, $endDate])
            ->get(['sold_at', 'total_amount']);

        $grouped = $completedSales->groupBy(function ($sale) {
            return $sale->sold_at->format('Y-m-d');
        });

        $trend = collect();

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $key = $date->format('Y-m-d');
            $daySales = $grouped->get($key, collect());

            $trend->push((object) [
                'date' => $key,
                'label' => $date->format('M j'),
                'revenue' => (float) $daySales->sum('total_amount'),
                'count' => $daySales->count(),
            ]);
        }

        return $trend;
    }
}
