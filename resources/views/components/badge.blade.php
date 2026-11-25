@props([
    'variant' => 'neutral',
])

@php
$variants = [
    'success' => 'bg-[var(--flora-status-success-bg)] text-[var(--flora-status-success-text)] border border-[var(--flora-status-success-border)]',
    'danger' => 'bg-[var(--flora-status-danger-bg)] text-[var(--flora-status-danger-text)] border border-[var(--flora-status-danger-border)]',
    'warning' => 'bg-[var(--flora-status-warning-bg)] text-[var(--flora-status-warning-text)] border border-[var(--flora-status-warning-border)]',
    'info' => 'bg-[var(--flora-bg-subtle)] text-[var(--flora-soldier-green)] border border-[var(--flora-border-subtle)]',
    'flora' => 'bg-[var(--flora-berry-good)]/65 text-[var(--flora-soldier-green)] border border-[var(--flora-usukoubai)]/40',
    'neutral' => 'bg-[var(--flora-bg-subtle)] text-[var(--flora-text-muted)] border border-[var(--flora-border-subtle)]',
];

$classes = $variants[$variant] ?? $variants['neutral'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {$classes}"]) }}>
    {{ $slot }}
</span>
