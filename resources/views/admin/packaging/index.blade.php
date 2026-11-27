@extends('layouts.admin')

@section('title', 'Packaging Options')
@section('page-heading', 'Packaging Options')

@section('content')

    <!-- Packaging Options Card -->
    <x-card>
        <div class="px-6 py-4 border-b border-[var(--flora-border-subtle)] flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <h2 class="text-base font-bold text-[var(--flora-soldier-green)]">
                    Inventory
                </h2>
                <span class="text-xs font-semibold text-[var(--flora-text-muted)]">
                    {{ $packagingOptions->total() }} {{ \Illuminate\Support\Str::plural('item', $packagingOptions->total()) }}
                </span>
            </div>

            <x-button href="{{ route('admin.packaging.create') }}" variant="primary">
                <i class="fa-solid fa-plus"></i>
                <span>Add Packaging Option</span>
            </x-button>
        </div>

        @if($packagingOptions->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="flora-table-head">
                        <tr>
                            <th class="px-6 py-3.5">Item</th>
                            <th class="px-6 py-3.5">Type</th>
                            <th class="px-6 py-3.5">Color</th>
                            <th class="px-6 py-3.5">Price</th>
                            <th class="px-6 py-3.5">Stock</th>
                            <th class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="flora-table-body">
                        @foreach($packagingOptions as $packaging)
                            <tr>
                                <!-- Item Info -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($packaging->image_path)
                                            <img src="{{ asset('storage/' . $packaging->image_path) }}"
                                                 alt="{{ $packaging->name }}"
                                                 class="w-14 h-14 rounded-xl object-cover border border-[var(--flora-border-subtle)] shrink-0">
                                        @else
                                            <div class="w-14 h-14 rounded-xl bg-[var(--flora-bg-subtle)] text-[var(--flora-text-muted)]
                                                        flex items-center justify-center text-lg border border-[var(--flora-border-subtle)] shrink-0">
                                                <i class="fa-solid fa-box"></i>
                                            </div>
                                        @endif

                                        <span class="text-sm font-semibold text-[var(--flora-soldier-green)]">
                                            {{ $packaging->name }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Type -->
                                <td class="px-6 py-4">
                                    <x-badge variant="neutral" class="capitalize">
                                        {{ $packaging->type }}
                                    </x-badge>
                                </td>

                                <!-- Color -->
                                <td class="px-6 py-4 text-sm text-[var(--flora-text-body)]">
                                    {{ $packaging->color }}
                                </td>

                                <!-- Price -->
                                <td class="px-6 py-4 text-sm font-semibold text-[var(--flora-soldier-green)]">
                                    ${{ number_format($packaging->price, 2) }}
                                </td>

                                <!-- Stock -->
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold {{ $packaging->stock_quantity < 10 ? 'text-[var(--flora-status-danger-text)]' : 'text-[var(--flora-soldier-green)]' }}">
                                        {{ $packaging->stock_quantity }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('admin.packaging.edit', $packaging) }}"
                                           class="inline-flex items-center gap-1.5 text-sm font-semibold text-[var(--flora-soldier-green)] hover:text-[var(--flora-usukoubai)] transition">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Edit</span>
                                        </a>

                                        <form action="{{ route('admin.packaging.destroy', $packaging) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this packaging option?');">
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
            @if($packagingOptions->hasPages())
                <div class="p-5 border-t border-[var(--flora-border-subtle)] bg-[var(--flora-bg-surface)]">
                    {{ $packagingOptions->links() }}
                </div>
            @endif
        @else
            <x-empty-state
                icon="fa-box-open"
                title="No packaging options found">
                <x-slot:action>
                    <x-button href="{{ route('admin.packaging.create') }}" variant="primary">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Packaging Option</span>
                    </x-button>
                </x-slot:action>
            </x-empty-state>
        @endif
    </x-card>

@endsection
