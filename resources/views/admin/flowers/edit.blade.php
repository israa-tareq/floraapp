@extends('layouts.admin')

@section('title', 'Edit Flower')
@section('page-heading', 'Edit Flower: ' . $flower->name)

@section('content')

    <div class="mb-5">
        <a href="{{ route('admin.flowers.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-[var(--flora-text-muted)] hover:text-[var(--flora-soldier-green)] transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Flowers</span>
        </a>
    </div>

    <x-card class="p-6 md:p-8 max-w-3xl">
        <form action="{{ route('admin.flowers.update', $flower) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Flower Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold mb-2 text-[var(--flora-soldier-green)]">
                        Flower Name <span class="text-[var(--flora-usukoubai)]">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $flower->name) }}"
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
                           value="{{ old('color', $flower->color) }}"
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
                           value="{{ old('price_per_stem', $flower->price_per_stem) }}"
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
                           value="{{ old('stock_quantity', $flower->stock_quantity) }}"
                           min="0"
                           step="1"
                           required
                           class="flora-input @error('stock_quantity') flora-input-error @enderror">
                    @error('stock_quantity')
                        <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Image & Replacement -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2 text-[var(--flora-soldier-green)]">
                        Current Image
                    </label>

                    <div class="mb-4">
                        @if($flower->image_path)
                            <img src="{{ asset('storage/' . $flower->image_path) }}"
                                 alt="{{ $flower->name }}"
                                 class="w-28 h-28 rounded-2xl object-cover border border-[var(--flora-border-subtle)]">
                        @else
                            <div class="w-28 h-28 rounded-2xl bg-[var(--flora-bg-subtle)] text-[var(--flora-text-muted)]
                                        flex items-center justify-center text-3xl border border-[var(--flora-border-subtle)]">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        @endif
                    </div>

                    <label for="image" class="block text-sm font-semibold mb-2 text-[var(--flora-soldier-green)]">
                        Replace Image (Optional)
                    </label>
                    <input type="file"
                           id="image"
                           name="image"
                           accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="flora-file-input">
                    <p class="text-xs text-[var(--flora-text-muted)] mt-1.5">
                        Leave blank to keep current image. JPG, JPEG, PNG, or WebP (max 2 MB)
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
                               {{ old('is_available', $flower->is_available) ? 'checked' : '' }}
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
                    <span>Update Flower</span>
                </x-button>

                <x-button href="{{ route('admin.flowers.index') }}" variant="secondary">
                    Cancel
                </x-button>
            </div>
        </form>
    </x-card>

@endsection
