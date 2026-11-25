@extends('layouts.admin')

@section('title', 'Add Flower')
@section('page-heading', 'Add Flower')

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.flowers.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-[var(--flora-text-muted)] hover:text-[var(--flora-soldier-green)] transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Flowers</span>
        </a>

        <h1 class="text-2xl font-bold text-[var(--flora-soldier-green)] mt-3 tracking-tight">
            Add Flower
        </h1>
    </div>

    <x-card class="p-6 md:p-8 max-w-3xl">
        <form action="{{ route('admin.flowers.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Flower Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold mb-2 text-[var(--flora-soldier-green)]">
                        Flower Name <span class="text-[var(--flora-usukoubai)]">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="Example: Red Rose"
                           required
                           class="flora-input @error('name') flora-input-error @enderror">
                    @error('name')
                        <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-semibold mb-2 text-[var(--flora-soldier-green)]">
                        Color <span class="text-[var(--flora-usukoubai)]">*</span>
                    </label>
                    <input type="text"
                           id="color"
                           name="color"
                           value="{{ old('color') }}"
                           placeholder="Example: Red"
                           required
                           class="flora-input @error('color') flora-input-error @enderror">
                    @error('color')
                        <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price_per_stem" class="block text-sm font-semibold mb-2 text-[var(--flora-soldier-green)]">
                        Price Per Stem <span class="text-[var(--flora-usukoubai)]">*</span>
                    </label>
                    <input type="number"
                           id="price_per_stem"
                           name="price_per_stem"
                           value="{{ old('price_per_stem') }}"
                           placeholder="0.00"
                           min="0"
                           step="0.01"
                           required
                           class="flora-input @error('price_per_stem') flora-input-error @enderror">
                    @error('price_per_stem')
                        <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock_quantity" class="block text-sm font-semibold mb-2 text-[var(--flora-soldier-green)]">
                        Stock Quantity <span class="text-[var(--flora-usukoubai)]">*</span>
                    </label>
                    <input type="number"
                           id="stock_quantity"
                           name="stock_quantity"
                           value="{{ old('stock_quantity') }}"
                           placeholder="0"
                           min="0"
                           step="1"
                           required
                           class="flora-input @error('stock_quantity') flora-input-error @enderror">
                    @error('stock_quantity')
                        <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-semibold mb-2 text-[var(--flora-soldier-green)]">
                        Flower Image
                    </label>
                    <input type="file"
                           id="image"
                           name="image"
                           accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="flora-file-input">
                    <p class="text-xs text-[var(--flora-text-muted)] mt-1.5">
                        JPG, JPEG, PNG, or WebP (max 2 MB)
                    </p>
                    @error('image')
                        <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Availability -->
                <div class="md:col-span-2">
                    <input type="hidden" name="is_available" value="0">
                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input type="checkbox"
                               name="is_available"
                               value="1"
                               {{ old('is_available', '1') == '1' ? 'checked' : '' }}
                               class="w-4 h-4 accent-[var(--flora-usukoubai)] rounded">
                        <span class="text-sm font-medium text-[var(--flora-soldier-green)]">
                            Available for purchase
                        </span>
                    </label>
                </div>

            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-[var(--flora-border-subtle)]">
                <x-button type="submit" variant="primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Flower</span>
                </x-button>

                <x-button href="{{ route('admin.flowers.index') }}" variant="secondary">
                    Cancel
                </x-button>
            </div>
        </form>
    </x-card>

@endsection
