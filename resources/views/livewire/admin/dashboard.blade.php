<div>
    {{-- ─── GREETING ─────────────────────────────────── --}}
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">
                    Selamat {{ now()->hour < 12 ? 'Pagi' : (now()->hour < 17 ? 'Siang' : 'Malam') }},
                    {{ auth()->user()->name }} 👋
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    {{ now()->translatedFormat('l, d F Y') }} — Berikut ringkasan data terkini
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('home') }}" target="_blank" class="btn-secondary btn-sm">
                    <span class="material-symbols-outlined text-base">open_in_new</span> Lihat Situs
                </a>
            </div>
        </div>
    </div>

    {{-- ─── STAT CARDS ─────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach ([
        [
            'icon' => 'groups',
            'label' => 'Total Penduduk',
            'value' => number_format($totalPopulation),
            'route' => 'admin.infografis',
            'bg_light' => 'bg-desa-100',
            'bg_hover' => 'group-hover:bg-desa-500',
            'text_color' => 'text-desa-600',
        ],
        [
            'icon' => 'storefront',
            'label' => 'UMKM Aktif',
            'value' => $totalUmkm,
            'route' => 'admin.umkm',
            'bg_light' => 'bg-amber-100',
            'bg_hover' => 'group-hover:bg-amber-500',
            'text_color' => 'text-amber-600',
        ],
        [
            'icon' => 'newspaper',
            'label' => 'Berita Published',
            'value' => $totalBerita,
            'route' => 'admin.berita',
            'bg_light' => 'bg-blue-100',
            'bg_hover' => 'group-hover:bg-blue-500',
            'text_color' => 'text-blue-600',
        ],
        [
            'icon' => 'mail',
            'label' => 'Surat Pending',
            'value' => $totalSuratPending,
            'route' => 'admin.surat',
            'bg_light' => 'bg-red-100',
            'bg_hover' => 'group-hover:bg-red-500',
            'text_color' => 'text-red-600',
        ],
    ] as $card)
            <a href="{{ route($card['route']) }}" wire:navigate
                class="card p-5 flex items-center gap-4 group hover:-translate-y-0.5 transition-all duration-300 hover:shadow-md">

                <div
                    class="flex-shrink-0 h-12 w-12 rounded-xl flex items-center justify-center transition-colors duration-300 {{ $card['bg_light'] }} {{ $card['bg_hover'] }}">
                    <span
                        class="material-symbols-outlined text-2xl group-hover:text-white transition-colors duration-300 {{ $card['text_color'] }}">
                        {{ $card['icon'] }}
                    </span>
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-2xl font-extrabold text-gray-900">{{ $card['value'] }}</p>
                    <p class="text-xs text-gray-500">{{ $card['label'] }}</p>
                </div>
                <span
                    class="material-symbols-outlined text-gray-300 group-hover:text-gray-400 transition-colors">arrow_forward</span>
            </a>
        @endforeach
    </div>

    {{-- ─── QUICK ACTIONS ─────────────────────────────────── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @foreach ([
        [
            'route' => 'admin.berita',
            'icon' => 'edit_note',
            'label' => 'Tulis Berita',
            'bg_light' => 'bg-desa-50',
            'bg_hover' => 'group-hover:bg-desa-500',
            'text_color' => 'text-desa-600',
        ],
        [
            'route' => 'admin.agenda',
            'icon' => 'event',
            'label' => 'Tambah Agenda',
            'bg_light' => 'bg-blue-50',
            'bg_hover' => 'group-hover:bg-blue-500',
            'text_color' => 'text-blue-600',
        ],
        [
            'route' => 'admin.umkm',
            'icon' => 'add_business',
            'label' => 'Tambah UMKM',
            'bg_light' => 'bg-amber-50',
            'bg_hover' => 'group-hover:bg-amber-500',
            'text_color' => 'text-amber-600',
        ],
        [
            'route' => 'admin.bansos',
            'icon' => 'volunteer_activism',
            'label' => 'Data Bansos',
            'bg_light' => 'bg-green-50',
            'bg_hover' => 'group-hover:bg-green-500',
            'text_color' => 'text-green-600',
        ],
    ] as $qa)
            <a href="{{ route($qa['route']) }}" wire:navigate
                class="card p-4 text-center group hover:-translate-y-0.5 transition-all duration-300">

                <!-- Panggil class utuh di sini -->
                <div
                    class="mx-auto h-10 w-10 rounded-lg flex items-center justify-center mb-2 transition-colors duration-300 {{ $qa['bg_light'] }} {{ $qa['bg_hover'] }}">
                    <span
                        class="material-symbols-outlined group-hover:text-white transition-colors duration-300 {{ $qa['text_color'] }}">
                        {{ $qa['icon'] }}
                    </span>
                </div>
                <p class="text-xs font-medium text-gray-600">{{ $qa['label'] }}</p>
            </a>
        @endforeach
    </div>

    {{-- ─── ALERT BAR ─────────────────────────────────── --}}
    @if ($totalSuratPending > 0)
        <a href="{{ route('admin.surat') }}" wire:navigate
            class="mb-8 card p-4 flex items-center gap-3 border-amber-200 bg-amber-50 hover:bg-amber-100 transition-colors group">
            <div class="h-10 w-10 rounded-lg bg-amber-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-600">warning</span>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-amber-800">{{ $totalSuratPending }} permohonan surat menunggu
                    diproses</p>
                <p class="text-xs text-amber-600">Klik untuk melihat dan memproses</p>
            </div>
            <span
                class="material-symbols-outlined text-amber-400 group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </a>
    @endif

    {{-- ─── CHARTS ─────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8" x-data x-init="$nextTick(() => {
        // Surat per month
        const suratData = @js($suratPerMonth);
        new Chart(document.getElementById('suratChart'), {
            type: 'line',
            data: {
                labels: Object.keys(suratData),
                datasets: [{
                    label: 'Permohonan Surat',
                    data: Object.values(suratData),
                    borderColor: '#2D6A4F',
                    backgroundColor: 'rgba(45,106,79,0.08)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointBackgroundColor: '#2D6A4F',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' } },
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
                    backgroundColor: ['#3b82f6', '#ec4899'],
                    borderWidth: 0,
                    borderRadius: 4,
                    spacing: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true } }
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
                    { label: 'Skor IDM', data: idmData.map(d => d.score), borderColor: '#2D6A4F', backgroundColor: 'rgba(45,106,79,0.08)', fill: true, tension: 0.4, borderWidth: 2 },
                    { label: 'IKS', data: idmData.map(d => d.social_score), borderColor: '#3b82f6', borderWidth: 1.5, tension: 0.4, borderDash: [4, 4], pointRadius: 0 },
                    { label: 'IKE', data: idmData.map(d => d.economic_score), borderColor: '#f59e0b', borderWidth: 1.5, tension: 0.4, borderDash: [4, 4], pointRadius: 0 },
                    { label: 'IKL', data: idmData.map(d => d.environment_score), borderColor: '#22c55e', borderWidth: 1.5, tension: 0.4, borderDash: [4, 4], pointRadius: 0 },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, font: { size: 11 } } } },
                scales: {
                    y: { beginAtZero: false, grid: { color: 'rgba(0,0,0,0.04)' } },
                    x: { grid: { display: false } }
                }
            }
        });
        @endif
    })">
        <div class="lg:col-span-2 card overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-900">Permohonan Surat</h3>
                    <p class="text-xs text-gray-400 mt-0.5">6 bulan terakhir</p>
                </div>
                <span class="material-symbols-outlined text-gray-300">show_chart</span>
            </div>
            <div class="p-5">
                <div class="relative w-full h-64">
                    <canvas id="suratChart"></canvas>
                </div>
            </div>
        </div>
        <div class="card overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-900">Komposisi Penduduk</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $popStats?->year ?? '-' }}</p>
                </div>
                <span class="material-symbols-outlined text-gray-300">pie_chart</span>
            </div>
            <div class="p-5">
                <div class="relative w-full h-64">
                    <canvas id="popChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── IDM TREND ─────────────────────────────────── --}}
    @if ($idmStats->count() > 1)
        <div class="card overflow-hidden mb-8">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-900">Tren Indeks Desa Membangun</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $idmStats->first()->year }} —
                        {{ $idmStats->last()->year }}</p>
                </div>
                <span class="material-symbols-outlined text-gray-300">insights</span>
            </div>
            <div class="p-5">
                <div class="relative w-full h-64">
                    <canvas id="idmChart"></canvas>
                </div>
            </div>
        </div>
    @endif


    {{-- ─── RECENT ACTIVITY ─────────────────────────────────── --}}
    <div class="card overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-gray-900">Aktivitas Terbaru</h3>
                <p class="text-xs text-gray-400 mt-0.5">10 aktivitas terakhir</p>
            </div>
            <span class="material-symbols-outlined text-gray-300">history</span>
        </div>
        @if ($recentLogs->count())
            <div class="divide-y divide-gray-50">
                @foreach ($recentLogs as $log)
                    <div class="px-5 py-3 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                        <div
                            class="h-8 w-8 rounded-lg flex items-center justify-center flex-shrink-0
                            {{ match ($log->action) {'created' => 'bg-green-50','updated' => 'bg-blue-50','deleted' => 'bg-red-50',default => 'bg-gray-50'} }}">
                            <span
                                class="material-symbols-outlined text-base
                                {{ match ($log->action) {'created' => 'text-green-500','updated' => 'text-blue-500','deleted' => 'text-red-500',default => 'text-gray-400'} }}">
                                {{ match ($log->action) {'created' => 'add_circle','updated' => 'edit','deleted' => 'delete',default => 'info'} }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-900 truncate">{{ $log->description }}</p>
                            <p class="text-xs text-gray-400">{{ $log->user?->name ?? 'System' }} ·
                                {{ $log->created_at->diffForHumans() }}</p>
                        </div>
                        <span
                            class="badge text-xs {{ match ($log->action) {'created' => 'badge-success','updated' => 'badge-info','deleted' => 'badge-danger',default => 'badge-info'} }}">
                            {{ $log->action }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <span class="material-symbols-outlined text-4xl text-gray-200 mb-2">history</span>
                <p class="text-gray-400 text-sm">Belum ada aktivitas.</p>
            </div>
        @endif
    </div>
</div>
