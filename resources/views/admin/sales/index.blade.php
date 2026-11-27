@extends('layouts.admin')

@section('title', 'Sales')
@section('page-heading', 'Sales')

@section('content')

    <!-- Top Sales Action Bar -->
    <div class="flex flex-wrap items-center justify-end gap-3 mb-6">
        <x-button href="{{ route('admin.sales.create') }}" variant="primary">
            <i class="fa-solid fa-plus"></i>
            <span>Record Sale</span>
        </x-button>
    </div>

    <!-- Real-Data Sales Analytics Cards, Trend Chart, and Best-Selling Breakdowns -->
    @include('admin.sales.partials.analytics-widgets')

    <!-- Recent Sales Table -->
    <x-card>
        <div class="px-6 py-4 border-b border-[var(--flora-border-subtle)] flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <h2 class="text-base font-bold text-[var(--flora-soldier-green)]">
                    Recent Sales
                </h2>
                <span class="text-xs font-semibold text-[var(--flora-text-muted)]">
                    {{ $sales->total() }} {{ \Illuminate\Support\Str::plural('record', $sales->total()) }}
                </span>
            </div>

            <x-button href="{{ route('admin.sales.create') }}" variant="secondary">
                <i class="fa-solid fa-plus"></i>
                <span>New Sale</span>
            </x-button>
        </div>

        @if($sales->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="flora-table-head">
                        <tr>
                            <th class="px-6 py-3.5">Sale #</th>
                            <th class="px-6 py-3.5">Customer</th>
                            <th class="px-6 py-3.5">Items</th>
                            <th class="px-6 py-3.5">Date</th>
                            <th class="px-6 py-3.5">Total</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="flora-table-body">
                        @foreach($sales as $sale)
                            <tr>
                                <td class="px-6 py-4 text-sm font-semibold text-[var(--flora-soldier-green)]">
                                    <a href="{{ route('admin.sales.show', $sale) }}"
                                       class="hover:text-[var(--flora-usukoubai)] transition">
                                        {{ $sale->sale_number }}
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-sm text-[var(--flora-text-body)]">
                                    {{ $sale->customer_name ?: 'Walk-in Customer' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-[var(--flora-text-muted)]">
                                    {{ $sale->items->sum('quantity') }} {{ \Illuminate\Support\Str::plural('unit', $sale->items->sum('quantity')) }}
                                </td>

                                <td class="px-6 py-4 text-sm text-[var(--flora-text-muted)]">
                                    {{ $sale->sold_at->format('M j, Y H:i') }}
                                </td>

                                <td class="px-6 py-4 text-sm font-semibold text-[var(--flora-soldier-green)]">
                                    ${{ number_format((float) $sale->total_amount, 2) }}
                                </td>

                                <td class="px-6 py-4">
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
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('admin.sales.show', $sale) }}"
                                           class="inline-flex items-center gap-1.5 text-sm font-semibold text-[var(--flora-soldier-green)] hover:text-[var(--flora-usukoubai)] transition">
                                            <i class="fa-solid fa-eye"></i>
                                            <span>View</span>
                                        </a>

                                        <form action="{{ route('admin.sales.destroy', $sale) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this sale record? Stock for non-cancelled items will be restored.');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-[var(--flora-status-danger-text)] hover:text-[var(--flora-usukoubai)] transition">
                                                <i class="fa-solid fa-trash-can"></i>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($sales->hasPages())
                <div class="p-5 border-t border-[var(--flora-border-subtle)] bg-[var(--flora-bg-surface)]">
                    {{ $sales->links() }}
                </div>
            @endif
        @else
            <x-empty-state
                icon="fa-receipt"
                title="No sales recorded yet">
                <x-slot:action>
                    <x-button href="{{ route('admin.sales.create') }}" variant="primary">
                        <i class="fa-solid fa-plus"></i>
                        <span>Record First Sale</span>
                    </x-button>
                </x-slot:action>
            </x-empty-state>
        @endif
    </x-card>

@endsection
