@extends('layouts.admin')

@section('title', 'Pre-Made Bouquets')
@section('page-heading', 'Pre-Made Bouquets')
@section('page-subheading', 'Manage your arranged, ready-made flower bouquets and packages.')

@section('content')

    <!-- Page Header -->
    <x-page-header title="Pre-Made Bouquets" description="Manage your ready-made flower arrangements.">
        <x-slot:actions>
            <x-button href="{{ route('admin.bouquets.create') }}" variant="primary">
                <i class="fa-solid fa-plus mr-1.5"></i>
                Add New Bouquet
            </x-button>
        </x-slot:actions>
    </x-page-header>

    <!-- Bouquets Table Card -->
    <x-card>
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-flora-dark">
                    All Bouquets
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">
                    {{ $bouquets->total() }} bouquet(s) in your catalog.
                </p>
            </div>
        </div>

        @if($bouquets->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Bouquet
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Stock
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Featured
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach($bouquets as $bouquet)
                            <tr class="hover:bg-gray-50/80 transition">
                                <!-- Bouquet Info -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($bouquet->image_path)
                                            <img src="{{ asset('storage/' . $bouquet->image_path) }}"
                                                 alt="{{ $bouquet->name }}"
                                                 class="w-14 h-14 rounded-xl object-cover shadow-sm">
                                        @else
                                            <div class="w-14 h-14 rounded-xl bg-flora-light text-flora-muted
                                                        flex items-center justify-center text-xl">
                                                <i class="fa-solid fa-image"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <p class="text-sm font-semibold text-flora-dark">
                                                {{ $bouquet->name }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                {{ \Illuminate\Support\Str::limit($bouquet->description ?? 'No description provided', 55) }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Price -->
                                <td class="px-6 py-4 text-sm font-medium text-flora-dark">
                                    ${{ number_format($bouquet->price, 2) }}
                                </td>

                                <!-- Stock -->
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold {{ $bouquet->stock_quantity < 10 ? 'text-red-600' : 'text-gray-700' }}">
                                        {{ $bouquet->stock_quantity }}
                                    </span>
                                </td>

                                <!-- Featured Status -->
                                <td class="px-6 py-4">
                                    @if($bouquet->is_featured)
                                        <x-badge variant="flora">
                                            <i class="fa-solid fa-star text-amber-500 mr-1"></i>
                                            Featured
                                        </x-badge>
                                    @else
                                        <span class="text-xs text-gray-400">Regular</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.bouquets.edit', $bouquet) }}"
                                           class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition">
                                            <i class="fa-solid fa-pen-to-square mr-1"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.bouquets.destroy', $bouquet) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this bouquet?');">
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
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($bouquets->hasPages())
                <div class="p-6 border-t border-gray-100 bg-gray-50/40">
                    {{ $bouquets->links() }}
                </div>
            @endif
        @else
            <x-empty-state
                icon="fa-wand-magic-sparkles"
                title="No bouquets yet"
                description="Add your first pre-made flower bouquet to display in your store.">
                <x-slot:action>
                    <x-button href="{{ route('admin.bouquets.create') }}" variant="primary">
                        <i class="fa-solid fa-plus mr-1.5"></i>
                        Add First Bouquet
                    </x-button>
                </x-slot:action>
            </x-empty-state>
        @endif
    </x-card>

@endsection
