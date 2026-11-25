@props([
    'icon' => 'fa-box-open',
    'title' => 'No items found',
    'description' => 'Get started by creating your first entry.',
])

<div class="p-12 text-center">
    <div class="w-16 h-16 rounded-2xl bg-flora-light text-flora-rose flex items-center justify-center text-2xl mx-auto mb-4 shadow-sm">
        <i class="fa-solid {{ $icon }}"></i>
    </div>
    <h3 class="text-base font-bold text-flora-dark">
        {{ $title }}
    </h3>
    <p class="text-sm text-gray-500 mt-1 max-w-sm mx-auto">
        {{ $description }}
    </p>
    @if(isset($action))
        <div class="mt-5">
            {{ $action }}
        </div>
    @endif
</div>
