<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="{{ $metaDescription ?? 'Website Profil Nagari Digital — Informasi lengkap tentang nagari, pemerintahan, berita, dan layanan publik.' }}">

    <title>{{ ($title ?? 'Beranda') . ' — ' . config('app.name') }}</title>
    @include('partials.favicon')

    {{-- LCP image preload (diisi per-halaman) --}}
    @stack('preload')

    {{-- All CSS & JS bundled locally via Vite — zero CDN dependencies --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen flex flex-col bg-gray-50">

    {{-- ─── ACCESSIBILITY WIDGET ─────────────────────────────── --}}
    @include('partials.accessibility-widget')

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
                            'label' => 'Informasi',
                            'icon' => 'info',
                            'activeRoutes' => ['berita.index', 'berita.show', 'agenda', 'kontak', 'produk-hukum'],
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
                                    'desc' => 'Nomor penting nagari',
                                ],
                                [
                                    'route' => 'produk-hukum',
                                    'label' => 'Produk Hukum',
                                    'icon' => 'gavel',
                                    'desc' => 'Dokumen & peraturan nagari',
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
                            'activeRoutes' => ['ppid.home'],
                            'items' => [
                                [
                                    'route' => 'ppid.home',
                                    'params' => ['tab' => 'profil'],
                                    'label' => 'Profil Singkat',
                                    'icon' => 'badge',
                                    'desc' => 'Profil Singkat PPID',
                                ],
                                [
                                    'route' => 'ppid.home',
                                    'params' => ['tab' => 'visi'],
                                    'label' => 'Visi & Misi',
                                    'icon' => 'visibility',
                                    'desc' => 'Visi & Misi PPID',
                                ],
                                [
                                    'route' => 'ppid.home',
                                    'params' => ['tab' => 'tugas'],
                                    'label' => 'Tugas & Fungsi',
                                    'icon' => 'assignment',
                                    'desc' => 'Tugas & Fungsi PPID',
                                ],
                                [
                                    'route' => 'ppid.home',
                                    'params' => ['tab' => 'struktur'],
                                    'label' => 'Struktur Organisasi',
                                    'icon' => 'account_tree',
                                    'desc' => 'Struktur Organisasi PPID',
                                ],
                                [
                                    'route' => 'ppid.home',
                                    'params' => ['tab' => 'dip'],
                                    'label' => 'Informasi Publik',
                                    'icon' => 'list_alt',
                                    'desc' => 'Berkala, Setiap Saat & Serta Merta',
                                ],
                                [
                                    'type' => 'sub_dropdown',
                                    'label' => 'Pelayanan Publik',
                                    'icon' => 'support_agent',
                                    'desc' => 'Form online & alur pelayanan',
                                    'sub_items' => [
                                        [
                                            'route' => 'ppid.home',
                                            'params' => ['tab' => 'pelayanan', 'sub' => 'alur_info'],
                                            'label' => 'Alur Informasi',
                                            'icon' => 'route',
                                        ],
                                        [
                                            'route' => 'ppid.home',
                                            'params' => ['tab' => 'pelayanan', 'sub' => 'permohonan'],
                                            'label' => 'Permohonan Online',
                                            'icon' => 'edit_note',
                                        ],
                                        [
                                            'route' => 'ppid.home',
                                            'params' => ['tab' => 'pelayanan', 'sub' => 'alur_kbr'],
                                            'label' => 'Alur Keberatan',
                                            'icon' => 'report',
                                        ],
                                        [
                                            'route' => 'ppid.home',
                                            'params' => ['tab' => 'pelayanan', 'sub' => 'keberatan'],
                                            'label' => 'Keberatan Online',
                                            'icon' => 'feedback',
                                        ],
                                        [
                                            'route' => 'ppid.home',
                                            'params' => ['tab' => 'pelayanan', 'sub' => 'alur_skt'],
                                            'label' => 'Alur Sengketa',
                                            'icon' => 'balance',
                                        ],
                                    ],
                                ],
                                [
                                    'route' => 'ppid.home',
                                    'params' => ['tab' => 'maklumat'],
                                    'label' => 'Maklumat Pelayanan',
                                    'icon' => 'verified',
                                    'desc' => 'Maklumat Pelayanan PPID',
                                ],
                                [
                                    'route' => 'ppid.home',
                                    'params' => ['tab' => 'jadwal'],
                                    'label' => 'Jadwal & Biaya',
                                    'icon' => 'event_note',
                                    'desc' => 'Jadwal & Biaya Informasi',
                                ],
                                [
                                    'route' => 'ppid.home',
                                    'params' => ['tab' => 'dikecualikan'],
                                    'label' => 'Informasi Dikecualikan',
                                    'icon' => 'lock',
                                    'desc' => 'Informasi yang Dikecualikan',
                                ],
                                [
                                    'route' => 'ppid.home',
                                    'params' => ['tab' => 'regulasi'],
                                    'label' => 'Regulasi',
                                    'icon' => 'gavel',
                                    'desc' => 'Dasar Hukum & SOP',
                                ],
                            ],
                        ],
                        [
                            'type' => 'dropdown',
                            'label' => 'Profil',
                            'icon' => 'info',
                            'activeRoutes' => ['profil-nagari', 'pemerintahan'],
                            'items' => [
                                [
                                    'route' => 'profil-nagari',
                                    'label' => 'Profil Nagari',
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
                                    'desc' => 'APBNag & transparansi',
                                ],
                                [
                                    'route' => 'kehutanan',
                                    'label' => 'Kehutanan',
                                    'icon' => 'forest',
                                    'desc' => 'Data kawasan hutan nagari',
                                ],
                            ],
                        ],
                        [
                            'type' => 'dropdown',
                            'label' => 'Lembaga Nagari',
                            'icon' => 'info',
                            'activeRoutes' => [
                                'bamus',
                                'lembaga',
                                'bumnag.home',
                                'bumnag.struktur',
                                'bumnag.hukum',
                                'bumnag.anggaran',
                                'bumnag.program-kerja',
                            ],
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
                            'label' => 'Potensi',
                            'icon' => 'eco',
                            'activeRoutes' => ['potensi', 'umkm'],
                            'items' => [
                                [
                                    'route' => 'potensi',
                                    'label' => 'Potensi Nagari',
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
                                    class="absolute left-0 mt-1 w-64 rounded-xl bg-white shadow-xl ring-1 ring-gray-200/70 py-2 z-50">
                                    @foreach ($group['items'] as $item)
                                        @if (($item['type'] ?? '') === 'sub_dropdown')
                                            {{-- Sub Dropdown --}}
                                            <div class="relative" x-data="{ subdd: false }" @mouseenter="subdd = true"
                                                @mouseleave="subdd = false">
                                                <button @click="subdd = !subdd"
                                                    class="w-full flex items-center justify-between px-4 py-2.5 hover:bg-gray-50 text-gray-800 transition-colors">
                                                    <div class="flex items-start gap-3">
                                                        <span
                                                            class="material-symbols-outlined text-lg mt-0.5 text-gray-400">{{ $item['icon'] }}</span>
                                                        <div class="text-left">
                                                            <p class="text-sm font-medium text-gray-800">
                                                                {{ $item['label'] }}</p>
                                                            <p class="text-xs text-gray-400">{{ $item['desc'] }}</p>
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="material-symbols-outlined text-sm text-gray-400">chevron_right</span>
                                                </button>
                                                {{-- Sub Dropdown Menu --}}
                                                <div x-show="subdd"
                                                    x-transition:enter="transition ease-out duration-150"
                                                    x-transition:enter-start="opacity-0 translate-x-1"
                                                    x-transition:enter-end="opacity-100 translate-x-0"
                                                    x-transition:leave="transition ease-in duration-100"
                                                    x-transition:leave-start="opacity-100 translate-x-0"
                                                    x-transition:leave-end="opacity-0 translate-x-1"
                                                    class="absolute left-full top-0 ml-1 w-56 rounded-xl bg-white shadow-xl ring-1 ring-gray-200/70 py-2 z-50">
                                                    @foreach ($item['sub_items'] as $subItem)
                                                        @php
                                                            $isSubActive =
                                                                request()->routeIs($subItem['route']) &&
                                                                (empty($subItem['params']) ||
                                                                    collect($subItem['params'])->every(
                                                                        fn($val, $key) => request()->query($key) ==
                                                                            $val,
                                                                    ));
                                                        @endphp
                                                        <a href="{{ route($subItem['route'], $subItem['params'] ?? []) }}"
                                                            wire:navigate
                                                            class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 transition-colors {{ $isSubActive ? 'bg-desa-50 text-desa-600 font-medium' : 'text-gray-700' }}">
                                                            <span
                                                                class="material-symbols-outlined text-base {{ $isSubActive ? 'text-desa-600' : 'text-gray-400' }}">{{ $subItem['icon'] }}</span>
                                                            <span
                                                                class="text-xs font-semibold">{{ $subItem['label'] }}</span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            @php
                                                $isActive =
                                                    request()->routeIs($item['route']) &&
                                                    (empty($item['params']) ||
                                                        collect($item['params'])->every(
                                                            fn($val, $key) => request()->query($key) == $val,
                                                        ));
                                            @endphp
                                            <a href="{{ route($item['route'], $item['params'] ?? []) }}" wire:navigate
                                                class="flex items-start gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors {{ $isActive ? 'bg-desa-50' : '' }}">
                                                <span
                                                    class="material-symbols-outlined text-lg mt-0.5 {{ $isActive ? 'text-desa-600' : 'text-gray-400' }}">{{ $item['icon'] }}</span>
                                                <div>
                                                    <p
                                                        class="text-sm font-medium {{ $isActive ? 'text-desa-600' : 'text-gray-800' }}">
                                                        {{ $item['label'] }}</p>
                                                    <p class="text-xs text-gray-400">{{ $item['desc'] }}</p>
                                                </div>
                                            </a>
                                        @endif
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
                                        @if (($item['type'] ?? '') === 'sub_dropdown')
                                            {{-- Sub Dropdown Mobile (Accordion) --}}
                                            <div x-data="{ subOpen: false }">
                                                <button @click="subOpen = !subOpen"
                                                    class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-50">
                                                    <span class="flex items-center gap-3">
                                                        <span
                                                            class="material-symbols-outlined text-base text-gray-400">{{ $item['icon'] }}</span>
                                                        {{ $item['label'] }}
                                                    </span>
                                                    <span
                                                        class="material-symbols-outlined text-xs transition-transform duration-200"
                                                        :class="subOpen ? 'rotate-180' : ''">expand_more</span>
                                                </button>
                                                <div x-show="subOpen" x-collapse>
                                                    <div class="ml-4 pl-3 border-l border-gray-100 space-y-0.5 py-1">
                                                        @foreach ($item['sub_items'] as $subItem)
                                                            @php
                                                                $isSubActive =
                                                                    request()->routeIs($subItem['route']) &&
                                                                    (empty($subItem['params']) ||
                                                                        collect($subItem['params'])->every(
                                                                            fn($val, $key) => request()->query($key) ==
                                                                                $val,
                                                                        ));
                                                            @endphp
                                                            <a href="{{ route($subItem['route'], $subItem['params'] ?? []) }}"
                                                                wire:navigate @click="open = false"
                                                                class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-xs transition-colors {{ $isSubActive ? 'text-desa-600 bg-desa-50 font-semibold' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                                                                <span
                                                                    class="material-symbols-outlined text-sm {{ $isSubActive ? 'text-desa-600' : 'text-gray-400' }}">{{ $subItem['icon'] }}</span>
                                                                {{ $subItem['label'] }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @php
                                                $isActive =
                                                    request()->routeIs($item['route']) &&
                                                    (empty($item['params']) ||
                                                        collect($item['params'])->every(
                                                            fn($val, $key) => request()->query($key) == $val,
                                                        ));
                                            @endphp
                                            <a href="{{ route($item['route'], $item['params'] ?? []) }}" wire:navigate
                                                @click="open = false"
                                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ $isActive ? 'text-desa-600 bg-desa-50 font-medium' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                                                <span
                                                    class="material-symbols-outlined text-base {{ $isActive ? 'text-desa-600' : 'text-gray-400' }}">{{ $item['icon'] }}</span>
                                                {{ $item['label'] }}
                                            </a>
                                        @endif
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
                        <p class="text-xs text-desa-400">{{ $village?->tagline ?? 'Website Profil Nagari Digital' }}
                        </p>
                    </div>
                </div>
                {{-- Links --}}
                <nav class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-desa-300">
                    <a href="{{ route('profil-nagari') }}" class="hover:text-white transition-colors"
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

            {{-- Social Media --}}
            @if (!empty($village?->social_media))
                <div class="mt-6 flex items-center gap-3 flex-wrap">
                    @foreach ($village->social_media as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                            class="h-9 w-9 rounded-lg bg-white/10 flex items-center justify-center text-desa-400 hover:text-white hover:bg-white/20 transition-all duration-200"
                            title="{{ ucfirst($social['platform'] ?? '') }}">
                            @switch($social['platform'] ?? '')
                                @case('facebook')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                @break

                                @case('instagram')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                    </svg>
                                @break

                                @case('youtube')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                    </svg>
                                @break

                                @case('tiktok')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                                    </svg>
                                @break

                                @case('twitter')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                    </svg>
                                @break

                                @case('whatsapp')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                    </svg>
                                @break

                                @case('telegram')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
                                    </svg>
                                @break

                                @case('email')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                    </svg>
                                @break
                            @endswitch
                        </a>
                    @endforeach
                </div>
            @endif

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
