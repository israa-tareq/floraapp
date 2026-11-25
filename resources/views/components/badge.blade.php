@props([
    'variant' => 'neutral',
])

@php
$variants = [
    'success' => 'bg-green-50 text-green-700 border border-green-200/60',
    'danger' => 'bg-red-50 text-red-700 border border-red-200/60',
    'warning' => 'bg-amber-50 text-amber-700 border border-amber-200/60',
    'info' => 'bg-blue-50 text-blue-700 border border-blue-200/60',
    'flora' => 'bg-flora-light text-flora-dark border border-flora-pink/60',
    'neutral' => 'bg-gray-100 text-gray-600 border border-gray-200/60',
];

$classes = $variants[$variant] ?? $variants['neutral'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {$classes}"]) }}>
    {{ $slot }}
</span>
