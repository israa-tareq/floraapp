@extends('layouts.admin')

@section('title', 'Sale Details')
@section('page-heading', 'Sale ' . $sale->sale_number)

@section('content')

    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.sales.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-[var(--flora-text-muted)] hover:text-[var(--flora-soldier-green)] transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Sales</span>
        </a>

        <form action="{{ route('admin.sales.destroy', $sale) }}"
              method="POST"
              onsubmit="return confirm('Delete this sale record? Stock for non-cancelled items will be restored.');">
            @csrf
            @method('DELETE')
            <x-button type="submit" variant="danger">
                <i class="fa-solid fa-trash-can"></i>
                <span>Delete Sale</span>
            </x-button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sale Summary -->
        <x-card class="p-6 space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-[var(--flora-text-muted)]">
                    Status
                </span>
                @if($sale->status === 'completed')
                    <x-badge variant="success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Completed</span>
                    </x-badge>
                @elseif($sale->status === 'pending')
                    <x-badge variant="warning">
                        <i class="fa-solid fa-clock"></i>
                        <span>Pending</span>
                    </x-badge>
                @else
                    <x-badge variant="danger">
                        <i class="fa-solid fa-ban"></i>
                        <span>Cancelled</span>
                    </x-badge>
                @endif
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-[var(--flora-text-muted)]">Customer</p>
                <p class="text-sm font-semibold text-[var(--flora-soldier-green)] mt-1">
                    {{ $sale->customer_name ?: 'Walk-in Customer' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-[var(--flora-text-muted)]">Sale Date</p>
                <p class="text-sm font-semibold text-[var(--flora-soldier-green)] mt-1">
                    {{ $sale->sold_at->format('M j, Y H:i') }}
                </p>
            </div>

            @if($sale->notes)
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-[var(--flora-text-muted)]">Notes</p>
                    <p class="text-sm text-[var(--flora-text-body)] mt-1">{{ $sale->notes }}</p>
                </div>
            @endif

            <div class="pt-4 border-t border-[var(--flora-border-subtle)]">
                <p class="text-xs font-semibold uppercase tracking-wider text-[var(--flora-text-muted)]">Total Amount</p>
                <p class="text-2xl font-bold text-[var(--flora-soldier-green)] mt-1">
                    ${{ number_format((float) $sale->total_amount, 2) }}
                </p>
            </div>

            <form action="{{ route('admin.sales.status', $sale) }}" method="POST" class="pt-4 border-t border-[var(--flora-border-subtle)] space-y-3">
                @csrf
                @method('PATCH')
                <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-[var(--flora-text-muted)]">
                    Update Status
                </label>
                <div class="flex items-center gap-2">
                    <select id="status" name="status" class="flora-input py-2 text-sm">
                        <option value="completed" {{ $sale->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ $sale->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="cancelled" {{ $sale->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <x-button type="submit" variant="primary" class="shrink-0">
                        Update
                    </x-button>
                </div>
            </form>
        </x-card>

        <!-- Sold Items Table -->
        <x-card class="lg:col-span-2">
            <div class="px-6 py-4 border-b border-[var(--flora-border-subtle)] flex items-center justify-between">
                <h2 class="text-base font-bold text-[var(--flora-soldier-green)]">
                    Sold Items
                </h2>
                <span class="text-xs font-semibold text-[var(--flora-text-muted)]">
                    {{ $sale->items->count() }} {{ \Illuminate\Support\Str::plural('line', $sale->items->count()) }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="flora-table-head">
                        <tr>
                            <th class="px-6 py-3.5">Product</th>
                            <th class="px-6 py-3.5">Category</th>
                            <th class="px-6 py-3.5 text-right">Unit Price</th>
                            <th class="px-6 py-3.5 text-right">Quantity</th>
                            <th class="px-6 py-3.5 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="flora-table-body">
                        @foreach($sale->items as $item)
                            <tr>
                                <td class="px-6 py-4 text-sm font-semibold text-[var(--flora-soldier-green)]">
                                    {{ $item->item_name }}
                                </td>
                                <td class="px-6 py-4">
                                    <x-badge variant="neutral" class="capitalize">
                                        {{ $item->item_type }}
                                    </x-badge>
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-[var(--flora-text-body)]">
                                    ${{ number_format((float) $item->unit_price, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-right text-[var(--flora-soldier-green)]">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-right text-[var(--flora-soldier-green)]">
                                    ${{ number_format((float) $item->subtotal, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>

@endsection
