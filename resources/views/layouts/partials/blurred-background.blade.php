@php
    $bgCandidates = [
        'images/login-bg.jpg',
        'images/login-bg.jpeg',
        'images/login-bg.png',
        'images/login-bg.webp',
    ];
    $bgPath = collect($bgCandidates)->first(fn (string $path) => file_exists(public_path($path)));
    $isMain = ($scope ?? 'auth') === 'main';
@endphp

@if($isMain)
    <div class="flora-main-bg-wrapper" aria-hidden="true">
        <div class="flora-main-bg-sticky">
            @if($bgPath)
                <div class="flora-main-bg-image"
                     style="background-image: url('{{ asset($bgPath) }}');"></div>
            @else
                <div class="flora-login-bg-placeholder"></div>
            @endif
            <div class="flora-main-bg-overlay"></div>
        </div>
    </div>
@else
    <div class="flora-login-bg-wrapper" aria-hidden="true">
        @if($bgPath)
            <div class="flora-login-bg-image"
                 style="background-image: url('{{ asset($bgPath) }}');"></div>
        @else
            <div class="flora-login-bg-placeholder"></div>
        @endif
        <div class="flora-login-bg-overlay"></div>
    </div>
@endif
