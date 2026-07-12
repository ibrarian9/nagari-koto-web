<div>
    {{-- ─── PREMIUM GREETING BANNER ─────────────────────────────────── --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-desa-900 via-desa-800 to-desa-950 p-6 sm:p-8 text-white shadow-lg mb-8">
        {{-- Decorative Glowing Orbs --}}
        <div class="absolute -right-10 -top-10 w-48 h-48 rounded-full bg-desa-400/20 blur-3xl"></div>
        <div class="absolute right-1/4 -bottom-10 w-36 h-36 rounded-full bg-amber-400/10 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-desa-100 backdrop-blur-sm mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                    Sistem Manajemen Nagari Aktif
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Selamat {{ now()->hour < 12 ? 'Pagi' : (now()->hour < 17 ? 'Siang' : 'Malam') }},
                    {{ auth()->user()->name }} 👋
                </h1>
                <p class="text-sm text-desa-200 mt-2 max-w-xl">
                    Senang melihat Anda kembali. Hari ini adalah <span class="font-bold text-amber-400">{{ now()->translatedFormat('l, d F Y') }}</span>. Pantau dan kelola seluruh perkembangan administrasi Nagari Koto dari satu dashboard terpusat.
                </p>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white text-desa-900 hover:bg-desa-50 text-sm font-bold shadow-md transition-all hover:scale-[1.02] active:scale-[0.98]">
                    <span class="material-symbols-outlined text-lg">open_in_new</span>
                    Kunjungi Situs Publik
                </a>
            </div>
        </div>
    </div>

    {{-- ─── STAT CARDS (PREMIUM GLOW & TRANSITION) ─────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        @foreach ([
            [
                'icon' => 'groups',
                'label' => 'Total Penduduk',
                'value' => number_format($totalPopulation),
                'route' => 'admin.infografis',
                'bg_light' => 'bg-emerald-50 text-emerald-600',
                'glow_color' => 'hover:border-emerald-200 hover:shadow-emerald-100',
                'desc' => 'Data statistik penduduk terbaru',
            ],
            [
                'icon' => 'storefront',
                'label' => 'UMKM Aktif',
                'value' => $totalUmkm,
                'route' => 'admin.umkm',
                'bg_light' => 'bg-amber-50 text-amber-600',
                'glow_color' => 'hover:border-amber-200 hover:shadow-amber-100',
                'desc' => 'Produk lokal terpublikasi',
            ],
            [
                'icon' => 'newspaper',
                'label' => 'Berita Terbit',
                'value' => $totalBerita,
                'route' => 'admin.berita',
                'bg_light' => 'bg-blue-50 text-blue-600',
                'glow_color' => 'hover:border-blue-200 hover:shadow-blue-100',
                'desc' => 'Artikel informasi publik',
            ],
            [
                'icon' => 'mail',
                'label' => 'Surat Pending',
                'value' => $totalSuratPending,
                'route' => 'admin.surat',
                'bg_light' => 'bg-rose-50 text-rose-600',
                'glow_color' => 'hover:border-rose-200 hover:shadow-rose-100',
                'desc' => 'Menunggu verifikasi Anda',
            ],
        ] as $card)
            <a href="{{ route($card['route']) }}" wire:navigate
                class="group relative overflow-hidden rounded-2xl border border-gray-150/70 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg {{ $card['glow_color'] }}">
                <div class="flex items-start justify-between">
                    <div class="space-y-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ $card['label'] }}</p>
                        <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $card['value'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-xl flex items-center justify-center transition-all duration-300 {{ $card['bg_light'] }} group-hover:scale-110">
                        <span class="material-symbols-outlined text-2xl">{{ $card['icon'] }}</span>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between border-t border-gray-50 pt-3">
                    <span class="text-xs text-gray-400 truncate pr-2">{{ $card['desc'] }}</span>
                    <span class="material-symbols-outlined text-gray-300 group-hover:text-gray-600 transition-colors text-sm group-hover:translate-x-0.5">arrow_forward</span>
                </div>
            </a>
        @endforeach
    </div>

    {{-- ─── ALERT BAR (PULSING WARNING) ─────────────────────────────────── --}}
    @if ($totalSuratPending > 0)
        <a href="{{ route('admin.surat') }}" wire:navigate
            class="mb-8 block overflow-hidden rounded-2xl border border-rose-100 bg-gradient-to-r from-rose-50/70 to-white p-4 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center gap-4">
                <div class="relative flex-shrink-0 h-10 w-10 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600">
                    <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping"></span>
                    <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                    <span class="material-symbols-outlined text-xl">pending_actions</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-rose-900">Perhatian: Ada {{ $totalSuratPending }} permohonan surat masuk!</p>
                    <p class="text-xs text-rose-600/90 mt-0.5">Masyarakat membutuhkan persetujuan/verifikasi Anda segera. Klik di sini untuk proses cepat.</p>
                </div>
                <span class="material-symbols-outlined text-rose-400 group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </div>
        </a>
    @endif

    {{-- ─── QUICK LAUNCHPAD ─────────────────────────────────── --}}
    <div class="mb-8">
        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-desa-500"></span>
            Akses Cepat Layanan (Quick Launchpad)
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ([
                [
                    'route' => 'admin.berita',
                    'icon' => 'edit_note',
                    'label' => 'Tulis Berita',
                    'bg_light' => 'bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white',
                    'desc' => 'Rilis artikel baru'
                ],
                [
                    'route' => 'admin.agenda',
                    'icon' => 'calendar_today',
                    'label' => 'Tambah Agenda',
                    'bg_light' => 'bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white',
                    'desc' => 'Jadwal kegiatan nagari'
                ],
                [
                    'route' => 'admin.umkm',
                    'icon' => 'add_business',
                    'label' => 'Tambah UMKM',
                    'bg_light' => 'bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white',
                    'desc' => 'Daftarkan pelaku usaha'
                ],
                [
                    'route' => 'admin.donasi',
                    'icon' => 'favorite',
                    'label' => 'Kelola Donasi',
                    'bg_light' => 'bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white',
                    'desc' => 'Pantau donasi warga'
                ],
            ] as $qa)
                <a href="{{ route($qa['route']) }}" wire:navigate
                    class="group overflow-hidden rounded-2xl border border-gray-150/50 bg-white p-4 flex items-center gap-3 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="h-10 w-10 rounded-xl flex items-center justify-center flex-shrink-0 transition-all duration-300 {{ $qa['bg_light'] }} group-hover:scale-105">
                        <span class="material-symbols-outlined text-xl">{{ $qa['icon'] }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-gray-800 transition-colors group-hover:text-desa-600">{{ $qa['label'] }}</p>
                        <p class="text-[10px] text-gray-400 truncate">{{ $qa['desc'] }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- ─── STUNNING CHARTS & INSIGHTS ─────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8" x-data x-init="$nextTick(() => {
        // Surat per month
        const suratData = @js($suratPerMonth);
        const ctxSurat = document.getElementById('suratChart').getContext('2d');
        const gradSurat = ctxSurat.createLinearGradient(0, 0, 0, 250);
        gradSurat.addColorStop(0, 'rgba(45,106,79,0.3)');
        gradSurat.addColorStop(1, 'rgba(45,106,79,0.0)');

        new Chart(ctxSurat, {
            type: 'line',
            data: {
                labels: Object.keys(suratData).map(m => {
                    const parts = m.split('-');
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    return months[parseInt(parts[1]) - 1] + ' ' + parts[0];
                }),
                datasets: [{
                    label: 'Permohonan Surat',
                    data: Object.values(suratData),
                    borderColor: '#2D6A4F',
                    backgroundColor: gradSurat,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#2D6A4F',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2.5,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: 'rgba(0,0,0,0.03)' },
                        border: { dash: [4, 4] }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    
        // Population donut
        @if($popStats)
        new Chart(document.getElementById('popChart'), {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $popStats->male }}, {{ $popStats->female }}],
                    backgroundColor: ['#2563eb', '#ec4899'],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: { 
                        position: 'bottom', 
                        labels: { 
                            padding: 20, 
                            usePointStyle: true,
                            pointStyleWidth: 10,
                            font: { size: 12, weight: '600' }
                        } 
                    }
                }
            }
        });
        @endif
    
        // IDM trend
        @if($idmStats->count() > 1)
        const idmData = @js($idmStats);
        new Chart(document.getElementById('idmChart'), {
            type: 'line',
            data: {
                labels: idmData.map(d => d.year),
                datasets: [
                    { label: 'Skor IDM', data: idmData.map(d => d.score), borderColor: '#2D6A4F', backgroundColor: 'rgba(45,106,79,0.04)', fill: true, tension: 0.4, borderWidth: 3, pointRadius: 4, pointHoverRadius: 6 },
                    { label: 'IKS', data: idmData.map(d => d.social_score), borderColor: '#2563eb', borderWidth: 1.5, tension: 0.4, borderDash: [4, 4], pointRadius: 0 },
                    { label: 'IKE', data: idmData.map(d => d.economic_score), borderColor: '#f59e0b', borderWidth: 1.5, tension: 0.4, borderDash: [4, 4], pointRadius: 0 },
                    { label: 'IKL', data: idmData.map(d => d.environment_score), borderColor: '#10b981', borderWidth: 1.5, tension: 0.4, borderDash: [4, 4], pointRadius: 0 },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { 
                        position: 'bottom', 
                        labels: { 
                            padding: 16, 
                            usePointStyle: true, 
                            font: { size: 11, weight: '500' } 
                        } 
                    } 
                },
                scales: {
                    y: { 
                        beginAtZero: false, 
                        grid: { color: 'rgba(0,0,0,0.03)' },
                        border: { dash: [4, 4] }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
        @endif
    })">
        {{-- Surat Permohonan Chart --}}
        <div class="lg:col-span-2 overflow-hidden rounded-2xl border border-gray-150 bg-white shadow-sm">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50/50 to-white">
                <div>
                    <h3 class="font-extrabold text-gray-900 text-base">Permohonan Surat Masuk</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Statistik pengajuan surat dalam 6 bulan terakhir</p>
                </div>
                <div class="h-8 w-8 rounded-lg bg-desa-50 flex items-center justify-center text-desa-600">
                    <span class="material-symbols-outlined text-lg">stacked_line_chart</span>
                </div>
            </div>
            <div class="p-5">
                <div class="relative w-full h-64">
                    <canvas id="suratChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Komposisi Penduduk Chart --}}
        <div class="overflow-hidden rounded-2xl border border-gray-150 bg-white shadow-sm">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50/50 to-white">
                <div>
                    <h3 class="font-extrabold text-gray-900 text-base">Komposisi Penduduk</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Demografi gender tahun {{ $popStats?->year ?? '-' }}</p>
                </div>
                <div class="h-8 w-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                    <span class="material-symbols-outlined text-lg">pie_chart</span>
                </div>
            </div>
            <div class="p-5 flex flex-col items-center justify-center">
                <div class="relative w-full h-56">
                    <canvas id="popChart"></canvas>
                </div>
                @if($popStats)
                    <div class="mt-4 flex gap-6 text-xs font-semibold text-gray-500">
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span> Pria ({{ number_format($popStats->male) }})</span>
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span> Wanita ({{ number_format($popStats->female) }})</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ─── IDM TREND SECTION ─────────────────────────────────── --}}
    @if ($idmStats->count() > 1)
        <div class="overflow-hidden rounded-2xl border border-gray-150 bg-white shadow-sm mb-8">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50/50 to-white">
                <div>
                    <h3 class="font-extrabold text-gray-900 text-base">Tren Perkembangan IDM</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Visualisasi tren skor Indeks Desa Membangun (IDM) per tahun</p>
                </div>
                <div class="h-8 w-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                    <span class="material-symbols-outlined text-lg">trending_up</span>
                </div>
            </div>
            <div class="p-5">
                <div class="relative w-full h-64">
                    <canvas id="idmChart"></canvas>
                </div>
            </div>
        </div>
    @endif

    {{-- ─── RECENT ACTIVITY TIMELINE ─────────────────────────────────── --}}
    <div class="overflow-hidden rounded-2xl border border-gray-150 bg-white shadow-sm mb-6">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50/50 to-white">
            <div>
                <h3 class="font-extrabold text-gray-900 text-base">Log Aktivitas Sistem</h3>
                <p class="text-xs text-gray-400 mt-0.5">Catatan riwayat interaksi user & perubahan data</p>
            </div>
            <a href="{{ route('admin.activity-log') }}" wire:navigate class="text-xs font-bold text-desa-600 hover:text-desa-700 flex items-center gap-1">
                Lihat Semua
                <span class="material-symbols-outlined text-xs">arrow_forward</span>
            </a>
        </div>
        @if ($recentLogs->count())
            <div class="divide-y divide-gray-100">
                @foreach ($recentLogs as $log)
                    <div class="px-5 py-4 flex items-center gap-4 hover:bg-gray-50/40 transition-colors">
                        <div
                            class="h-9 w-9 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm
                            {{ match ($log->action) {'created' => 'bg-emerald-50 text-emerald-600','updated' => 'bg-blue-50 text-blue-600','deleted' => 'bg-rose-50 text-rose-600',default => 'bg-gray-50 text-gray-600'} }}">
                            <span class="material-symbols-outlined text-base">
                                {{ match ($log->action) {'created' => 'add_circle','updated' => 'edit','deleted' => 'delete',default => 'info'} }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 tracking-tight">{{ $log->description }}</p>
                            <p class="text-xs text-gray-400 mt-1 flex items-center gap-2">
                                <span class="font-bold text-gray-600">{{ $log->user?->name ?? 'System' }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span>{{ $log->created_at->diffForHumans() }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="font-mono text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded">{{ class_basename($log->model_type) }}</span>
                            </p>
                        </div>
                        <span
                            class="badge text-[10px] font-bold uppercase tracking-wider {{ match ($log->action) {'created' => 'bg-emerald-50 text-emerald-700 border border-emerald-100','updated' => 'bg-blue-50 text-blue-700 border border-blue-100','deleted' => 'bg-rose-50 text-rose-700 border border-rose-100',default => 'bg-gray-100 text-gray-600'} }}">
                            {{ $log->action }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <div class="inline-flex h-12 w-12 rounded-2xl bg-gray-50 items-center justify-center text-gray-400 mb-3">
                    <span class="material-symbols-outlined text-2xl">history</span>
                </div>
                <p class="text-gray-400 text-sm font-semibold">Belum ada aktivitas yang tercatat</p>
            </div>
        @endif
    </div>
</div>
