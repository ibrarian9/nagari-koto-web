<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ($title ?? 'Dashboard') . ' — Admin ' . config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Fonts: async --}}
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"></noscript>

    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap"></noscript>

    {{-- JS: all deferred --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <link rel="stylesheet" href="https://unpkg.com/trix@2.1.8/dist/trix.css" media="print" onload="this.media='all'">
    <script src="https://unpkg.com/trix@2.1.8/dist/trix.umd.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" media="print" onload="this.media='all'">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js" defer></script>
</head>
<body class="min-h-screen bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">
        {{-- ─── SIDEBAR ──────────────────────────────────────── --}}
        {{-- Overlay --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-black/50 lg:hidden"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-desa-800 to-desa-950 transition-transform duration-300 lg:translate-x-0 lg:static lg:z-auto flex flex-col">

            {{-- Brand --}}
            <div class="flex h-16 items-center gap-3 px-5 border-b border-white/10">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                    <span class="material-symbols-outlined text-amber-400">admin_panel_settings</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-white leading-tight">Admin Panel</p>
                    <p class="text-xs text-desa-300">{{ config('app.name') }}</p>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden ml-auto text-white/60 hover:text-white">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                @php
                    $adminNav = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard'],
                        ['divider' => true, 'label' => 'Konten'],
                        ['route' => 'admin.profil-desa', 'label' => 'Profil Desa', 'icon' => 'location_city'],
                        ['route' => 'admin.pemerintahan', 'label' => 'Pemerintahan', 'icon' => 'groups'],
                        ['route' => 'admin.berita', 'label' => 'Berita', 'icon' => 'newspaper'],
                        ['route' => 'admin.potensi', 'label' => 'Potensi Desa', 'icon' => 'eco'],
                        ['route' => 'admin.umkm', 'label' => 'UMKM', 'icon' => 'storefront'],
                        ['route' => 'admin.kontak', 'label' => 'Kontak', 'icon' => 'call'],
                        ['route' => 'admin.agenda', 'label' => 'Agenda', 'icon' => 'event'],
                        ['divider' => true, 'label' => 'Data & Statistik'],
                        ['route' => 'admin.infografis', 'label' => 'Infografis', 'icon' => 'bar_chart'],
                        ['route' => 'admin.idm', 'label' => 'IDM', 'icon' => 'trending_up'],
                        ['route' => 'admin.anggaran', 'label' => 'Anggaran', 'icon' => 'account_balance'],
                        ['divider' => true, 'label' => 'Layanan'],
                        ['route' => 'admin.surat', 'label' => 'Permohonan Surat', 'icon' => 'mail'],
                        ['route' => 'admin.pbb', 'label' => 'PBB', 'icon' => 'receipt_long'],
                        ['route' => 'admin.bansos', 'label' => 'Bansos', 'icon' => 'volunteer_activism'],
                    ];
                    if (auth()->user()?->isSuperAdmin() || auth()->user()?->isAdmin()) {
                        $adminNav[] = ['divider' => true, 'label' => 'Sistem'];
                        $adminNav[] = ['route' => 'admin.users', 'label' => 'Manajemen User', 'icon' => 'manage_accounts'];
                    }
                @endphp
                @foreach($adminNav as $item)
                    @if(isset($item['divider']))
                        <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-desa-400">{{ $item['label'] }}</p>
                    @else
                        <a href="{{ route($item['route']) }}" wire:navigate
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs($item['route']) ? 'bg-white/15 text-white shadow-sm' : 'text-desa-200 hover:bg-white/10 hover:text-white' }}">
                            <span class="material-symbols-outlined text-lg" style="font-size:20px">{{ $item['icon'] }}</span>
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            {{-- Bottom --}}
            <div class="border-t border-white/10 p-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-desa-300 hover:bg-white/10 hover:text-white transition-colors" wire:navigate>
                    <span class="material-symbols-outlined text-lg">public</span>
                    Lihat Situs Publik
                </a>
            </div>
        </aside>

        {{-- ─── MAIN AREA ────────────────────────────────────── --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Topbar --}}
            <header class="sticky top-0 z-30 flex h-16 items-center gap-4 bg-white border-b border-gray-200 px-4 sm:px-6 shadow-sm">
                <button @click="sidebarOpen = true" class="lg:hidden rounded-lg p-2 text-gray-500 hover:bg-gray-100">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <h1 class="text-lg font-semibold text-gray-800 truncate">{{ $title ?? 'Dashboard' }}</h1>
                <div class="ml-auto flex items-center gap-3">
                    <span class="text-sm text-gray-500 hidden sm:inline">{{ auth()->user()?->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg p-2 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors" title="Keluar">
                            <span class="material-symbols-outlined text-xl">logout</span>
                        </button>
                    </form>
                </div>
            </header>



            {{-- Content --}}
            <main class="flex-1 p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

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
                    customClass: { popup: 'swal-toast' }
                });
            });
        });

        function confirmAction(id, action, message) {
            Swal.fire({
                title: 'Konfirmasi',
                text: message || 'Yakin ingin melanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2D6A4F',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch(action, { id: id });
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
