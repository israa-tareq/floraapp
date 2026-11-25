@extends('layouts.admin')

@section('title', 'Manage Flowers')
@section('page-heading', 'Flower Inventory')
@section('page-subheading', 'Manage your individual flower stems, colors, prices, and stock.')

@section('content')

    <!-- Page Header -->
    <x-page-header title="Flowers" description="Manage your individual flower inventory.">
        <x-slot:actions>
            <x-button href="{{ route('admin.flowers.create') }}" variant="primary">
                <i class="fa-solid fa-plus mr-1.5"></i>
                Add New Flower
            </x-button>
        </x-slot:actions>
    </x-page-header>

    <!-- Flowers Table Card -->
    <x-card>
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-flora-dark">
                    All Flowers
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">
                    {{ $flowers->total() }} flower varieties in your inventory.
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Image
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Flower Name
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Color
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Price / Stem
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Stock
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Availability
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($flowers as $flower)
                        <tr class="hover:bg-gray-50/80 transition">
                            <!-- Image -->
                            <td class="px-6 py-4">
                                @if($flower->image_path)
                                    <img src="{{ asset('storage/' . $flower->image_path) }}"
                                         alt="{{ $flower->name }}"
                                         class="w-14 h-14 rounded-xl object-cover shadow-sm">
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-flora-light text-flora-muted
                                                flex items-center justify-center text-xl">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </td>

                            <!-- Name -->
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-flora-dark">
                                    {{ $flower->name }}
                                </p>
                            </td>

                            <!-- Color -->
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">
                                    {{ $flower->color }}
                                </span>
                            </td>

                            <!-- Price -->
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-flora-dark">
                                    ${{ number_format((float) $flower->price_per_stem, 2) }}
                                </span>
                            </td>

                            <!-- Stock -->
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold {{ $flower->stock_quantity < 10 ? 'text-red-600' : 'text-gray-700' }}">
                                    {{ $flower->stock_quantity }}
                                </span>
                            </td>

                            <!-- Availability -->
                            <td class="px-6 py-4">
                                @if($flower->is_available)
                                    <x-badge variant="success">
                                        Available
                                    </x-badge>
                                @else
                                    <x-badge variant="neutral">
                                        Unavailable
                                    </x-badge>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.flowers.edit', $flower) }}"
                                       class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i>
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.flowers.destroy', $flower) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this flower?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="inline-flex items-center text-sm font-semibold text-red-600 hover:text-red-800 transition">
                                            <i class="fa-solid fa-trash-can mr-1"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <x-empty-state
                                    icon="fa-seedling"
                                    title="No flowers found"
                                    description="Start by adding your first flower variety to the inventory.">
                                    <x-slot:action>
                                        <x-button href="{{ route('admin.flowers.create') }}" variant="primary">
                                            <i class="fa-solid fa-plus mr-1.5"></i>
                                            Add First Flower
                                        </x-button>
                                    </x-slot:action>
                                </x-empty-state>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($flowers->hasPages())
            <div class="p-6 border-t border-gray-100 bg-gray-50/40">
                {{ $flowers->links() }}
            </div>
        @endif
    </x-card>

@endsection
