@extends('layouts.admin')

@section('title', 'Add Packaging')
@section('page-heading', 'Add Packaging Option')
@section('page-subheading', 'Create a new wrapping paper, ribbon, or gift box option.')

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.packaging.index') }}"
           class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-flora-dark transition">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Back to Packaging Options
        </a>

        <h1 class="text-2xl font-bold text-flora-dark mt-3 tracking-tight">
            Add Packaging Option
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Enter the details of the new packaging option below.
        </p>
    </div>

    <x-card class="p-6 sm:p-8 max-w-3xl">
        <form action="{{ route('admin.packaging.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            <!-- Type -->
            <div>
                <label for="type" class="block text-sm font-semibold text-flora-dark mb-2">
                    Packaging Type <span class="text-red-500">*</span>
                </label>
                <select id="type"
                        name="type"
                        required
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-flora-pink">
                    <option value="">Select a packaging type</option>
                    <option value="wrap" {{ old('type') == 'wrap' ? 'selected' : '' }}>Wrapping Paper</option>
                    <option value="ribbon" {{ old('type') == 'ribbon' ? 'selected' : '' }}>Ribbon</option>
                    <option value="box" {{ old('type') == 'box' ? 'selected' : '' }}>Gift Box</option>
                </select>
                @error('type')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Item Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-flora-dark mb-2">
                    Item Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink"
                       placeholder="e.g. Pink Floral Wrapping Sheet">
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Color and Price -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="color" class="block text-sm font-semibold text-flora-dark mb-2">
                        Color <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="color"
                           name="color"
                           value="{{ old('color') }}"
                           required
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink"
                           placeholder="e.g. Dusty Rose">
                    @error('color')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

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
            </div>

            <!-- Stock Quantity -->
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

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-semibold text-flora-dark mb-2">
                    Packaging Image (Optional)
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

            <!-- Buttons -->
            <div class="flex items-center gap-3 pt-6 border-t border-gray-100">
                <x-button type="submit" variant="primary">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                    Save Packaging Option
                </x-button>

                <x-button href="{{ route('admin.packaging.index') }}" variant="secondary">
                    Cancel
                </x-button>
            </div>
        </form>
    </x-card>

@endsection
