@extends('layouts.admin')

@section('title', 'Add Bouquet')
@section('page-heading', 'Add New Bouquet')
@section('page-subheading', 'Create a new pre-made flower bouquet arrangement.')

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.bouquets.index') }}"
           class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-flora-dark transition">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Back to Bouquets
        </a>

        <h1 class="text-2xl font-bold text-flora-dark mt-3 tracking-tight">
            Add New Bouquet
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Enter the details of the new pre-made bouquet.
        </p>
    </div>

    <x-card class="p-6 sm:p-8 max-w-3xl">
        <form action="{{ route('admin.bouquets.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-flora-dark mb-2">
                    Bouquet Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink"
                       placeholder="e.g. Romantic Red Roses">
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-flora-dark mb-2">
                    Description
                </label>
                <textarea id="description"
                          name="description"
                          rows="4"
                          class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink"
                          placeholder="Describe this bouquet arrangement...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price and Stock -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="price" class="block text-sm font-semibold text-flora-dark mb-2">
                        Price <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           id="price"
                           name="price"
                           value="{{ old('price') }}"
                           min="0"
                           step="0.01"
                           required
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink"
                           placeholder="0.00">
                    @error('price')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock_quantity" class="block text-sm font-semibold text-flora-dark mb-2">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           id="stock_quantity"
                           name="stock_quantity"
                           value="{{ old('stock_quantity', 0) }}"
                           min="0"
                           required
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink"
                           placeholder="0">
                    @error('stock_quantity')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-semibold text-flora-dark mb-2">
                    Bouquet Image (Optional)
                </label>
                <input type="file"
                       id="image"
                       name="image"
                       accept=".jpg,.jpeg,.png,.webp"
                       class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm">
                <p class="text-xs text-gray-400 mt-1.5">
                    Allowed formats: JPG, JPEG, PNG, WebP. Maximum size: 2 MB.
                </p>
                @error('image')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Featured Checkbox -->
            <div class="flex items-start gap-3">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox"
                       id="is_featured"
                       name="is_featured"
                       value="1"
                       {{ old('is_featured') ? 'checked' : '' }}
                       class="mt-1 rounded border-gray-300 accent-flora-rose">
                <div>
                    <label for="is_featured" class="text-sm font-semibold text-flora-dark cursor-pointer">
                        Mark as Featured Bouquet
                    </label>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Featured bouquets can be highlighted on showcase sections.
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-6 border-t border-gray-100">
                <x-button type="submit" variant="primary">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                    Save Bouquet
                </x-button>

                <x-button href="{{ route('admin.bouquets.index') }}" variant="secondary">
                    Cancel
                </x-button>
            </div>
        </form>
    </x-card>

@endsection
