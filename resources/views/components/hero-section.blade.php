@props([
    'slug' => '',
    'gradient' => 'from-desa-600 to-desa-800',
    'overlayClass' => 'from-black/70 via-black/60 to-black/70',
    'class' => 'py-16 md:py-20',
])

@php
    $heroImageUrl = \App\Models\HeroSetting::getImageUrl($slug);
@endphp

<section class="relative bg-gradient-to-br {{ $gradient }} overflow-hidden {{ $class }}">
    @if($heroImageUrl)
        <img src="{{ $heroImageUrl }}" alt="" class="absolute inset-0 w-full h-full object-cover" loading="eager" decoding="async">
        <div class="absolute inset-0 bg-gradient-to-br {{ $overlayClass }}"></div>
    @else
        {{ $decorations ?? '' }}
    @endif
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </div>
</section>
