@extends('layouts.admin')

@section('title', 'Add Packaging Option')
@section('page-heading', 'Add Packaging Option')

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.packaging.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-[var(--flora-text-muted)] hover:text-[var(--flora-soldier-green)] transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Packaging Options</span>
        </a>

        <h1 class="text-2xl font-bold text-[var(--flora-soldier-green)] mt-3 tracking-tight">
            Add Packaging Option
        </h1>
    </div>

    <x-card class="p-6 sm:p-8 max-w-3xl">
        <form action="{{ route('admin.packaging.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            <!-- Type -->
            <div>
                <label for="type" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
                    Packaging Type <span class="text-[var(--flora-usukoubai)]">*</span>
                </label>
                <select id="type"
                        name="type"
                        required
                        class="flora-input @error('type') flora-input-error @enderror">
                    <option value="">Select a packaging type</option>
                    <option value="wrap" {{ old('type') == 'wrap' ? 'selected' : '' }}>Wrapping Paper</option>
                    <option value="ribbon" {{ old('type') == 'ribbon' ? 'selected' : '' }}>Ribbon</option>
                    <option value="box" {{ old('type') == 'box' ? 'selected' : '' }}>Gift Box</option>
                </select>
                @error('type')
                    <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Item Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
                    Item Name <span class="text-[var(--flora-usukoubai)]">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       class="flora-input @error('name') flora-input-error @enderror"
                       placeholder="e.g. Pink Floral Wrapping Sheet">
                @error('name')
                    <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Color and Price -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="color" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
                        Color <span class="text-[var(--flora-usukoubai)]">*</span>
                    </label>
                    <input type="text"
                           id="color"
                           name="color"
                           value="{{ old('color') }}"
                           required
                           class="flora-input @error('color') flora-input-error @enderror"
                           placeholder="e.g. Dusty Rose">
                    @error('color')
                        <p class="text-xs text-[var(--flora-status-danger-text)] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

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
            </div>

            <!-- Stock Quantity -->
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

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-semibold text-[var(--flora-soldier-green)] mb-2">
                    Packaging Image (Optional)
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

            <!-- Buttons -->
            <div class="flex items-center gap-3 pt-6 border-t border-[var(--flora-border-subtle)]">
                <x-button type="submit" variant="primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Packaging Option</span>
                </x-button>

                <x-button href="{{ route('admin.packaging.index') }}" variant="secondary">
                    Cancel
                </x-button>
            </div>
        </form>
    </x-card>

@endsection
