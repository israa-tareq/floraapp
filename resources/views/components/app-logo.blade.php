@props([
    'size' => 'md',
    'alt' => 'Flora App Logo',
])

@php
$logoRelativePath = 'images/flora-logo.png';
$hasCustomLogo = file_exists(public_path($logoRelativePath));

$imageSizeClasses = match ($size) {
    'sm' => 'h-8 w-auto max-w-[120px]',
    'lg' => 'h-16 w-auto max-w-[220px]',
    default => 'h-10 w-auto max-w-[150px]',
};

$iconSizeClasses = match ($size) {
    'sm' => 'text-xl',
    'lg' => 'text-4xl',
    default => 'text-2xl',
};
@endphp

@if($hasCustomLogo)
    <img src="{{ asset($logoRelativePath) }}"
         alt="{{ $alt }}"
         {{ $attributes->merge(['class' => "flora-app-logo {$imageSizeClasses} select-none"]) }} />
@else
    <span role="img"
          aria-label="{{ $alt }}"
          {{ $attributes->merge(['class' => "inline-flex items-center justify-center text-[var(--flora-soldier-green)] {$iconSizeClasses}"]) }}>
        <i class="fa-solid fa-spa"></i>
    </span>
@endif
