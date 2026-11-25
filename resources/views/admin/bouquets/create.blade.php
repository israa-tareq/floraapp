@extends('layouts.admin')

@section('title', 'Add Bouquet')
@section('page-heading', 'Add Bouquet')

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.bouquets.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-[var(--flora-text-muted)] hover:text-[var(--flora-soldier-green)] transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Pre-Made Bouquets</span>
        </a>

        <h1 class="text-2xl font-bold text-[var(--flora-soldier-green)] mt-3 tracking-tight">
            Add Bouquet
        </h1>
    </div>

    <x-card class="p-6 sm:p-8 max-w-3xl">
        <form action="{{ route('admin.bouquets.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
                    Bouquet Name <span class="text-[var(--flora-usukoubai)]">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       class="flora-input @error('name') flora-input-error @enderror"
                       placeholder="e.g. Romantic Red Roses">
                @error('name')
                    <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
                    Description
                </label>
                <textarea id="description"
                          name="description"
                          rows="4"
                          class="flora-input @error('description') flora-input-error @enderror"
                          placeholder="Bouquet arrangement details">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price and Stock -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="price" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
                        Price <span class="text-[var(--flora-usukoubai)]">*</span>
                    </label>
                    <input type="number"
                           id="price"
                           name="price"
                           value="{{ old('price') }}"
                           min="0"
                           step="0.01"
                           required
                           class="flora-input @error('price') flora-input-error @enderror"
                           placeholder="0.00">
                    @error('price')
                        <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock_quantity" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
                        Stock Quantity <span class="text-[var(--flora-usukoubai)]">*</span>
                    </label>
                    <input type="number"
                           id="stock_quantity"
                           name="stock_quantity"
                           value="{{ old('stock_quantity', 0) }}"
                           min="0"
                           required
                           class="flora-input @error('stock_quantity') flora-input-error @enderror"
                           placeholder="0">
                    @error('stock_quantity')
                        <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
                    Bouquet Image (Optional)
                </label>
                <input type="file"
                       id="image"
                       name="image"
                       accept=".jpg,.jpeg,.png,.webp"
                       class="flora-file-input">
                <p class="text-xs text-[var(--flora-text-muted)] mt-1.5">
                    JPG, JPEG, PNG, or WebP (max 2 MB)
                </p>
                @error('image')
                    <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Featured Checkbox -->
            <div>
                <input type="hidden" name="is_featured" value="0">
                <label class="inline-flex items-center gap-3 cursor-pointer">
                    <input type="checkbox"
                           id="is_featured"
                           name="is_featured"
                           value="1"
                           {{ old('is_featured') ? 'checked' : '' }}
                           class="w-4 h-4 rounded accent-[var(--flora-usukoubai)]">
                    <span class="text-sm font-semibold text-[var(--flora-soldier-green)]">
                        Featured Bouquet
                    </span>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-6 border-t border-[var(--flora-border-subtle)]">
                <x-button type="submit" variant="primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Bouquet</span>
                </x-button>

                <x-button href="{{ route('admin.bouquets.index') }}" variant="secondary">
                    Cancel
                </x-button>
            </div>
        </form>
    </x-card>

@endsection
