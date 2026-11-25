@props([
    'variant' => 'primary',
    'type' => 'button',
    'href' => null,
])

@php
$baseClasses = 'inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-sm transition focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

$variants = [
    'primary' => 'bg-flora-pink hover:bg-flora-rose text-flora-dark focus:ring-flora-rose shadow-sm',
    'secondary' => 'bg-gray-100 hover:bg-gray-200 text-gray-700 focus:ring-gray-300',
    'danger' => 'bg-red-50 hover:bg-red-100 text-red-600 focus:ring-red-200 border border-red-100',
    'outline' => 'border border-gray-200 hover:bg-gray-50 text-flora-dark focus:ring-gray-200',
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
