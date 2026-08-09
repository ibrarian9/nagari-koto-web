<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ($title ?? 'Dashboard') . ' — Admin ' . config('app.name') }}</title>
    @include('partials.favicon')

    {{-- All CSS & JS bundled locally via Vite — zero CDN dependencies --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* Independent scroll zones — prevent sidebar/main from sharing scroll */
        .admin-shell { height: 100vh; display: flex; overflow: hidden; }
        .admin-sidebar { display: flex; flex-direction: column; height: 100vh; overflow: hidden; }
        .admin-sidebar-nav { flex: 1; overflow-y: auto; scrollbar-width: thin; scrollbar-color: rgba(255,255,255,.15) transparent; }
        .admin-sidebar-nav::-webkit-scrollbar { width: 4px; }
        .admin-sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 4px; }
        .admin-main { flex: 1; display: flex; flex-direction: column; overflow-y: auto; min-width: 0; }

        /* Collapse transition */
        .admin-sidebar-wrap { transition: width .25s cubic-bezier(.4,0,.2,1), margin-left .25s cubic-bezier(.4,0,.2,1); }
        @media (min-width: 1024px) {
            .admin-sidebar-wrap { width: 16rem; flex-shrink: 0; }
            .admin-sidebar-wrap.collapsed { width: 0; overflow: hidden; }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100"
      x-data="{
          sidebarOpen: false,
          collapsed: localStorage.getItem('admin_sidebar_collapsed') === 'true',
          toggle() { this.collapsed = !this.collapsed; localStorage.setItem('admin_sidebar_collapsed', this.collapsed); }
      }">

    {{-- ─── GREEN TOP LOADING PROGRESS BAR (WIRE:NAVIGATE) ────────────── --}}
    <div id="admin-page-progress-bar"
        class="fixed top-0 left-0 right-0 z-[99999] h-1 bg-gradient-to-r from-emerald-500 via-teal-400 to-green-500 shadow-[0_0_12px_rgba(16,185,129,0.9)] transition-all duration-300 ease-out opacity-0 pointer-events-none"
        style="width: 0%;"></div>


    <div class="admin-shell">
        {{-- ─── SIDEBAR ──────────────────────────────────────── --}}
        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-black/50 lg:hidden"></div>

        {{-- Desktop sidebar wrap --}}
        @persist('admin-sidebar')
        <div class="admin-sidebar-wrap hidden lg:block" :class="collapsed && 'collapsed'">
            <aside class="admin-sidebar w-64 bg-gradient-to-b from-desa-800 to-desa-950">
                @include('layouts.partials._admin-sidebar-content')
            </aside>
        </div>
        @endpersist


        {{-- Mobile sidebar (slide-in) --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="admin-sidebar fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-desa-800 to-desa-950 transition-transform duration-300 lg:hidden">
            @include('layouts.partials._admin-sidebar-content', ['showClose' => true])
        </aside>

        {{-- ─── MAIN AREA ────────────────────────────────────── --}}
        <div class="admin-main">
            {{-- Topbar --}}
            <header class="sticky top-0 z-30 flex h-14 items-center gap-3 bg-white border-b border-gray-200 px-4 sm:px-6 shadow-sm flex-shrink-0">
                {{-- Mobile menu --}}
                <button @click="sidebarOpen = true" class="lg:hidden rounded-lg p-1.5 text-gray-500 hover:bg-gray-100 transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                {{-- Desktop collapse toggle --}}
                <button @click="toggle()" class="hidden lg:flex rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors" title="Toggle sidebar">
                    <span class="material-symbols-outlined text-xl" x-text="collapsed ? 'menu' : 'menu_open'">menu_open</span>
                </button>
                <h1 class="text-base font-semibold text-gray-800 truncate">{{ $title ?? 'Dashboard' }}</h1>
                <div class="ml-auto flex items-center gap-3">
                    <span class="text-sm text-gray-500 hidden sm:inline">{{ auth()->user()?->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors" title="Keluar">
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

            Livewire.hook('upload:error', (component, name, error) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Gagal',
                    text: 'Gagal mengunggah file. Pastikan ukuran file tidak melebihi batas yang ditentukan.',
                    confirmButtonColor: '#2D6A4F'
                });
            });

            // ─── GREEN TOP LOADING PROGRESS BAR HANDLER ───────────
            const progressBar = document.getElementById('admin-page-progress-bar');
            let progressTimer;

            document.addEventListener('livewire:navigating', () => {
                if (!progressBar) return;
                clearTimeout(progressTimer);
                progressBar.style.transition = 'width 0.3s ease-out, opacity 0.15s ease-in';
                progressBar.style.opacity = '1';
                progressBar.style.width = '35%';

                progressTimer = setTimeout(() => {
                    progressBar.style.width = '75%';
                }, 100);
            });

            document.addEventListener('livewire:navigated', () => {
                if (!progressBar) return;
                clearTimeout(progressTimer);
                progressBar.style.width = '100%';

                progressTimer = setTimeout(() => {
                    progressBar.style.opacity = '0';
                    setTimeout(() => {
                        progressBar.style.transition = 'none';
                        progressBar.style.width = '0%';
                    }, 200);
                }, 250);
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

        // ── Smart Auto-scroll sidebar (Only scroll if active item is out of view on initial load) ──
        function scrollSidebarToActiveIfNeeded() {
            document.querySelectorAll('.admin-sidebar-nav').forEach(nav => {
                const active = nav.querySelector('[data-active]');
                if (active) {
                    const navRect = nav.getBoundingClientRect();
                    const activeRect = active.getBoundingClientRect();
                    // Only scroll if active item is hidden above or below the scroll viewport
                    if (activeRect.top < navRect.top || activeRect.bottom > navRect.bottom) {
                        active.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                    }
                }
            });
        }
        // Only run on initial full page load
        setTimeout(scrollSidebarToActiveIfNeeded, 150);

    </script>
    @stack('scripts')
</body>
</html>
