@extends('layouts.admin')

@section('title', 'Edit Packaging')
@section('page-heading', 'Edit Packaging Option')
@section('page-subheading', 'Update the details and stock for ' . $packaging->name)

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.packaging.index') }}"
           class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-flora-dark transition">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Back to Packaging Options
        </a>

        <h1 class="text-2xl font-bold text-flora-dark mt-3 tracking-tight">
            Edit Packaging Option: {{ $packaging->name }}
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Update the information for this packaging option.
        </p>
    </div>

    <x-card class="p-6 sm:p-8 max-w-3xl">
        <form action="{{ route('admin.packaging.update', $packaging) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Type -->
            <div>
                <label for="type" class="block text-sm font-semibold text-flora-dark mb-2">
                    Packaging Type <span class="text-red-500">*</span>
                </label>
                <select id="type"
                        name="type"
                        required
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-flora-pink">
                    <option value="wrap" {{ old('type', $packaging->type) == 'wrap' ? 'selected' : '' }}>Wrapping Paper</option>
                    <option value="ribbon" {{ old('type', $packaging->type) == 'ribbon' ? 'selected' : '' }}>Ribbon</option>
                    <option value="box" {{ old('type', $packaging->type) == 'box' ? 'selected' : '' }}>Gift Box</option>
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
                       value="{{ old('name', $packaging->name) }}"
                       required
                       class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink">
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
                           value="{{ old('color', $packaging->color) }}"
                           required
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink">
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
                           value="{{ old('price', $packaging->price) }}"
                           min="0"
                           step="0.01"
                           required
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink">
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
                       value="{{ old('stock_quantity', $packaging->stock_quantity) }}"
                       min="0"
                       required
                       class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-flora-pink">
                @error('stock_quantity')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Image & Replacement -->
            <div>
                <label class="block text-sm font-semibold text-flora-dark mb-2">
                    Current Image
                </label>

                <div class="mb-4">
                    @if($packaging->image_path)
                        <img src="{{ asset('storage/' . $packaging->image_path) }}"
                             alt="{{ $packaging->name }}"
                             class="w-28 h-28 rounded-2xl object-cover shadow-sm border border-gray-100">
                    @else
                        <div class="w-28 h-28 rounded-2xl bg-flora-light text-flora-muted
                                    flex items-center justify-center text-3xl border border-gray-100">
                            <i class="fa-solid fa-box"></i>
                        </div>
                    @endif
                </div>

                <label for="image" class="block text-sm font-semibold text-flora-dark mb-2">
                    Choose Replacement Image (Optional)
                </label>
                <input type="file"
                       id="image"
                       name="image"
                       accept=".jpg,.jpeg,.png,.webp"
                       class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm">
                <p class="text-xs text-gray-400 mt-1.5">
                    Leave empty to keep current image. Maximum size: 2 MB.
                </p>
                @error('image')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 pt-6 border-t border-gray-100">
                <x-button type="submit" variant="primary">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                    Update Packaging Option
                </x-button>

                <x-button href="{{ route('admin.packaging.index') }}" variant="secondary">
                    Cancel
                </x-button>
            </div>
        </form>
    </x-card>

@endsection
