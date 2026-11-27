@extends('layouts.admin')

@section('title', 'Pre-Made Bouquets')
@section('page-heading', 'Pre-Made Bouquets')

@section('content')

    <!-- Bouquets Table Card -->
    <x-card>
        <div class="px-6 py-4 border-b border-[var(--flora-border-subtle)] flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <h2 class="text-base font-bold text-[var(--flora-soldier-green)]">
                    Inventory
                </h2>
                <span class="text-xs font-semibold text-[var(--flora-text-muted)]">
                    {{ $bouquets->total() }} {{ \Illuminate\Support\Str::plural('item', $bouquets->total()) }}
                </span>
            </div>

            <x-button href="{{ route('admin.bouquets.create') }}" variant="primary">
                <i class="fa-solid fa-plus"></i>
                <span>Add Bouquet</span>
            </x-button>
        </div>

        @if($bouquets->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="flora-table-head">
                        <tr>
                            <th class="px-6 py-3.5">Bouquet</th>
                            <th class="px-6 py-3.5">Price</th>
                            <th class="px-6 py-3.5">Stock</th>
                            <th class="px-6 py-3.5">Featured</th>
                            <th class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="flora-table-body">
                        @foreach($bouquets as $bouquet)
                            <tr>
                                <!-- Bouquet Info -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($bouquet->image_path)
                                            <img src="{{ asset('storage/' . $bouquet->image_path) }}"
                                                 alt="{{ $bouquet->name }}"
                                                 class="w-14 h-14 rounded-xl object-cover border border-[var(--flora-border-subtle)] shrink-0">
                                        @else
                                            <div class="w-14 h-14 rounded-xl bg-[var(--flora-bg-subtle)] text-[var(--flora-text-muted)]
                                                        flex items-center justify-center text-lg border border-[var(--flora-border-subtle)] shrink-0">
                                                <i class="fa-solid fa-image"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <p class="text-sm font-semibold text-[var(--flora-soldier-green)]">
                                                {{ $bouquet->name }}
                                            </p>
                                            @if($bouquet->description)
                                                <p class="text-xs text-[var(--flora-text-muted)] mt-0.5">
                                                    {{ \Illuminate\Support\Str::limit($bouquet->description, 55) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Price -->
                                <td class="px-6 py-4 text-sm font-semibold text-[var(--flora-soldier-green)]">
                                    ${{ number_format($bouquet->price, 2) }}
                                </td>

                                <!-- Stock -->
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold {{ $bouquet->stock_quantity < 10 ? 'text-[var(--flora-status-danger-text)]' : 'text-[var(--flora-soldier-green)]' }}">
                                        {{ $bouquet->stock_quantity }}
                                    </span>
                                </td>

                                <!-- Featured Status -->
                                <td class="px-6 py-4">
                                    @if($bouquet->is_featured)
                                        <x-badge variant="flora">
                                            <i class="fa-solid fa-star"></i>
                                            <span>Featured</span>
                                        </x-badge>
                                    @else
                                        <x-badge variant="neutral">
                                            <span>Standard</span>
                                        </x-badge>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('admin.bouquets.edit', $bouquet) }}"
                                           class="inline-flex items-center gap-1.5 text-sm font-semibold text-[var(--flora-soldier-green)] hover:text-[var(--flora-usukoubai)] transition">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Edit</span>
                                        </a>

                                        <form action="{{ route('admin.bouquets.destroy', $bouquet) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this bouquet?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-[var(--flora-status-danger-text)] hover:text-[var(--flora-usukoubai)] transition">
                                                <i class="fa-solid fa-trash-can"></i>
                                                <span>Delete</span>
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
                <div class="p-5 border-t border-[var(--flora-border-subtle)] bg-[var(--flora-bg-surface)]">
                    {{ $bouquets->links() }}
                </div>
            @endif
        @else
            <x-empty-state
                icon="fa-wand-magic-sparkles"
                title="No bouquets found">
                <x-slot:action>
                    <x-button href="{{ route('admin.bouquets.create') }}" variant="primary">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Bouquet</span>
                    </x-button>
                </x-slot:action>
            </x-empty-state>
        @endif
    </x-card>

@endsection
