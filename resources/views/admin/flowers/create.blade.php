@extends('layouts.admin')

@section('title', 'Add Flower')
@section('page-heading', 'Add New Flower')
@section('page-subheading', 'Enter the details of the new flower below.')

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.flowers.index') }}"
           class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-flora-dark transition">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Back to Flowers
        </a>

        <h1 class="text-2xl font-bold text-flora-dark mt-3 tracking-tight">
            Add New Flower
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Enter the details of the new flower below.
        </p>
    </div>

    <x-card class="p-6 md:p-8 max-w-3xl">
        <form action="{{ route('admin.flowers.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Flower Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold mb-2 text-flora-dark">
                        Flower Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="Example: Red Rose"
                           required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-semibold mb-2 text-flora-dark">
                        Color <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="color"
                           name="color"
                           value="{{ old('color') }}"
                           placeholder="Example: Red"
                           required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink">
                    @error('color')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price_per_stem" class="block text-sm font-semibold mb-2 text-flora-dark">
                        Price Per Stem <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           id="price_per_stem"
                           name="price_per_stem"
                           value="{{ old('price_per_stem') }}"
                           placeholder="0.00"
                           min="0"
                           step="0.01"
                           required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink">
                    @error('price_per_stem')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock_quantity" class="block text-sm font-semibold mb-2 text-flora-dark">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           id="stock_quantity"
                           name="stock_quantity"
                           value="{{ old('stock_quantity') }}"
                           placeholder="Enter quantity"
                           min="0"
                           step="1"
                           required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink">
                    @error('stock_quantity')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-semibold mb-2 text-flora-dark">
                        Flower Image
                    </label>
                    <input type="file"
                           id="image"
                           name="image"
                           accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm">
                    <p class="text-xs text-gray-400 mt-1.5">
                        Accepted formats: JPG, JPEG, PNG, WebP. Maximum size: 2 MB.
                    </p>
                    @error('image')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Availability -->
                <div class="md:col-span-2">
                    <input type="hidden" name="is_available" value="0">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox"
                               name="is_available"
                               value="1"
                               {{ old('is_available', '1') == '1' ? 'checked' : '' }}
                               class="w-4 h-4 accent-flora-rose rounded">
                        <span class="text-sm font-medium text-gray-700">
                            Flower is available for purchase
                        </span>
                    </label>
                </div>

            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <x-button type="submit" variant="primary">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                    Save Flower
                </x-button>

                <x-button href="{{ route('admin.flowers.index') }}" variant="secondary">
                    Cancel
                </x-button>
            </div>
        </form>
    </x-card>

@endsection
