<div>
    {{-- Preload LCP hero image --}}
    @if ($village?->photo)
        @push('preload')
            <link rel="preload" as="image" href="{{ Storage::url($village->photo) }}">
        @endpush
    @endif

    {{-- ─── HERO SECTION ─────────────────────────────────── --}}
    <section
        class="relative min-h-[85vh] flex items-center justify-center bg-gradient-to-br from-desa-950 via-desa-900 to-desa-950 overflow-hidden">
        {{-- Background Image with Glassmorphism Overlay --}}
        @if ($village?->photo)
            <img src="{{ Storage::url($village->photo) }}" alt="{{ $village->name }}"
                class="absolute inset-0 w-full h-full object-cover opacity-55 scale-105" fetchpriority="high">
            {{-- Gradient overlay: darker on the left and bottom for text legibility, clear on the right --}}
            <div class="absolute inset-0 bg-gradient-to-r from-desa-950 via-desa-950/60 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-desa-950/90 via-transparent to-transparent"></div>
        @else
            <div class="absolute inset-0 opacity-10">
                <div
                    class="absolute top-0 left-0 w-[500px] h-[500px] bg-amber-500/20 rounded-full filter blur-3xl -translate-x-1/2 -translate-y-1/2">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-desa-500/20 rounded-full filter blur-3xl translate-x-1/2 translate-y-1/2">
                </div>
            </div>
        @endif

        {{-- Glowing Grid Pattern --}}
        <div
            class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff03_1px,transparent_1px),linear-gradient(to_bottom,#ffffff03_1px,transparent_1px)] bg-[size:4rem_4rem]">
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24 md:py-32 w-full z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 text-center lg:text-left">
                    <div data-aos="fade-down" data-aos-delay="100"
                        class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/15 backdrop-blur-md px-4 py-1.5 text-xs md:text-sm text-amber-300 mb-6 shadow-inner">
                        <span class="material-symbols-outlined text-sm md:text-base animate-pulse">location_city</span>
                        Portal Resmi Pemerintah Desa
                    </div>
                    <h1 data-aos="fade-right" data-aos-delay="200"
                        class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight drop-shadow-sm">
                        {{ $village?->name ?? 'Nagari Duo Koto' }}
                    </h1>
                    <p data-aos="fade-right" data-aos-delay="300"
                        class="mt-4 text-base md:text-lg lg:text-xl text-desa-100/90 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-light">
                        {{ $village?->tagline ?? 'Membangun desa maju, sejahtera, dan berbudaya' }}
                    </p>
                    @if ($village?->address)
                        <div
                            class="mt-4 flex items-center justify-center lg:justify-start gap-2 text-xs md:text-sm text-desa-200/80">
                            <span class="material-symbols-outlined text-base">location_on</span>
                            <span>{{ $village->district }}, {{ $village->regency }}, {{ $village->province }}</span>
                        </div>
                    @endif
                    <div data-aos="fade-up" data-aos-delay="400"
                        class="mt-8 flex flex-wrap justify-center lg:justify-start gap-4">
                        <a href="{{ route('profil-desa') }}" wire:navigate
                            class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold px-6 py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-amber-500/20 hover:shadow-xl hover:-translate-y-0.5">
                            <span class="material-symbols-outlined text-lg">info</span>
                            Profil Desa
                        </a>
                        <a href="{{ route('surat.info') }}" wire:navigate
                            class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold px-6 py-3.5 rounded-xl transition-all duration-300 shadow-md backdrop-blur-md hover:-translate-y-0.5">
                            <span class="material-symbols-outlined text-lg">mail</span>
                            Layanan Surat Online
                        </a>
                    </div>
                </div>

                {{-- Kepala Desa Card --}}
                @if ($kepala)
                    <div data-aos="fade-left" data-aos-delay="500"
                        class="lg:col-span-5 hidden lg:flex justify-center xl:justify-end">
                        <div
                            class="bg-white/10 backdrop-blur-xl rounded-3xl p-6 border border-white/20 text-center max-w-sm w-full shadow-2xl relative overflow-hidden group">
                            {{-- Card Glow Effect --}}
                            <div
                                class="absolute -top-12 -left-12 w-24 h-24 bg-amber-400/20 rounded-full filter blur-xl group-hover:scale-150 transition-all duration-700">
                            </div>

                            <div
                                class="mx-auto h-36 w-36 rounded-2xl bg-white/10 overflow-hidden mb-5 ring-4 ring-white/30 shadow-lg transition-transform duration-500 group-hover:scale-105">
                                @if ($kepala->photo)
                                    <img src="{{ Storage::url($kepala->photo) }}" alt="{{ $kepala->name }}"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-desa-800">
                                        <span class="material-symbols-outlined text-6xl text-white/50">person</span>
                                    </div>
                                @endif
                            </div>
                            <span
                                class="text-[10px] uppercase tracking-widest text-amber-400 font-bold bg-amber-400/10 px-3 py-1 rounded-full border border-amber-300">Kepala
                                Desa</span>
                            <h3 class="font-extrabold text-white text-xl mt-3 tracking-wide">{{ $kepala->name }}</h3>
                            <p class="text-desa-200 text-sm font-medium mt-1">{{ $kepala->position }}</p>

                            <div class="mt-6 pt-5 border-t border-white/10">
                                <a href="{{ route('pemerintahan') }}" wire:navigate
                                    class="inline-flex items-center gap-1.5 text-xs text-white/70 hover:text-white transition-colors duration-300 font-semibold group-hover:gap-2">
                                    Lihat Struktur Pemerintahan
                                    <span
                                        class="material-symbols-outlined text-sm transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ─── STATS BAR ────────────────────────────────────── --}}
    @if ($latestStats)
        <section class="relative -mt-12 z-20 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div
                class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-white/95 backdrop-blur-md rounded-3xl p-4 md:p-6 shadow-2xl border border-gray-150/50">
                @foreach ([['icon' => 'groups', 'value' => number_format($latestStats->total_population), 'label' => 'Jumlah Penduduk', 'color' => 'text-blue-600 bg-blue-50'], ['icon' => 'family_restroom', 'value' => number_format($latestStats->total_families), 'label' => 'Kepala Keluarga', 'color' => 'text-emerald-600 bg-emerald-50'], ['icon' => 'landscape', 'value' => ($village?->area_ha ?? '-') . ' Ha', 'label' => 'Luas Wilayah', 'color' => 'text-amber-600 bg-amber-50'], ['icon' => 'calendar_month', 'value' => $village?->established_year ?? '-', 'label' => 'Tahun Berdiri', 'color' => 'text-indigo-600 bg-indigo-50']] as $stat)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                        class="flex flex-col items-center justify-center p-4 hover:bg-gray-50/80 rounded-2xl transition-all duration-300 group hover:-translate-y-1">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl {{ $stat['color'] }} mb-3 group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-2xl font-bold">{{ $stat['icon'] }}</span>
                        </div>
                        <span class="text-xl md:text-2xl font-extrabold text-gray-900">{{ $stat['value'] }}</span>
                        <span class="text-xs text-gray-400 font-medium text-center mt-1">{{ $stat['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ─── PORTAL LAYANAN UTAMA (8-GRID HUB) ───────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Portal Layanan & Informasi</h2>
            <p class="section-subtitle mt-2">Akses terpadu pelayanan administrasi dan informasi Nagari</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @foreach ([
        [
            'route' => 'surat.info',
            'icon' => 'mail',
            'label' => 'Layanan Surat',
            'desc' => 'Ajukan surat keterangan mandiri',
            'color' => 'from-teal-500 to-emerald-600 shadow-teal-500/20 text-teal-600 hover:border-teal-300',
        ],
        [
            'route' => 'ppid.home',
            'icon' => 'policy',
            'label' => 'PPID Nagari',
            'desc' => 'Informasi publik & permohonan',
            'color' => 'from-indigo-500 to-blue-600 shadow-indigo-500/20 text-indigo-600 hover:border-indigo-300',
        ],
        [
            'route' => 'donasi',
            'icon' => 'volunteer_activism',
            'label' => 'Donasi Warga',
            'desc' => 'Penyaluran bantuan kemanusiaan',
            'color' => 'from-rose-500 to-pink-600 shadow-rose-500/20 text-rose-600 hover:border-rose-300',
        ],
        [
            'route' => 'umkm',
            'icon' => 'storefront',
            'label' => 'UMKM & Produk',
            'desc' => 'Katalog usaha lokal masyarakat',
            'color' => 'from-amber-500 to-orange-600 shadow-amber-500/20 text-amber-600 hover:border-amber-300',
        ],
        [
            'route' => 'kehutanan',
            'icon' => 'forest',
            'label' => 'Hutan Nagari',
            'desc' => 'Data & status kawasan hutan',
            'color' => 'from-green-500 to-emerald-600 shadow-green-500/20 text-green-600 hover:border-green-300',
        ],
        [
            'route' => 'bamus',
            'icon' => 'groups',
            'label' => 'Lembaga Bamus',
            'desc' => 'Aspirasi Badan Musyawarah',
            'color' => 'from-cyan-500 to-blue-600 shadow-cyan-500/20 text-cyan-600 hover:border-cyan-300',
        ],
        [
            'route' => 'anggaran',
            'icon' => 'account_balance_wallet',
            'label' => 'Anggaran Desa',
            'desc' => 'APBDes & realisasi anggaran',
            'color' => 'from-violet-500 to-purple-600 shadow-violet-500/20 text-violet-600 hover:border-violet-300',
        ],
        [
            'route' => 'bansos',
            'icon' => 'health_and_safety',
            'label' => 'Cek Bansos',
            'desc' => 'Cek status bantuan sosial',
            'color' => 'from-sky-500 to-blue-600 shadow-sky-500/20 text-sky-600 hover:border-sky-300',
        ],
    ] as $svc)
                <a href="{{ route($svc['route']) }}" wire:navigate data-aos="zoom-in"
                    data-aos-delay="{{ $loop->index * 50 }}"
                    class="card p-6 flex flex-col items-center text-center hover:-translate-y-1.5 transition-all duration-300 border border-gray-100 hover:shadow-xl group {{ $svc['color'] }}">

                    {{-- Styled Icon Container --}}
                    <div
                        class="h-14 w-14 rounded-2xl bg-gradient-to-br {{ $svc['color'] }} flex items-center justify-center shadow-lg transition-transform duration-300 group-hover:scale-110 mb-4">
                        <span
                            class="material-symbols-outlined text-white text-2xl font-semibold">{{ $svc['icon'] }}</span>
                    </div>

                    <h3
                        class="font-bold text-gray-900 text-sm group-hover:text-desa-600 transition-colors duration-200">
                        {{ $svc['label'] }}</h3>
                    <p class="text-xs text-gray-400 mt-2 leading-relaxed flex-1">{{ $svc['desc'] }}</p>

                    <span
                        class="material-symbols-outlined text-sm font-semibold text-desa-600 mt-4 opacity-0 transform translate-x-[-4px] group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">arrow_forward</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ─── BERITA TERBARU ───────────────────────────────── --}}
    <section class="bg-gray-50/60 py-20 border-y border-gray-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10" data-aos="fade-up">
                <div>
                    <span class="text-xs uppercase tracking-widest text-desa-600 font-bold">Kabar Nagari</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 mt-1">Berita Terbaru</h2>
                </div>
                <a href="{{ route('berita.index') }}" wire:navigate
                    class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 border border-desa-500 hover:bg-desa-50 text-desa-600 rounded-xl text-xs font-semibold transition-all">
                    Lihat Semua <span class="material-symbols-outlined text-sm font-bold">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($latestPosts as $post)
                    <a href="{{ route('berita.show', $post->slug) }}" wire:navigate data-aos="fade-up"
                        data-aos-delay="{{ $loop->index * 150 }}"
                        class="card group flex flex-col hover:-translate-y-1 transition-all duration-300 bg-white border border-gray-150/40 hover:shadow-xl">
                        <div class="aspect-[16/10] bg-gray-100 overflow-hidden relative">
                            @if ($post->thumbnail)
                                <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy" decoding="async">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-desa-50">
                                    <span class="material-symbols-outlined text-4xl text-desa-300">newspaper</span>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span
                                    class="bg-white/90 backdrop-blur-md text-desa-800 font-semibold px-2.5 py-1 rounded-lg text-[10px] shadow-sm border border-white/20 uppercase tracking-wider">{{ $post->category?->name ?? 'Umum' }}</span>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3
                                class="font-bold text-gray-900 group-hover:text-desa-600 transition-colors leading-snug line-clamp-2">
                                {{ $post->title }}
                            </h3>
                            <p class="mt-2 text-xs text-gray-500 line-clamp-2 leading-relaxed flex-1">
                                {{ $post->excerpt }}</p>

                            <div
                                class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                                    {{ $post->published_at?->translatedFormat('d M Y') }}
                                </span>
                                <span class="flex items-center gap-1 font-semibold text-desa-600">
                                    Baca Selengkapnya
                                    <span class="material-symbols-outlined text-sm font-bold">arrow_forward</span>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 card p-12 text-center">
                        <span class="material-symbols-outlined text-5xl text-gray-200 mb-3">newspaper</span>
                        <p class="text-gray-400">Belum ada berita terpublikasi.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 text-center sm:hidden">
                <a href="{{ route('berita.index') }}" wire:navigate
                    class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 border border-desa-500 text-desa-600 rounded-xl text-xs font-semibold">
                    Lihat Semua Berita <span class="material-symbols-outlined text-sm font-bold">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── IDM HIGHLIGHT ─────────────────────────────────── --}}
    @if ($idm)
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
            <div data-aos="fade-up" class="card overflow-hidden border border-gray-100 shadow-lg">
                <div class="grid grid-cols-1 lg:grid-cols-12">
                    <div class="lg:col-span-7 p-8 md:p-10 flex flex-col justify-center bg-white">
                        <span
                            class="badge bg-desa-100 text-desa-800 font-semibold mb-3 self-start border border-desa-200">IDM
                            TAHUN {{ $idm->year }}</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Indeks Desa
                            Membangun (IDM)</h2>
                        <p class="text-sm text-gray-500 mt-2 mb-6 leading-relaxed">Pengukuran tingkat kemajuan nagari
                            berdasarkan dimensi sosial, ekonomi, dan lingkungan ekologi dari Kemendesa RI.</p>

                        <div class="flex items-baseline gap-3 mb-8">
                            <span
                                class="text-5xl font-black text-desa-600 tracking-tight">{{ number_format($idm->score, 4) }}</span>
                            <span
                                class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $idm->status_color }}">{{ $idm->status_label }}</span>
                        </div>

                        <div class="grid grid-cols-3 gap-4 mb-8">
                            @foreach ([['label' => 'IKS', 'full' => 'Sosial', 'score' => $idm->social_score, 'bg' => 'bg-blue-600', 'color' => 'bg-blue-500'], ['label' => 'IKE', 'full' => 'Ekonomi', 'score' => $idm->economic_score, 'bg' => 'bg-amber-600', 'color' => 'bg-amber-500'], ['label' => 'IKL', 'full' => 'Lingkungan', 'score' => $idm->environment_score, 'bg' => 'bg-emerald-600', 'color' => 'bg-emerald-500']] as $dim)
                                <div class="bg-gray-50/50 rounded-xl p-3 border border-gray-100">
                                    <p class="text-base md:text-lg font-bold text-gray-900">
                                        {{ number_format($dim['score'], 4) }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">{{ $dim['label'] }}
                                        · {{ $dim['full'] }}</p>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                        <div class="{{ $dim['color'] }} h-1.5 rounded-full"
                                            style="width: {{ $dim['score'] * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('idm') }}" wire:navigate
                            class="inline-flex items-center gap-1.5 text-xs text-desa-600 hover:text-desa-700 font-semibold self-start hover:underline">
                            Selengkapnya tentang IDM Nagari <span
                                class="material-symbols-outlined text-sm font-bold">arrow_forward</span>
                        </a>
                    </div>

                    <div
                        class="lg:col-span-5 bg-gradient-to-br from-desa-600 to-desa-800 p-8 md:p-10 flex flex-col justify-center text-center text-white relative">
                        {{-- Background Accent Glow --}}
                        <div
                            class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,#ffffff10_0%,transparent_60%)]">
                        </div>
                        <span class="material-symbols-outlined text-6xl mb-4 text-amber-300">trending_up</span>
                        <h3 class="text-xs uppercase tracking-widest text-desa-200 font-bold">Status Pencapaian</h3>
                        <p class="text-4xl md:text-5xl font-black mt-2 mb-4 tracking-wide">{{ $idm->status_label }}
                        </p>
                        <p class="text-xs md:text-sm text-desa-100/90 max-w-sm mx-auto leading-relaxed">
                            @if ($idm->status === 'mandiri')
                                Nagari telah mencapai status tertinggi dalam Indeks Desa Membangun dengan pelayanan
                                publik prima.
                            @elseif($idm->status === 'maju')
                                Nagari Koto terus meningkatkan kualitas sarana ekonomi dan sosial menuju kemandirian
                                penuh.
                            @elseif($idm->status === 'berkembang')
                                Nagari sedang melakukan akselerasi berbagai program pembangunan infrastruktur dasar.
                            @else
                                Nagari memerlukan perhatian serta kemitraan lintas jajaran untuk peningkatan
                                kesejahteraan warga.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ─── AGENDA KEGIATAN & PENGUMUMAN ──────────────────── --}}
    <section class="bg-desa-50/40 py-20 border-y border-desa-100/60">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10" data-aos="fade-up">
                <div>
                    <span class="text-xs uppercase tracking-widest text-desa-600 font-bold">Aktivitas Bersama</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 mt-1">Agenda & Kegiatan</h2>
                </div>
                <a href="{{ route('agenda') }}" wire:navigate
                    class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 border border-desa-500 hover:bg-desa-50 text-desa-600 rounded-xl text-xs font-semibold transition-all">
                    Semua Kegiatan
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($upcomingAgendas as $agenda)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                        class="card bg-white border border-gray-150/40 hover:-translate-y-1 transition-all duration-300 hover:shadow-lg flex flex-col">
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex-shrink-0 flex flex-col items-center rounded-xl bg-gradient-to-b from-desa-500 to-desa-600 text-white px-3 py-2.5 min-w-[64px] shadow-md shadow-desa-500/10">
                                        <span
                                            class="text-2xl font-bold leading-none">{{ $agenda->start_date->format('d') }}</span>
                                        <span
                                            class="text-[10px] uppercase font-bold tracking-wider mt-1">{{ $agenda->start_date->translatedFormat('M') }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 leading-snug line-clamp-2">
                                            {{ $agenda->title }}</h3>
                                        @if ($agenda->location)
                                            <p class="mt-2 flex items-center gap-1 text-xs text-gray-500">
                                                <span
                                                    class="material-symbols-outlined text-sm text-gray-400">location_on</span>
                                                {{ $agenda->location }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400">
                                <span class="flex items-center gap-1 font-semibold text-gray-500">
                                    <span class="material-symbols-outlined text-sm">schedule</span>
                                    {{ $agenda->start_date->translatedFormat('l, d F Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 card p-12 text-center bg-white border border-gray-100">
                        <span class="material-symbols-outlined text-5xl text-gray-200 mb-3">event</span>
                        <p class="text-gray-400">Belum ada agenda kegiatan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ─── POTENSI DESA ─────────────────────────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
        <div class="flex items-end justify-between mb-10" data-aos="fade-up">
            <div>
                <span class="text-xs uppercase tracking-widest text-desa-600 font-bold">Kekayaan Lokal</span>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-1">Potensi Desa</h2>
            </div>
            <a href="{{ route('potensi') }}" wire:navigate
                class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 border border-desa-500 hover:bg-desa-50 text-desa-600 rounded-xl text-xs font-semibold transition-all">
                Lihat Semua
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($potentials as $p)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                    class="card group overflow-hidden hover:-translate-y-1.5 transition-all duration-300 relative aspect-[3/4] rounded-2xl border border-gray-100 bg-desa-950 shadow-md">
                    @if ($p->thumbnail)
                        <img src="{{ Storage::url($p->thumbnail) }}" alt="{{ $p->title }}"
                            class="absolute inset-0 w-full h-full object-cover opacity-85 group-hover:scale-105 transition-transform duration-500"
                            loading="lazy" decoding="async">
                    @endif
                    {{-- Bottom Fade Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/35 to-transparent"></div>

                    {{-- Content --}}
                    <div class="absolute inset-0 p-5 flex flex-col justify-end">
                        <span
                            class="bg-amber-400/20 text-amber-300 font-semibold px-2 py-0.5 rounded-md text-[9px] uppercase tracking-wider self-start border border-amber-400/30 mb-2">{{ $p->category }}</span>
                        <h3 class="font-bold text-white text-base leading-snug drop-shadow-md">{{ $p->title }}
                        </h3>
                    </div>
                </div>
            @empty
                <div class="col-span-4 card p-12 text-center">
                    <span class="material-symbols-outlined text-5xl text-gray-200 mb-3">eco</span>
                    <p class="text-gray-400">Belum ada data potensi desa.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ─── UMKM & PRODUK DESA ───────────────────────────── --}}
    <section
        class="bg-gradient-to-br from-amber-50/50 via-orange-50/20 to-amber-50/40 py-20 border-t border-orange-100/50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10" data-aos="fade-up">
                <div>
                    <span class="text-xs uppercase tracking-widest text-amber-700 font-bold">Ekonomi Mandiri</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 mt-1">UMKM & Produk Desa</h2>
                </div>
                <a href="{{ route('umkm') }}" wire:navigate
                    class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 border border-desa-500 hover:bg-desa-50 text-desa-600 rounded-xl text-xs font-semibold transition-all">
                    Lihat Semua
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                        class="card bg-white border border-orange-100 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <div class="p-5 flex gap-4">
                            <div
                                class="flex-shrink-0 h-20 w-20 rounded-2xl bg-gray-50 border border-gray-100 overflow-hidden shadow-inner">
                                @if ($product->photo)
                                    <img src="{{ Storage::url($product->photo) }}"
                                        alt="{{ $product->business_name }}" class="h-full w-full object-cover"
                                        loading="lazy" decoding="async">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-amber-50/50">
                                        <span
                                            class="material-symbols-outlined text-amber-500 text-3xl">storefront</span>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-base truncate">
                                        {{ $product->business_name }}</h3>
                                    <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs text-gray-400">person</span>
                                        {{ $product->owner_name }}
                                    </p>
                                </div>
                                @if ($product->whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->whatsapp) }}"
                                        target="_blank" rel="noopener"
                                        class="inline-flex items-center gap-1.5 bg-green-500 hover:bg-green-600 text-white font-bold px-3 py-1.5 rounded-lg text-xs self-start transition-colors shadow-md shadow-green-500/10">
                                        <span class="material-symbols-outlined text-xs font-bold">chat</span>
                                        Hubungi WhatsApp
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 card p-12 text-center bg-white border border-orange-100">
                        <span class="material-symbols-outlined text-5xl text-gray-200 mb-3">storefront</span>
                        <p class="text-gray-400">Belum ada data UMKM.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ─── PETA LOKASI & DETAIL KONTAK ─────────────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Map Card --}}
            <div data-aos="fade-right" class="lg:col-span-7 card overflow-hidden border border-gray-100 shadow-md">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2 text-base">
                        <span class="material-symbols-outlined text-desa-500">map</span>
                        Peta Wilayah Nagari
                    </h3>
                </div>
                <div class="aspect-[16/9] w-full bg-gray-50">
                    @if ($village?->map_embed_url)
                        <iframe src="{{ $village->map_embed_url }}" class="w-full h-full border-0" loading="lazy"
                            allowfullscreen></iframe>
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-5xl text-gray-300 animate-pulse">map</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quick Info Card --}}
            <div class="lg:col-span-5 space-y-6">
                <div data-aos="fade-left" data-aos-delay="100"
                    class="card p-6 border border-gray-100 shadow-md bg-white">
                    <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2 text-base">
                        <span class="material-symbols-outlined text-desa-500">info</span>
                        Informasi Geografis & Kantor
                    </h3>
                    <div class="space-y-4">
                        @foreach ([['icon' => 'location_on', 'label' => 'Alamat Kantor', 'value' => $village?->address ?? '-'], ['icon' => 'domain', 'label' => 'Kecamatan', 'value' => $village?->district ?? '-'], ['icon' => 'apartment', 'label' => 'Kabupaten', 'value' => $village?->regency ?? '-'], ['icon' => 'public', 'label' => 'Provinsi', 'value' => $village?->province ?? '-'], ['icon' => 'tag', 'label' => 'Kode Desa/Nagari', 'value' => $village?->village_code ?? '-']] as $info)
                            <div class="flex items-start gap-3.5 text-xs md:text-sm">
                                <div
                                    class="h-8 w-8 rounded-lg bg-desa-50 flex items-center justify-center flex-shrink-0 text-desa-600">
                                    <span class="material-symbols-outlined text-base">{{ $info['icon'] }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p
                                        class="text-[10px] text-gray-400 font-bold uppercase tracking-wider leading-none">
                                        {{ $info['label'] }}</p>
                                    <p class="font-semibold text-gray-800 mt-1.5 leading-relaxed">{{ $info['value'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Hubungi Kami Banner --}}
                <a href="{{ route('kontak') }}" wire:navigate
                    class="card p-6 flex items-center gap-4 group hover:-translate-y-1 hover:shadow-xl transition-all duration-300 border border-gray-100 shadow-md bg-white">
                    <div
                        class="h-12 w-12 rounded-xl bg-desa-50 flex items-center justify-center group-hover:bg-desa-500 transition-colors duration-300 shadow-inner">
                        <span
                            class="material-symbols-outlined text-desa-600 group-hover:text-white transition-colors duration-300">chat</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 text-sm">Layanan Kontak & Aspirasi</h3>
                        <p class="text-[11px] text-gray-400 leading-normal mt-0.5">Kirim aspirasi atau keluhan resmi ke
                            Pemerintah Desa</p>
                    </div>
                    <span
                        class="material-symbols-outlined text-gray-300 group-hover:text-desa-600 transition-colors ml-auto">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
</div>
