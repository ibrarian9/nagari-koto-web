<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ($title ?? 'Login') . ' — ' . config('app.name') }}</title>
    @include('partials.favicon')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap">
    @include('partials.font-loader')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans text-gray-900 antialiased">
    @php $village = App\Models\VillageProfile::first(); @endphp
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-desa-500 via-desa-600 to-desa-800">
        <div class="mb-6 text-center">
            <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-3 group">
                @if($village?->logo)
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm shadow-lg transition-transform group-hover:scale-105 p-1.5">
                        <img src="{{ Storage::url($village->logo) }}" alt="Logo" class="h-full w-full object-contain">
                    </div>
                @else
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm shadow-lg transition-transform group-hover:scale-105">
                        <span class="material-symbols-outlined text-white text-3xl">location_city</span>
                    </div>
                @endif
            </a>
            <h1 class="mt-3 text-xl font-bold text-white">{{ $village?->name ?? config('app.name') }}</h1>
            <p class="text-sm text-desa-200">{{ $village?->tagline ?? 'Desa Digital' }}</p>
        </div>
        <div class="w-full sm:max-w-md px-6 py-6 bg-white/95 backdrop-blur-sm shadow-2xl overflow-hidden rounded-2xl">
            {{ $slot }}
        </div>
    </div>
    @livewireScripts
</body>
</html>
