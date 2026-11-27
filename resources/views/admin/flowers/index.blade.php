@extends('layouts.admin')

@section('title', 'Flowers')
@section('page-heading', 'Flowers')

@section('content')

    <!-- Flowers Table Card -->
    <x-card>
        <div class="px-6 py-4 border-b border-[var(--flora-border-subtle)] flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <h2 class="text-base font-bold text-[var(--flora-soldier-green)]">
                    Inventory
                </h2>
                <span class="text-xs font-semibold text-[var(--flora-text-muted)]">
                    {{ $flowers->total() }} {{ \Illuminate\Support\Str::plural('item', $flowers->total()) }}
                </span>
            </div>

            <x-button href="{{ route('admin.flowers.create') }}" variant="primary">
                <i class="fa-solid fa-plus"></i>
                <span>Add Flower</span>
            </x-button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="flora-table-head">
                    <tr>
                        <th class="px-6 py-3.5">Image</th>
                        <th class="px-6 py-3.5">Flower Name</th>
                        <th class="px-6 py-3.5">Color</th>
                        <th class="px-6 py-3.5">Price / Stem</th>
                        <th class="px-6 py-3.5">Stock</th>
                        <th class="px-6 py-3.5">Availability</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="flora-table-body">
                    @forelse($flowers as $flower)
                        <tr>
                            <!-- Image -->
                            <td class="px-6 py-4">
                                @if($flower->image_path)
                                    <img src="{{ asset('storage/' . $flower->image_path) }}"
                                         alt="{{ $flower->name }}"
                                         class="w-14 h-14 rounded-xl object-cover border border-[var(--flora-border-subtle)]">
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-[var(--flora-bg-subtle)] text-[var(--flora-text-muted)]
                                                flex items-center justify-center text-lg border border-[var(--flora-border-subtle)]">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </td>

                            <!-- Name -->
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-[var(--flora-soldier-green)]">
                                    {{ $flower->name }}
                                </p>
                            </td>

                            <!-- Color -->
                            <td class="px-6 py-4">
                                <span class="text-sm text-[var(--flora-text-body)]">
                                    {{ $flower->color }}
                                </span>
                            </td>

                            <!-- Price -->
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-[var(--flora-soldier-green)]">
                                    ${{ number_format((float) $flower->price_per_stem, 2) }}
                                </span>
                            </td>

                            <!-- Stock -->
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold {{ $flower->stock_quantity < 10 ? 'text-[var(--flora-status-danger-text)]' : 'text-[var(--flora-soldier-green)]' }}">
                                    {{ $flower->stock_quantity }}
                                </span>
                            </td>

                            <!-- Availability -->
                            <td class="px-6 py-4">
                                @if($flower->is_available)
                                    <x-badge variant="success">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <span>Available</span>
                                    </x-badge>
                                @else
                                    <x-badge variant="neutral">
                                        <i class="fa-solid fa-circle-minus"></i>
                                        <span>Unavailable</span>
                                    </x-badge>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-4">
                                    <a href="{{ route('admin.flowers.edit', $flower) }}"
                                       class="inline-flex items-center gap-1.5 text-sm font-semibold text-[var(--flora-soldier-green)] hover:text-[var(--flora-usukoubai)] transition">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('admin.flowers.destroy', $flower) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this flower?');">
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
                    @empty
                        <tr>
                            <td colspan="7">
                                <x-empty-state
                                    icon="fa-seedling"
                                    title="No flowers found">
                                    <x-slot:action>
                                        <x-button href="{{ route('admin.flowers.create') }}" variant="primary">
                                            <i class="fa-solid fa-plus"></i>
                                            <span>Add Flower</span>
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
            <div class="p-5 border-t border-[var(--flora-border-subtle)] bg-[var(--flora-bg-surface)]">
                {{ $flowers->links() }}
            </div>
        @endif
    </x-card>

@endsection
