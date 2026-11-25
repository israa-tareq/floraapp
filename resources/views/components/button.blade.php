@props([
    'variant' => 'primary',
    'type' => 'button',
    'href' => null,
])

@php
$baseClasses = 'inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-sm transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

$variants = [
    'primary' => 'bg-[var(--flora-accent-primary)] hover:bg-[var(--flora-accent-primary-hover)] text-[var(--flora-text-on-accent)] focus:ring-[var(--flora-accent-primary)] shadow-sm',
    'secondary' => 'bg-[var(--flora-bg-subtle)] hover:bg-[var(--flora-berry-good)] text-[var(--flora-soldier-green)] border border-[var(--flora-border-subtle)] focus:ring-[var(--flora-meadow-mauve)]',
    'danger' => 'bg-[var(--flora-status-danger-bg)] hover:bg-[var(--flora-accent-primary)] text-[var(--flora-status-danger-text)] hover:text-[var(--flora-text-on-accent)] border border-[var(--flora-status-danger-border)] focus:ring-[var(--flora-accent-primary)]',
    'outline' => 'bg-transparent border border-[var(--flora-border-strong)] hover:bg-[var(--flora-bg-subtle)] text-[var(--flora-soldier-green)] focus:ring-[var(--flora-meadow-mauve)]',
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
