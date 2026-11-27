@extends('layouts.admin')

@section('title', 'Record Sale')
@section('page-heading', 'Record Sale')

@section('content')

    <div class="mb-5">
        <a href="{{ route('admin.sales.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-[var(--flora-text-muted)] hover:text-[var(--flora-soldier-green)] transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Sales</span>
        </a>
    </div>

    @php
        $productOptions = [];

        foreach ($flowers as $flower) {
            $productOptions[] = [
                'value' => 'flower:' . $flower->id,
                'label' => $flower->name . ' (Flower — $' . number_format((float) $flower->price_per_stem, 2) . ', Stock: ' . $flower->stock_quantity . ')',
                'price' => (float) $flower->price_per_stem,
                'stock' => (int) $flower->stock_quantity,
            ];
        }

        foreach ($bouquets as $bouquet) {
            $productOptions[] = [
                'value' => 'bouquet:' . $bouquet->id,
                'label' => $bouquet->name . ' (Bouquet — $' . number_format((float) $bouquet->price, 2) . ', Stock: ' . $bouquet->stock_quantity . ')',
                'price' => (float) $bouquet->price,
                'stock' => (int) $bouquet->stock_quantity,
            ];
        }

        $initialItems = old('items', [['product' => '', 'quantity' => 1]]);
    @endphp

    <x-card class="p-6 sm:p-8 max-w-4xl">
        <form action="{{ route('admin.sales.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="customer_name" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
                        Customer Name
                    </label>
                    <input type="text"
                           id="customer_name"
                           name="customer_name"
                           value="{{ old('customer_name') }}"
                           placeholder="Walk-in Customer"
                           class="flora-input @error('customer_name') flora-input-error @enderror">
                    @error('customer_name')
                        <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
                        Status <span class="text-[var(--flora-usukoubai)]">*</span>
                    </label>
                    <select id="status" name="status" required class="flora-input">
                        <option value="completed" {{ old('status', 'completed') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sold_at" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
                        Sale Date &amp; Time <span class="text-[var(--flora-usukoubai)]">*</span>
                    </label>
                    <input type="datetime-local"
                           id="sold_at"
                           name="sold_at"
                           value="{{ old('sold_at', now()->format('Y-m-d\TH:i')) }}"
                           required
                           class="flora-input @error('sold_at') flora-input-error @enderror">
                    @error('sold_at')
                        <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Line Items -->
            <div>
                <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                    <label class="text-sm font-semibold text-[var(--flora-soldier-green)]">
                        Sale Items <span class="text-[var(--flora-usukoubai)]">*</span>
                    </label>

                    <x-button type="button" variant="secondary" id="addSaleItemBtn">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Item</span>
                    </x-button>
                </div>

                <div id="saleItemsContainer" class="space-y-3">
                    @foreach($initialItems as $index => $row)
                        <div class="sale-item-row grid grid-cols-1 md:grid-cols-12 gap-3 items-center p-3.5 rounded-xl bg-[var(--flora-bg-surface)] border border-[var(--flora-border-subtle)]">
                            <div class="md:col-span-7">
                                <select name="items[{{ $index }}][product]"
                                        required
                                        class="flora-input sale-product-select">
                                    <option value="">Select flower or bouquet</option>
                                    @foreach($productOptions as $option)
                                        <option value="{{ $option['value'] }}"
                                                data-price="{{ $option['price'] }}"
                                                {{ ($row['product'] ?? '') === $option['value'] ? 'selected' : '' }}>
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <input type="number"
                                       name="items[{{ $index }}][quantity]"
                                       value="{{ $row['quantity'] ?? 1 }}"
                                       min="1"
                                       required
                                       aria-label="Quantity"
                                       class="flora-input sale-qty-input">
                            </div>

                            <div class="md:col-span-2 text-sm font-semibold text-[var(--flora-soldier-green)] md:text-right">
                                <span class="sale-line-subtotal">$0.00</span>
                            </div>

                            <div class="md:col-span-1 flex justify-end">
                                <button type="button"
                                        class="remove-sale-item text-[var(--flora-status-danger-text)] hover:bg-[var(--flora-status-danger-bg)] p-2 rounded-lg transition"
                                        aria-label="Remove item"
                                        title="Remove item">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                @error('items')
                    <p class="text-xs text-[var(--flora-status-danger-text)] mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes & Computed Total -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-start">
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
                        Notes (Optional)
                    </label>
                    <textarea id="notes"
                              name="notes"
                              rows="3"
                              placeholder="Optional order notes"
                              class="flora-input">{{ old('notes') }}</textarea>
                </div>

                <div class="p-4 rounded-xl bg-[var(--flora-bg-subtle)] border border-[var(--flora-border-subtle)]">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[var(--flora-text-muted)]">
                        Estimated Total
                    </p>
                    <p id="saleEstimatedTotal" class="text-2xl font-bold text-[var(--flora-soldier-green)] mt-1">
                        $0.00
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-6 border-t border-[var(--flora-border-subtle)]">
                <x-button type="submit" variant="primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Sale</span>
                </x-button>

                <x-button href="{{ route('admin.sales.index') }}" variant="secondary">
                    Cancel
                </x-button>
            </div>
        </form>
    </x-card>

@endsection

@push('scripts')
<script>
    (function () {
        const container = document.getElementById('saleItemsContainer');
        const addBtn = document.getElementById('addSaleItemBtn');
        const totalEl = document.getElementById('saleEstimatedTotal');
        const productOptions = @json($productOptions);

        let nextIndex = container.querySelectorAll('.sale-item-row').length;

        function recalculateTotals() {
            let grandTotal = 0;

            container.querySelectorAll('.sale-item-row').forEach((row) => {
                const select = row.querySelector('.sale-product-select');
                const qtyInput = row.querySelector('.sale-qty-input');
                const subtotalEl = row.querySelector('.sale-line-subtotal');

                const selectedOption = select.options[select.selectedIndex];
                const price = selectedOption ? parseFloat(selectedOption.dataset.price || '0') : 0;
                const qty = Math.max(0, parseInt(qtyInput.value || '0', 10));
                const lineTotal = price * qty;

                subtotalEl.textContent = '$' + lineTotal.toFixed(2);
                grandTotal += lineTotal;
            });

            totalEl.textContent = '$' + grandTotal.toFixed(2);
        }

        function buildOptionsHtml() {
            let html = '<option value="">Select flower or bouquet</option>';
            productOptions.forEach((opt) => {
                const escapedLabel = opt.label
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;');
                html += `<option value="${opt.value}" data-price="${opt.price}">${escapedLabel}</option>`;
            });
            return html;
        }

        addBtn.addEventListener('click', () => {
            const idx = nextIndex++;
            const row = document.createElement('div');
            row.className = 'sale-item-row grid grid-cols-1 md:grid-cols-12 gap-3 items-center p-3.5 rounded-xl bg-[var(--flora-bg-surface)] border border-[var(--flora-border-subtle)]';

            row.innerHTML = `
                <div class="md:col-span-7">
                    <select name="items[${idx}][product]" required class="flora-input sale-product-select">
                        ${buildOptionsHtml()}
                    </select>
                </div>
                <div class="md:col-span-2">
                    <input type="number" name="items[${idx}][quantity]" value="1" min="1" required aria-label="Quantity" class="flora-input sale-qty-input">
                </div>
                <div class="md:col-span-2 text-sm font-semibold text-[var(--flora-soldier-green)] md:text-right">
                    <span class="sale-line-subtotal">$0.00</span>
                </div>
                <div class="md:col-span-1 flex justify-end">
                    <button type="button" class="remove-sale-item text-[var(--flora-status-danger-text)] hover:bg-[var(--flora-status-danger-bg)] p-2 rounded-lg transition" aria-label="Remove item" title="Remove item">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            `;

            container.appendChild(row);
            recalculateTotals();
        });

        container.addEventListener('click', (event) => {
            const removeBtn = event.target.closest('.remove-sale-item');
            if (!removeBtn) return;

            const rows = container.querySelectorAll('.sale-item-row');
            if (rows.length <= 1) {
                if (window.FloraToast) {
                    window.FloraToast.show('A sale must include at least one item.', 'warning');
                }
                return;
            }

            removeBtn.closest('.sale-item-row').remove();
            recalculateTotals();
        });

        container.addEventListener('change', recalculateTotals);
        container.addEventListener('input', recalculateTotals);

        recalculateTotals();
    })();
</script>
@endpush
