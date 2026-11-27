<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flower;
use App\Models\PreMadeBouquet;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Services\SaleAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function __construct(
        protected SaleAnalyticsService $analyticsService
    ) {
    }

    /**
     * Display sales analytics and recent sales records.
     */
    public function index()
    {
        $analytics = $this->analyticsService->getAnalytics(14);
        $sales = Sale::withCount('items')
            ->with('items')
            ->latest('sold_at')
            ->latest('id')
            ->paginate(10);

        return view('admin.sales.index', array_merge($analytics, [
            'sales' => $sales,
        ]));
    }

    /**
     * Show the form for recording a new sale.
     */
    public function create()
    {
        $flowers = Flower::orderBy('name')->get();
        $bouquets = PreMadeBouquet::orderBy('name')->get();

        return view('admin.sales.create', compact('flowers', 'bouquets'));
    }

    /**
     * Record a new sale and deduct sold quantities from inventory.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'status' => ['required', Rule::in(['completed', 'pending'])],
            'sold_at' => 'required|date',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'items.required' => 'Please add at least one flower or bouquet to the sale.',
            'items.min' => 'Please add at least one flower or bouquet to the sale.',
        ]);

        DB::transaction(function () use ($validated) {
            // Merge duplicate product rows before validating stock and creating line items.
            $mergedQuantities = [];

            foreach ($validated['items'] as $index => $row) {
                $parts = explode(':', $row['product'], 2);

                if (count($parts) !== 2 || ! in_array($parts[0], ['flower', 'bouquet'], true) || ! ctype_digit($parts[1])) {
                    throw ValidationException::withMessages([
                        "items.{$index}.product" => 'Please select a valid flower or pre-made bouquet.',
                    ]);
                }

                $key = $parts[0] . ':' . (int) $parts[1];
                $mergedQuantities[$key] = ($mergedQuantities[$key] ?? 0) + (int) $row['quantity'];
            }

            $sale = Sale::create([
                'sale_number' => $this->generateSaleNumber(),
                'customer_name' => $validated['customer_name'] ?? null,
                'status' => $validated['status'],
                'total_amount' => 0,
                'sold_at' => $validated['sold_at'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $totalAmount = 0;

            foreach ($mergedQuantities as $key => $quantity) {
                [$type, $id] = explode(':', $key, 2);
                $id = (int) $id;

                if ($type === 'flower') {
                    $product = Flower::lockForUpdate()->find($id);
                    $unitPrice = $product?->price_per_stem ?? 0;
                } else {
                    $product = PreMadeBouquet::lockForUpdate()->find($id);
                    $unitPrice = $product?->price ?? 0;
                }

                if (! $product) {
                    throw ValidationException::withMessages([
                        'items' => 'One of the selected products could not be found.',
                    ]);
                }

                if ($product->stock_quantity < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => "Insufficient stock for {$product->name}. Available: {$product->stock_quantity}.",
                    ]);
                }

                $product->decrement('stock_quantity', $quantity);

                $subtotal = round(((float) $unitPrice) * $quantity, 2);
                $totalAmount += $subtotal;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'flower_id' => $type === 'flower' ? $product->id : null,
                    'pre_made_bouquet_id' => $type === 'bouquet' ? $product->id : null,
                    'item_type' => $type,
                    'item_name' => $product->name,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);
            }

            $sale->update([
                'total_amount' => round($totalAmount, 2),
            ]);
        });

        return redirect()
            ->route('admin.sales.index')
            ->with('success', 'Sale recorded successfully!');
    }

    /**
     * Display a single sale receipt and item breakdown.
     */
    public function show(Sale $sale)
    {
        $sale->load('items');

        return view('admin.sales.show', compact('sale'));
    }

    /**
     * Update a sale's status and reconcile stock if cancelled or reactivated.
     */
    public function updateStatus(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['completed', 'pending', 'cancelled'])],
        ]);

        $newStatus = $validated['status'];
        $oldStatus = $sale->status;

        if ($oldStatus === $newStatus) {
            return back();
        }

        DB::transaction(function () use ($sale, $oldStatus, $newStatus) {
            $sale->load('items');

            if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
                $this->restoreInventory($sale);
            } elseif ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                $this->deductInventory($sale);
            }

            $sale->update(['status' => $newStatus]);
        });

        return back()->with('success', 'Sale status updated successfully!');
    }

    /**
     * Delete a sale record and restore inventory if it was not cancelled.
     */
    public function destroy(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            $sale->load('items');

            if ($sale->status !== 'cancelled') {
                $this->restoreInventory($sale);
            }

            $sale->delete();
        });

        return redirect()
            ->route('admin.sales.index')
            ->with('success', 'Sale deleted successfully!');
    }

    /**
     * Restore product stock quantities when a sale is cancelled or deleted.
     */
    protected function restoreInventory(Sale $sale): void
    {
        foreach ($sale->items as $item) {
            if ($item->item_type === 'flower' && $item->flower_id) {
                Flower::whereKey($item->flower_id)->increment('stock_quantity', $item->quantity);
            } elseif ($item->item_type === 'bouquet' && $item->pre_made_bouquet_id) {
                PreMadeBouquet::whereKey($item->pre_made_bouquet_id)->increment('stock_quantity', $item->quantity);
            }
        }
    }

    /**
     * Deduct product stock quantities when a cancelled sale is reactivated.
     */
    protected function deductInventory(Sale $sale): void
    {
        foreach ($sale->items as $item) {
            $product = $item->item_type === 'flower' && $item->flower_id
                ? Flower::lockForUpdate()->find($item->flower_id)
                : ($item->item_type === 'bouquet' && $item->pre_made_bouquet_id
                    ? PreMadeBouquet::lockForUpdate()->find($item->pre_made_bouquet_id)
                    : null);

            if (! $product) {
                continue;
            }

            if ($product->stock_quantity < $item->quantity) {
                throw ValidationException::withMessages([
                    'status' => "Insufficient stock to reactivate sale for {$product->name}. Available: {$product->stock_quantity}.",
                ]);
            }

            $product->decrement('stock_quantity', $item->quantity);
        }
    }

    /**
     * Generate a unique, human-readable sale reference number.
     */
    protected function generateSaleNumber(): string
    {
        do {
            $number = 'FL-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
        } while (Sale::where('sale_number', $number)->exists());

        return $number;
    }
}
