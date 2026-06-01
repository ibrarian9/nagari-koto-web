<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="{{ $metaDescription ?? 'Website Profil Desa Digital — Informasi lengkap tentang desa, pemerintahan, berita, dan layanan publik.' }}">

    <title>{{ ($title ?? 'Beranda') . ' — ' . config('app.name') }}</title>
    @include('partials.favicon')

    {{-- Preconnect: prioritas tinggi untuk domain font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    {{-- LCP image preload (diisi per-halaman) --}}
    @stack('preload')

    {{-- Critical CSS first --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Fonts: async load, non-blocking --}}
    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    </noscript>


    {{-- Material Symbols: self-hosted via app.css —  no CDN needed --}}

    {{-- AOS CSS: async load --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" media="print"
        onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    </noscript>

    {{-- JS Libraries: all deferred, non-blocking --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
</head>

<body class="min-h-screen flex flex-col bg-gray-50">

    {{-- ─── NAVBAR ─────────────────────────────────────────── --}}
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-200/60 shadow-sm"
        x-data="{ open: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">

                {{-- Logo / Brand --}}
                @php $navVillage = \App\Models\VillageProfile::first(); @endphp
                <a href="{{ route('home') }}" class="flex items-center gap-3 group" wire:navigate>
                    @if ($navVillage?->logo)
                        <img src="{{ Storage::url($navVillage->logo) }}" alt="{{ config('app.name') }}"
                            class="h-10 w-10 rounded-xl object-contain bg-white p-0.5 shadow-md shadow-desa-500/20 transition-transform group-hover:scale-105">
                    @else
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-desa-500 to-desa-700 shadow-md shadow-desa-500/20 transition-transform group-hover:scale-105">
                            <span class="material-symbols-outlined text-white text-xl">location_city</span>
                        </div>
                    @endif
                    <div class="hidden sm:block">
                        <p class="text-sm font-bold text-gray-900 leading-tight">{{ config('app.name') }}</p>
                        <p class="text-xs text-gray-500">Official</p>
                    </div>
                </a>

                {{-- Desktop Nav Links with Dropdowns --}}
                @php
                    $navGroups = [
                        [
                            'type' => 'link',
                            'route' => 'home',
                            'label' => 'Beranda',
                            'icon' => 'home',
                        ],
                        [
                            'type' => 'dropdown',
                            'label' => 'Profil',
                            'icon' => 'info',
                            'activeRoutes' => ['profil-desa', 'pemerintahan'],
                            'items' => [
                                [
                                    'route' => 'profil-desa',
                                    'label' => 'Profil Desa',
                                    'icon' => 'location_city',
                                    'desc' => 'Sejarah, visi & misi',
                                ],
                                [
                                    'route' => 'pemerintahan',
                                    'label' => 'Pemerintahan',
                                    'icon' => 'groups',
                                    'desc' => 'Struktur organisasi',
                                ],
                            ],
                        ],
                        [
                            'type' => 'dropdown',
                            'label' => 'Lembaga Nagari',
                            'icon' => 'info',
                            'activeRoutes' => ['bamus', 'lembaga', 'bumnag.home', 'bumnag.struktur', 'bumnag.hukum', 'bumnag.anggaran', 'bumnag.program-kerja'],
                            'items' => [
                                [
                                    'route' => 'bamus',
                                    'label' => 'Badan Musyawarah',
                                    'icon' => 'gavel',
                                    'desc' => 'Susunan keanggotaan Bamus',
                                ],
                                [
                                    'route' => 'lembaga',
                                    'label' => 'Daftar Lembaga Nagari',
                                    'icon' => 'domain',
                                    'desc' => 'Lembaga nagari Duo Koto',
                                ],
                                [
                                    'route' => 'bumnag.home',
                                    'label' => 'BUMNag',
                                    'icon' => 'store',
                                    'desc' => 'Badan Usaha Milik Nagari',
                                ],
                            ],
                        ],
                        [
                            'type' => 'dropdown',
                            'label' => 'Informasi',
                            'icon' => 'info',
                            'activeRoutes' => ['berita.index', 'berita.show', 'agenda', 'kontak'],
                            'items' => [
                                [
                                    'route' => 'berita.index',
                                    'label' => 'Berita',
                                    'icon' => 'newspaper',
                                    'desc' => 'Berita & pengumuman',
                                ],
                                [
                                    'route' => 'agenda',
                                    'label' => 'Agenda',
                                    'icon' => 'event',
                                    'desc' => 'Jadwal kegiatan',
                                ],
                                [
                                    'route' => 'kontak',
                                    'label' => 'Kontak',
                                    'icon' => 'call',
                                    'desc' => 'Nomor penting desa',
                                ],
                            ],
                        ],
                        [
                            'type' => 'dropdown',
                            'label' => 'Potensi',
                            'icon' => 'eco',
                            'activeRoutes' => ['potensi', 'umkm'],
                            'items' => [
                                [
                                    'route' => 'potensi',
                                    'label' => 'Potensi Desa',
                                    'icon' => 'eco',
                                    'desc' => 'Kekayaan & unggulan',
                                ],
                                [
                                    'route' => 'umkm',
                                    'label' => 'UMKM',
                                    'icon' => 'storefront',
                                    'desc' => 'Direktori usaha lokal',
                                ],
                            ],
                        ],
                        [
                            'type' => 'dropdown',
                            'label' => 'Data',
                            'icon' => 'bar_chart',
                            'activeRoutes' => ['infografis', 'idm', 'anggaran', 'kehutanan'],
                            'items' => [
                                [
                                    'route' => 'infografis',
                                    'label' => 'Infografis',
                                    'icon' => 'bar_chart',
                                    'desc' => 'Data kependudukan',
                                ],
                                [
                                    'route' => 'idm',
                                    'label' => 'IDM',
                                    'icon' => 'insights',
                                    'desc' => 'Indeks Desa Membangun',
                                ],
                                [
                                    'route' => 'anggaran',
                                    'label' => 'Anggaran',
                                    'icon' => 'account_balance',
                                    'desc' => 'APBDes & transparansi',
                                ],
                                [
                                    'route' => 'kehutanan',
                                    'label' => 'Kehutanan',
                                    'icon' => 'forest',
                                    'desc' => 'Data kawasan hutan desa',
                                ],
                            ],
                        ],
                        [
                            'type' => 'dropdown',
                            'label' => 'Layanan',
                            'icon' => 'handshake',
                            'activeRoutes' => ['surat.info', 'donasi', 'donasi.detail', 'bansos'],
                            'items' => [
                                [
                                    'route' => 'surat.info',
                                    'label' => 'Layanan Surat',
                                    'icon' => 'mail',
                                    'desc' => 'Permohonan surat online',
                                ],
                                [
                                    'route' => 'bansos',
                                    'label' => 'Cek Bansos',
                                    'icon' => 'volunteer_activism',
                                    'desc' => 'Link cek bantuan sosial',
                                ],
                                [
                                    'route' => 'donasi',
                                    'label' => 'Donasi',
                                    'icon' => 'favorite',
                                    'desc' => 'Crowdfunding program nagari',
                                ],
                            ],
                        ],
                        [
                            'type' => 'dropdown',
                            'label' => 'PPID',
                            'icon' => 'policy',
                            'activeRoutes' => ['ppid.home', 'ppid.berkala', 'ppid.setiap-saat', 'ppid.serta-merta', 'ppid.dikecualikan', 'ppid.permohonan', 'ppid.cek-status'],
                            'items' => [
                                [
                                    'route' => 'ppid.home',
                                    'label' => 'Informasi Publik',
                                    'icon' => 'policy',
                                    'desc' => 'PPID Nagari',
                                ],
                                [
                                    'route' => 'ppid.permohonan',
                                    'label' => 'Permohonan Informasi',
                                    'icon' => 'edit_note',
                                    'desc' => 'Ajukan permohonan',
                                ],
                                [
                                    'route' => 'ppid.cek-status',
                                    'label' => 'Cek Status',
                                    'icon' => 'search',
                                    'desc' => 'Lacak permohonan',
                                ],
                            ],
                        ],
                    ];
                @endphp
                <div class="hidden lg:flex items-center gap-0.5">
                    @foreach ($navGroups as $group)
                        @if ($group['type'] === 'link')
                            <a href="{{ route($group['route']) }}" wire:navigate
                                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs($group['route']) ? 'text-desa-600 bg-desa-50' : 'text-gray-600 hover:text-desa-600 hover:bg-gray-50' }}">
                                {{ $group['label'] }}
                            </a>
                        @else
                            <div class="relative" x-data="{ dd: false }" @mouseenter="dd = true"
                                @mouseleave="dd = false">
                                <button @click="dd = !dd"
                                    class="flex items-center gap-1 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs($group['activeRoutes']) ? 'text-desa-600 bg-desa-50' : 'text-gray-600 hover:text-desa-600 hover:bg-gray-50' }}">
                                    {{ $group['label'] }}
                                    <span class="material-symbols-outlined text-sm transition-transform duration-200"
                                        :class="dd ? 'rotate-180' : ''">expand_more</span>
                                </button>
                                <div x-show="dd" x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-1"
                                    class="absolute left-0 mt-1 w-60 rounded-xl bg-white shadow-xl ring-1 ring-gray-200/70 py-2 z-50">
                                    @foreach ($group['items'] as $item)
                                        <a href="{{ route($item['route']) }}" wire:navigate
                                            class="flex items-start gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors {{ request()->routeIs($item['route']) ? 'bg-desa-50' : '' }}">
                                            <span
                                                class="material-symbols-outlined text-lg mt-0.5 {{ request()->routeIs($item['route']) ? 'text-desa-600' : 'text-gray-400' }}">{{ $item['icon'] }}</span>
                                            <div>
                                                <p
                                                    class="text-sm font-medium {{ request()->routeIs($item['route']) ? 'text-desa-600' : 'text-gray-800' }}">
                                                    {{ $item['label'] }}</p>
                                                <p class="text-xs text-gray-400">{{ $item['desc'] }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Right side --}}
                <div class="flex items-center gap-3">
                    @auth
                        <div class="relative" x-data="{ show: false }">
                            <button @click="show = !show"
                                class="flex items-center gap-2 rounded-full bg-gray-100 p-1.5 pr-3 text-sm font-medium text-gray-700 hover:bg-gray-200 transition-colors">
                                <div
                                    class="h-7 w-7 rounded-full bg-desa-500 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                            </button>
                            <div x-show="show" @click.away="show = false" x-transition
                                class="absolute right-0 mt-2 w-48 rounded-xl bg-white shadow-lg ring-1 ring-gray-200 py-1 z-50">
                                @if (auth()->user()->isWarga())
                                    <a href="{{ route('surat.ajukan') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" wire:navigate>
                                        <span class="inline-flex items-center gap-2"><span
                                                class="material-symbols-outlined text-base">edit_note</span> Ajukan
                                            Surat</span>
                                    </a>
                                    <a href="{{ route('surat.status') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" wire:navigate>
                                        <span class="inline-flex items-center gap-2"><span
                                                class="material-symbols-outlined text-base">fact_check</span> Surat
                                            Saya</span>
                                    </a>
                                @endif
                                @if (auth()->user()->isStaff())
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" wire:navigate>
                                        <span class="inline-flex items-center gap-2"><span
                                                class="material-symbols-outlined text-base">dashboard</span> Admin
                                            Panel</span>
                                    </a>
                                @endif
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <span class="inline-flex items-center gap-2"><span
                                                class="material-symbols-outlined text-base">logout</span> Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="btn-primary btn-sm" wire:navigate>
                                <span class="material-symbols-outlined text-base">login</span>
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-secondary btn-sm hidden sm:inline-flex"
                                    wire:navigate>
                                    Daftar
                                </a>
                            @endif
                        </div>
                    @endauth

                    {{-- Mobile hamburger --}}
                    <button @click="open = !open"
                        class="lg:hidden rounded-lg p-2 text-gray-600 hover:bg-gray-100 transition-colors">
                        <span class="material-symbols-outlined" x-text="open ? 'close' : 'menu'">menu</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Nav --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="lg:hidden border-t border-gray-100 bg-white max-h-[80vh] overflow-y-auto" x-data="{ mobileGroup: null }">
            <div class="px-4 py-3 space-y-1">
                @foreach ($navGroups as $gi => $group)
                    @if ($group['type'] === 'link')
                        <a href="{{ route($group['route']) }}" wire:navigate @click="open = false"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs($group['route']) ? 'text-desa-600 bg-desa-50' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined text-lg">{{ $group['icon'] }}</span>
                            {{ $group['label'] }}
                        </a>
                    @else
                        {{-- Mobile accordion group --}}
                        <div>
                            <button
                                @click="mobileGroup === {{ $gi }} ? mobileGroup = null : mobileGroup = {{ $gi }}"
                                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs($group['activeRoutes']) ? 'text-desa-600 bg-desa-50' : 'text-gray-600 hover:bg-gray-50' }}">
                                <span class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-lg">{{ $group['icon'] }}</span>
                                    {{ $group['label'] }}
                                </span>
                                <span class="material-symbols-outlined text-sm transition-transform duration-200"
                                    :class="mobileGroup === {{ $gi }} ? 'rotate-180' : ''">expand_more</span>
                            </button>
                            <div x-show="mobileGroup === {{ $gi }}" x-collapse>
                                <div class="ml-6 pl-3 border-l-2 border-gray-100 space-y-0.5 py-1">
                                    @foreach ($group['items'] as $item)
                                        <a href="{{ route($item['route']) }}" wire:navigate @click="open = false"
                                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs($item['route']) ? 'text-desa-600 bg-desa-50 font-medium' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                                            <span
                                                class="material-symbols-outlined text-base">{{ $item['icon'] }}</span>
                                            {{ $item['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </nav>

    {{-- ─── MAIN CONTENT ──────────────────────────────────── --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- ─── FOOTER ────────────────────────────────────────── --}}
    @php $village = \App\Models\VillageProfile::getCached(); @endphp
    <footer class="bg-desa-900 text-white mt-auto">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                {{-- Brand --}}
                <div class="flex items-center gap-3">
                    @if ($village?->logo)
                        <img src="{{ Storage::url($village->logo) }}" alt="{{ config('app.name') }}"
                            class="h-9 w-9 rounded-lg object-cover">
                    @else
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                            <span class="material-symbols-outlined text-amber-400 text-lg">location_city</span>
                        </div>
                    @endif
                    <div>
                        <p class="font-bold text-sm leading-tight">{{ $village?->name ?? config('app.name') }}</p>
                        <p class="text-xs text-desa-400">{{ $village?->tagline ?? 'Website Profil Desa Digital' }}</p>
                    </div>
                </div>
                {{-- Links --}}
                <nav class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-desa-300">
                    <a href="{{ route('profil-desa') }}" class="hover:text-white transition-colors"
                        wire:navigate>Profil</a>
                    <a href="{{ route('berita.index') }}" class="hover:text-white transition-colors"
                        wire:navigate>Berita</a>
                    <a href="{{ route('anggaran') }}" class="hover:text-white transition-colors"
                        wire:navigate>Anggaran</a>
                    <a href="{{ route('surat.info') }}" class="hover:text-white transition-colors"
                        wire:navigate>Layanan Surat</a>
                    <a href="{{ route('kontak') }}" class="hover:text-white transition-colors"
                        wire:navigate>Kontak</a>
                </nav>
            </div>
            <hr class="my-6 border-white/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-desa-500">
                <p>&copy; {{ date('Y') }} {{ $village?->name ?? config('app.name') }}. Hak cipta dilindungi.</p>
                @if ($village?->address)
                    <p class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">location_on</span>
                        {{ $village->address }}
                    </p>
                @endif
            </div>
        </div>
    </footer>

    @livewireScripts
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal', (params) => {
                const p = params[0] || params;
                Swal.fire({
                    icon: p.icon || 'success',
                    title: p.title || 'Berhasil',
                    text: p.text || '',
                    timer: p.timer || 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    timerProgressBar: true,
                    customClass: {
                        popup: 'swal-toast'
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 700,
                    easing: 'ease-out-cubic',
                    once: true,
                    offset: 60,
                    disable: window.innerWidth < 768 ? 'mobile' : false
                });
            }
        });
        document.addEventListener('livewire:navigated', () => {
            if (typeof AOS !== 'undefined') AOS.refresh();
        });
    </script>
    @stack('scripts')
</body>

</html>
