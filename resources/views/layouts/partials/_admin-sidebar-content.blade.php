{{-- Brand --}}
<div class="flex h-14 items-center gap-3 px-4 border-b border-white/10 flex-shrink-0">
    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
        <span class="material-symbols-outlined text-amber-400">admin_panel_settings</span>
    </div>
    <div class="min-w-0">
        <p class="text-sm font-bold text-white leading-tight truncate">Admin Panel</p>
        <p class="text-xs text-desa-300 truncate">{{ config('app.name') }}</p>
    </div>
    @if (!empty($showClose))
        <button @click="sidebarOpen = false" class="ml-auto text-white/60 hover:text-white p-1">
            <span class="material-symbols-outlined">close</span>
        </button>
    @endif
</div>

{{-- Nav --}}
<nav class="admin-sidebar-nav px-3 py-3 space-y-0.5" x-data="{
    currentPath: window.location.pathname,
    _handler: null,
    init() {
        this._handler = () => { this.currentPath = window.location.pathname; };
        document.addEventListener('livewire:navigated', this._handler);
    },
    destroy() {
        if (this._handler) document.removeEventListener('livewire:navigated', this._handler);
    },
    isActive(el) {
        try { return this.currentPath === new URL(el.href, window.location.origin).pathname; } catch { return false; }
    }
}">
    @php
        $pendingSurat = \App\Models\LetterRequest::where('status', 'pending')->count();
        $pendingDonasi = \App\Models\Donation::where('payment_status', 'pending')->count();
        $pendingPpid = \App\Models\PpidPermohonan::whereIn('status', ['menunggu'])->count();
        $pendingKeberatan = \App\Models\PpidKeberatan::whereIn('status', ['diterima'])->count();
        $pendingKomentar = \App\Models\PpidComment::where('is_approved', false)->count();

        $adminNav = [
            // ── Utama
            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard'],

            // ── Pemerintahan & Kelembagaan
            ['divider' => true, 'label' => 'Pemerintahan'],
            ['route' => 'admin.profil-nagari', 'label' => 'Profil Nagari', 'icon' => 'location_city'],
            ['route' => 'admin.pemerintahan', 'label' => 'Perangkat Nagari', 'icon' => 'groups'],
            ['route' => 'admin.bamus', 'label' => 'BAMUS', 'icon' => 'gavel'],
            ['route' => 'admin.lembaga', 'label' => 'Lembaga Nagari', 'icon' => 'domain'],

            // ── BUMNag
            ['divider' => true, 'label' => 'BUMNag'],
            ['route' => 'admin.bumnag-profil', 'label' => 'Profil BUMNag', 'icon' => 'store'],
            ['route' => 'admin.bumnag-anggota', 'label' => 'Anggota BUMNag', 'icon' => 'badge'],
            ['route' => 'admin.bumnag-anggaran', 'label' => 'Anggaran BUMNag', 'icon' => 'account_balance'],
            ['route' => 'admin.bumnag-program', 'label' => 'Program Kerja', 'icon' => 'assignment'],

            // ── Konten & Publikasi
            ['divider' => true, 'label' => 'Konten'],
            ['route' => 'admin.berita', 'label' => 'Berita', 'icon' => 'newspaper'],
            ['route' => 'admin.potensi', 'label' => 'Potensi Nagari', 'icon' => 'eco'],
            ['route' => 'admin.umkm', 'label' => 'UMKM', 'icon' => 'storefront'],
            ['route' => 'admin.agenda', 'label' => 'Agenda', 'icon' => 'event'],
            ['route' => 'admin.hero', 'label' => 'Hero Halaman', 'icon' => 'wallpaper'],
            ['route' => 'admin.kontak', 'label' => 'Kontak', 'icon' => 'call'],

            // ── Data & Statistik
            ['divider' => true, 'label' => 'Data & Statistik'],
            ['route' => 'admin.infografis', 'label' => 'Infografis', 'icon' => 'bar_chart'],
            ['route' => 'admin.idm', 'label' => 'IDM', 'icon' => 'trending_up'],
            ['route' => 'admin.anggaran', 'label' => 'Anggaran Nagari', 'icon' => 'account_balance_wallet'],
            ['route' => 'admin.kehutanan', 'label' => 'Kehutanan', 'icon' => 'forest'],

            // ── Layanan Publik
            ['divider' => true, 'label' => 'Layanan Publik'],
            ['route' => 'admin.surat', 'label' => 'Permohonan Surat', 'icon' => 'mail', 'badge' => $pendingSurat],
            ['route' => 'admin.donasi', 'label' => 'Donasi', 'icon' => 'favorite', 'badge' => $pendingDonasi],

            // ── Produk Hukum
            ['divider' => true, 'label' => 'Produk Hukum'],
            ['route' => 'admin.produk-hukum', 'label' => 'Dokumen Hukum', 'icon' => 'gavel'],

            // ── PPID
            ['divider' => true, 'label' => 'PPID'],
            ['route' => 'admin.ppid-konten', 'label' => 'Konten PPID', 'icon' => 'article'],
            ['route' => 'admin.ppid-berkala', 'label' => 'Info Berkala', 'icon' => 'schedule'],
            ['route' => 'admin.ppid-setiap-saat', 'label' => 'Info Setiap Saat', 'icon' => 'folder_open'],
            ['route' => 'admin.ppid-serta-merta', 'label' => 'Info Serta Merta', 'icon' => 'campaign'],
            [
                'route' => 'admin.ppid-permohonan',
                'label' => 'Permohonan PPID',
                'icon' => 'assignment',
                'badge' => $pendingPpid,
            ],
            [
                'route' => 'admin.ppid-keberatan',
                'label' => 'Keberatan PPID',
                'icon' => 'report',
                'badge' => $pendingKeberatan,
            ],
            [
                'route' => 'admin.ppid-komentar',
                'label' => 'Komentar PPID',
                'icon' => 'chat',
                'badge' => $pendingKomentar,
            ],
        ];
        if (auth()->user()?->isSuperAdmin() || auth()->user()?->isAdmin()) {
            $adminNav[] = ['divider' => true, 'label' => 'Sistem'];
            $adminNav[] = ['route' => 'admin.users', 'label' => 'Manajemen User', 'icon' => 'manage_accounts'];
            $adminNav[] = ['route' => 'admin.system-logs', 'label' => 'Log Error & Aktivitas', 'icon' => 'terminal'];
        }

    @endphp
    @foreach ($adminNav as $item)
        @if (isset($item['divider']))
            <p class="px-3 pt-4 pb-1 text-[10px] font-bold uppercase tracking-widest text-desa-400/80">
                {{ $item['label'] }}</p>
        @else
            <a href="{{ route($item['route']) }}" wire:navigate.hover
                @if (!empty($showClose)) @click="sidebarOpen = false" @endif
                x-bind:data-active="isActive($el) ? '' : null"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150"
                :class="isActive($el) ? 'bg-white/15 text-white shadow-sm' :
                    'text-desa-200/80 hover:bg-white/10 hover:text-white'">
                <span class="material-symbols-outlined" style="font-size:18px">{{ $item['icon'] }}</span>
                <span class="truncate">{{ $item['label'] }}</span>
                @if (($item['badge'] ?? 0) > 0)
                    <span
                        class="ml-auto inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full text-[10px] font-bold bg-red-500 text-white">{{ $item['badge'] }}</span>
                @endif
            </a>
        @endif
    @endforeach
</nav>

{{-- Bottom --}}
<div class="border-t border-white/10 p-3 flex-shrink-0">
    <a href="{{ route('home') }}"
        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-desa-300 hover:bg-white/10 hover:text-white transition-colors"
        wire:navigate.hover>
        <span class="material-symbols-outlined text-lg">public</span>
        Lihat Situs Publik
    </a>
</div>

