@extends('layouts.admin')

@section('title', 'Packaging Options')
@section('page-heading', 'Packaging Options')
@section('page-subheading', 'Manage wrapping paper, ribbons, and gift boxes.')

@section('content')

    <!-- Page Header -->
    <x-page-header title="Packaging Options" description="Manage wrapping paper, ribbons, and gift boxes.">
        <x-slot:actions>
            <x-button href="{{ route('admin.packaging.create') }}" variant="primary">
                <i class="fa-solid fa-plus mr-1.5"></i>
                Add Packaging Option
            </x-button>
        </x-slot:actions>
    </x-page-header>

    <!-- Packaging Options Card -->
    <x-card>
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-flora-dark">
                    All Packaging Options
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">
                    {{ $packagingOptions->total() }} option(s) in catalog.
                </p>
            </div>
        </div>

        @if($packagingOptions->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Item
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Color
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Stock
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach($packagingOptions as $packaging)
                            <tr class="hover:bg-gray-50/80 transition">
                                <!-- Item Info -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($packaging->image_path)
                                            <img src="{{ asset('storage/' . $packaging->image_path) }}"
                                                 alt="{{ $packaging->name }}"
                                                 class="w-14 h-14 rounded-xl object-cover shadow-sm">
                                        @else
                                            <div class="w-14 h-14 rounded-xl bg-flora-light text-flora-muted
                                                        flex items-center justify-center text-xl">
                                                <i class="fa-solid fa-box"></i>
                                            </div>
                                        @endif

                                        <span class="text-sm font-semibold text-flora-dark">
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
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $packaging->color }}
                                </td>

                                <!-- Price -->
                                <td class="px-6 py-4 text-sm font-medium text-flora-dark">
                                    ${{ number_format($packaging->price, 2) }}
                                </td>

                                <!-- Stock -->
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold {{ $packaging->stock_quantity < 10 ? 'text-red-600' : 'text-gray-700' }}">
                                        {{ $packaging->stock_quantity }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.packaging.edit', $packaging) }}"
                                           class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition">
                                            <i class="fa-solid fa-pen-to-square mr-1"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.packaging.destroy', $packaging) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this packaging option?');">
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
            @if($packagingOptions->hasPages())
                <div class="p-6 border-t border-gray-100 bg-gray-50/40">
                    {{ $packagingOptions->links() }}
                </div>
            @endif
        @else
            <x-empty-state
                icon="fa-box-open"
                title="No packaging options yet"
                description="Add your first packaging option (wrapping paper, ribbons, or gift boxes).">
                <x-slot:action>
                    <x-button href="{{ route('admin.packaging.create') }}" variant="primary">
                        <i class="fa-solid fa-plus mr-1.5"></i>
                        Add First Option
                    </x-button>
                </x-slot:action>
            </x-empty-state>
        @endif
    </x-card>

@endsection
