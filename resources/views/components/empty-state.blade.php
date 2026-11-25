@props([
    'icon' => 'fa-box-open',
    'title' => 'No items found',
    'description' => null,
])

<div class="p-12 text-center">
    <div class="w-14 h-14 rounded-2xl bg-[var(--flora-bg-highlight)] text-[var(--flora-usukoubai)] border border-[var(--flora-border-subtle)] flex items-center justify-center text-xl mx-auto mb-4">
        <i class="fa-solid {{ $icon }}"></i>
    </div>
    <h3 class="text-base font-semibold text-[var(--flora-soldier-green)]">
        {{ $title }}
    </h3>
    @if($description)
        <p class="text-sm text-[var(--flora-text-muted)] mt-1 max-w-sm mx-auto">
            {{ $description }}
        </p>
    @endif
    @if(isset($action))
        <div class="mt-5">
            {{ $action }}
        </div>
    @endif
</div>
