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
        {{-- Background Image with Gradient Overlay --}}
        @if ($village?->photo)
            <img src="{{ Storage::url($village->photo) }}" alt="{{ $village->name }}"
                class="absolute inset-0 w-full h-full object-cover opacity-30 scale-100 transition-all duration-[20s] ease-out hover:scale-105" fetchpriority="high">
            <div class="absolute inset-0 bg-gradient-to-r from-desa-950/95 via-desa-950/80 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-desa-950 via-transparent to-transparent"></div>
        @endif

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 md:py-28 w-full z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 rounded-lg bg-desa-900/90 border border-desa-700 px-3.5 py-1.5 text-xs text-amber-300 mb-5 font-semibold shadow-xs">
                        <span class="material-symbols-outlined text-base text-amber-400">location_city</span>
                        Portal Resmi Pemerintahan Nagari
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight text-white">
                        {{ $village?->name ?? 'Nagari Duo Koto' }}
                    </h1>
                    <p class="mt-4 text-base md:text-lg text-slate-200 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                        {{ $village?->tagline ?? 'Membangun nagari maju, sejahtera, dan berbudaya dengan keterbukaan informasi.' }}
                    </p>
                    @if ($village?->address)
                        <div class="mt-4 flex items-center justify-center lg:justify-start gap-2 text-xs md:text-sm text-slate-300 font-medium">
                            <span class="material-symbols-outlined text-base text-amber-400">location_on</span>
                            <span>Kecamatan {{ $village->district }}, Kabupaten {{ $village->regency }}, {{ $village->province }}</span>
                        </div>
                    @endif
                    <div class="mt-8 flex flex-wrap justify-center lg:justify-start gap-4">
                        <a href="{{ route('profil-nagari') }}" wire:navigate
                            class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-bold px-6 py-3 rounded-xl transition-all shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2 focus-visible:ring-offset-desa-950">
                            <span class="material-symbols-outlined text-xl">info</span>
                            Profil Nagari
                        </a>
                        <a href="{{ route('surat.info') }}" wire:navigate
                            class="inline-flex items-center gap-2 bg-desa-800/90 hover:bg-desa-700 border border-desa-600 text-white font-bold px-6 py-3 rounded-xl transition-all shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-desa-400 focus-visible:ring-offset-2 focus-visible:ring-offset-desa-950">
                            <span class="material-symbols-outlined text-xl">mail</span>
                            Layanan Surat Online
                        </a>
                    </div>
                </div>

                {{-- Wali Nagari Card --}}
                @if ($kepala)
                    <div class="lg:col-span-5 hidden lg:flex justify-center xl:justify-end">
                        <div class="bg-desa-900/90 border border-desa-700 rounded-2xl p-6 text-center max-w-sm w-full shadow-lg">
                            <div class="mx-auto h-36 w-36 rounded-xl bg-desa-800 overflow-hidden mb-5 ring-2 ring-desa-600 shadow-md relative">
                                @if ($kepala->photo)
                                    <img src="{{ Storage::url($kepala->photo) }}" alt="{{ $kepala->name }}"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-desa-800 text-desa-400">
                                        <span class="material-symbols-outlined text-5xl">person</span>
                                    </div>
                                @endif
                            </div>
                            <span class="text-xs uppercase tracking-wider text-amber-300 font-bold bg-amber-400/10 px-3 py-1 rounded-md border border-amber-400/20">{{ $kepala->position ?? 'Wali Nagari' }}</span>
                            <h3 class="font-bold text-white text-lg mt-3">{{ $kepala->name }}</h3>
                            
                            <div class="mt-6 pt-4 border-t border-desa-800">
                                <a href="{{ route('pemerintahan') }}" wire:navigate
                                    class="inline-flex items-center gap-1.5 text-xs text-slate-200 hover:text-white transition-colors font-semibold focus:outline-none focus-visible:ring-2 focus-visible:ring-desa-400 rounded-lg px-2 py-1">
                                    Lihat Struktur Pemerintahan
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ─── STATS BAR ─────────────────────────────────────── --}}
    @if ($latestStats)
        <section class="relative -mt-10 z-20 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-slate-200">
                @foreach ([
                    ['icon' => 'groups', 'value' => number_format($latestStats->total_population), 'label' => 'Jumlah Penduduk'], 
                    ['icon' => 'family_restroom', 'value' => number_format($latestStats->total_families), 'label' => 'Kepala Keluarga'], 
                    ['icon' => 'landscape', 'value' => ($village?->area_ha ?? '-') . ' Ha', 'label' => 'Luas Wilayah'], 
                    ['icon' => 'calendar_month', 'value' => $village?->established_year ?? '-', 'label' => 'Tahun Berdiri']
                ] as $stat)
                    <div class="flex flex-col items-center justify-center p-2 text-center">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-desa-100 text-desa-700 border border-desa-200 mb-3">
                            <span class="material-symbols-outlined text-2xl">{{ $stat['icon'] }}</span>
                        </div>
                        <span class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $stat['value'] }}</span>
                        <span class="text-xs text-slate-600 font-semibold mt-1.5 uppercase tracking-wider">{{ $stat['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ─── PORTAL LAYANAN UTAMA (8-GRID HUB) ───────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="text-center mb-12 md:mb-16">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-desa-50 text-desa-700 border border-desa-200">
                Satu Pintu
            </span>
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mt-3">
                Portal Layanan & Informasi
            </h2>
            <p class="mt-3 text-sm md:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Akses Cepat, Transparan, dan Terintegrasi untuk Seluruh Layanan Publik dan Informasi Resmi Nagari
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
            @foreach ([
                [
                    'route' => 'surat.info',
                    'icon' => 'mail',
                    'label' => 'Layanan Surat',
                    'desc' => 'Ajukan Surat Keterangan Secara Mandiri dan Cepat',
                    'badge' => 'bg-desa-100 text-desa-700 border-desa-200',
                ],
                [
                    'route' => 'ppid.home',
                    'icon' => 'policy',
                    'label' => 'PPID Nagari',
                    'desc' => 'Keterbukaan Informasi Publik & Permohonan Online',
                    'badge' => 'bg-blue-100 text-blue-700 border-blue-200',
                ],
                [
                    'route' => 'donasi',
                    'icon' => 'volunteer_activism',
                    'label' => 'Donasi Warga',
                    'desc' => 'Salurkan Bantuan untuk Program Sosial Kemanusiaan',
                    'badge' => 'bg-rose-100 text-rose-700 border-rose-200',
                ],
                [
                    'route' => 'umkm',
                    'icon' => 'storefront',
                    'label' => 'UMKM & Produk',
                    'desc' => 'Jelajahi Produk Unggulan dari Pelaku Usaha Lokal',
                    'badge' => 'bg-amber-100 text-amber-800 border-amber-200',
                ],
                [
                    'route' => 'kehutanan',
                    'icon' => 'forest',
                    'label' => 'Hutan Nagari',
                    'desc' => 'Informasi Pengelolaan & Kawasan Hutan Nagari',
                    'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                ],
                [
                    'route' => 'bamus',
                    'icon' => 'gavel',
                    'label' => 'Lembaga Bamus',
                    'desc' => 'Aspirasi dan Peran Badan Permusyawaratan Nagari',
                    'badge' => 'bg-slate-100 text-slate-700 border-slate-200',
                ],
                [
                    'route' => 'anggaran',
                    'icon' => 'account_balance_wallet',
                    'label' => 'Anggaran Nagari',
                    'desc' => 'Transparansi APBNag dan Realisasi Pembangunan',
                    'badge' => 'bg-purple-100 text-purple-700 border-purple-200',
                ],
                [
                    'route' => 'bansos',
                    'icon' => 'health_and_safety',
                    'label' => 'Cek Bansos',
                    'desc' => 'Cek Penerima Bantuan Sosial DTKS Secara Terpadu',
                    'badge' => 'bg-sky-100 text-sky-700 border-sky-200',
                ],
            ] as $svc)
                <a href="{{ route($svc['route']) }}" wire:navigate
                    class="group bg-white border border-slate-200 p-5 sm:p-6 flex flex-col items-center text-center rounded-2xl shadow-xs hover:shadow-md hover:border-desa-300 transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-desa-500 focus-visible:ring-offset-2">
                    
                    {{-- Icon Container --}}
                    <div class="h-14 w-14 rounded-xl border {{ $svc['badge'] }} flex items-center justify-center mb-4 transition-transform duration-200 group-hover:scale-105">
                        <span class="material-symbols-outlined text-2xl font-semibold">{{ $svc['icon'] }}</span>
                    </div>

                    <h3 class="font-bold text-slate-900 text-base group-hover:text-desa-700 transition-colors leading-snug">
                        {{ $svc['label'] }}
                    </h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed flex-1">{{ $svc['desc'] }}</p>

                    <div class="mt-4 flex items-center justify-center h-8 w-8 rounded-full bg-slate-100 text-slate-500 group-hover:bg-desa-100 group-hover:text-desa-700 transition-colors">
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ─── BERITA TERBARU ───────────────────────────────── --}}
    <section class="bg-slate-50/60 py-16 md:py-24 border-y border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10 md:mb-12">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-desa-50 text-desa-700 border border-desa-200">
                        Kabar Nagari
                    </span>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mt-3">
                        Berita & Kabar Terbaru
                    </h2>
                    <p class="text-sm md:text-base text-slate-600 mt-1.5">
                        Ikuti Perkembangan Kegiatan dan Kabar Terkini dari Nagari Duo Koto
                    </p>
                </div>
                <a href="{{ route('berita.index') }}" wire:navigate
                    class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-800 hover:border-desa-300 hover:text-desa-700 hover:bg-desa-50 text-xs font-bold shadow-xs transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-desa-500">
                    Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                @forelse($latestPosts as $post)
                    <a href="{{ route('berita.show', $post->slug) }}" wire:navigate
                        class="group flex flex-col bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs hover:shadow-md hover:border-desa-300 transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-desa-500">
                        <div class="aspect-[16/10] bg-slate-100 overflow-hidden relative border-b border-slate-100">
                            @if ($post->thumbnail)
                                <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    loading="lazy" decoding="async">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400">
                                    <span class="material-symbols-outlined text-5xl">newspaper</span>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span class="bg-white text-slate-800 font-bold px-2.5 py-1 rounded-md text-xs shadow-xs border border-slate-200 uppercase tracking-wider">
                                    {{ $post->category?->name ?? 'Umum' }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <h3 class="font-bold text-slate-900 group-hover:text-desa-700 transition-colors leading-snug text-base sm:text-lg line-clamp-2 capitalize">
                                    {{ $post->title }}
                                </h3>
                                <p class="mt-2 text-xs sm:text-sm text-slate-600 line-clamp-2 leading-relaxed">
                                    {{ $post->excerpt }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                                <span class="flex items-center gap-1.5 font-medium text-slate-500">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                                    {{ $post->published_at?->translatedFormat('d M Y') }}
                                </span>
                                <span class="flex items-center gap-1 font-bold text-desa-700 group-hover:text-desa-800 transition-colors">
                                    Baca Selengkapnya
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-xs">
                        <span class="material-symbols-outlined text-5xl text-slate-400 mb-3 block">newspaper</span>
                        <p class="text-slate-600 font-medium text-sm">Belum ada berita terpublikasi saat ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 text-center sm:hidden">
                <a href="{{ route('berita.index') }}" wire:navigate
                    class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-3 border border-slate-300 bg-white text-slate-800 rounded-xl text-xs font-bold shadow-xs">
                    Lihat Semua Berita <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── IDM HIGHLIGHT ─────────────────────────────────── --}}
    @if ($idm)
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                <div class="grid grid-cols-1 lg:grid-cols-12">
                    <div class="lg:col-span-7 p-6 sm:p-8 md:p-12 flex flex-col justify-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider bg-desa-50 text-desa-700 border border-desa-200 mb-4 self-start">
                            IDM TAHUN {{ $idm->year }}
                        </span>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                            Indeks Desa Membangun (IDM)
                        </h2>
                        <p class="text-sm md:text-base text-slate-600 mt-2 mb-6 leading-relaxed max-w-xl">
                            Pengukuran tingkat kemajuan nagari berdasarkan tiga pilar utama pembangunan yaitu dimensi sosial, ekonomi, dan lingkungan ekologi dari Kemendesa RI.
                        </p>

                        <div class="flex items-baseline gap-3 mb-8">
                            <span class="text-4xl sm:text-5xl font-extrabold text-desa-700 tracking-tight">
                                {{ $idm->formatted_score }}
                            </span>
                            <span class="px-3.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider border {{ $idm->status_color }}">
                                {{ $idm->status_label }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                            @foreach ([
                                ['label' => 'IKS', 'full' => 'Sosial', 'score' => $idm->social_score, 'color' => 'bg-blue-600'], 
                                ['label' => 'IKE', 'full' => 'Ekonomi', 'score' => $idm->economic_score, 'color' => 'bg-amber-500'], 
                                ['label' => 'IKL', 'full' => 'Lingkungan', 'score' => $idm->environment_score, 'color' => 'bg-emerald-600']
                            ] as $dim)
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold uppercase tracking-wider text-slate-900">{{ $dim['label'] }}</span>
                                        <span class="text-xs font-bold text-slate-800">{{ \App\Models\IdmStat::formatIdmScore($dim['score']) }}</span>
                                    </div>
                                    <p class="text-xs text-slate-600 font-medium mt-1">Dimensi {{ $dim['full'] }}</p>
                                    <div class="w-full bg-slate-200 rounded-full h-2 mt-3 overflow-hidden">
                                        <div class="{{ $dim['color'] }} h-full rounded-full transition-all duration-700"
                                            style="width: {{ min(100, round(((float) \App\Models\IdmStat::formatIdmScore($dim['score']) / 635) * 100, 1)) }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('idm') }}" wire:navigate
                            class="inline-flex items-center gap-1.5 text-sm text-desa-700 hover:text-desa-800 font-bold self-start group transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-desa-500 rounded-lg py-1">
                            Selengkapnya tentang IDM Nagari 
                            <span class="material-symbols-outlined text-sm transition-transform duration-200 group-hover:translate-x-0.5">arrow_forward</span>
                        </a>
                    </div>

                    <div class="lg:col-span-5 bg-gradient-to-br from-desa-900 via-desa-950 to-slate-950 p-8 md:p-12 flex flex-col justify-center text-center text-white relative">
                        <div class="relative z-10">
                            <div class="h-14 w-14 mx-auto rounded-xl bg-white/10 border border-white/20 flex items-center justify-center mb-4 text-amber-300 shadow-sm">
                                <span class="material-symbols-outlined text-3xl">trending_up</span>
                            </div>
                            <span class="text-xs uppercase tracking-widest text-slate-300 font-bold">Status Pencapaian</span>
                            <p class="text-3xl md:text-4xl font-extrabold mt-2 mb-4 tracking-wide text-amber-300 uppercase">
                                {{ $idm->status_label }}
                            </p>
                            <p class="text-sm text-slate-200 max-w-sm mx-auto leading-relaxed font-normal">
                                @if ($idm->status === 'mandiri')
                                    Nagari telah mencapai status tertinggi dalam Indeks Desa Membangun dengan pelayanan publik mandiri, berdaya saing, dan prima.
                                @elseif($idm->status === 'maju')
                                    Nagari Koto terus meningkatkan kualitas sarana ekonomi dan sosial menuju kemandirian penuh dan berdaya saing tinggi.
                                @elseif($idm->status === 'berkembang')
                                    Nagari sedang melakukan akselerasi berbagai program pembangunan infrastruktur dasar secara komprehensif.
                                @else
                                    Nagari memerlukan perhatian serta kemitraan lintas jajaran untuk peningkatan kesejahteraan masyarakat secara terpadu.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ─── AGENDA KEGIATAN & PENGUMUMAN ──────────────────── --}}
    <section class="bg-slate-50/60 py-16 md:py-24 border-y border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10 md:mb-12">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-desa-50 text-desa-700 border border-desa-200">
                        Aktivitas Bersama
                    </span>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mt-3">
                        Agenda & Kegiatan
                    </h2>
                    <p class="text-sm md:text-base text-slate-600 mt-1.5">
                        Saksikan dan Hadiri Berbagai Agenda Kegiatan Kemasyarakatan di Nagari
                    </p>
                </div>
                <a href="{{ route('agenda') }}" wire:navigate
                    class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-800 hover:border-desa-300 hover:text-desa-700 hover:bg-desa-50 text-xs font-bold shadow-xs transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-desa-500">
                    Semua Kegiatan <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                @forelse($upcomingAgendas as $agenda)
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col justify-between shadow-xs hover:shadow-md hover:border-desa-300 transition-all duration-200">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 flex flex-col items-center justify-center rounded-xl bg-desa-700 text-white px-3 py-2.5 min-w-[72px] shadow-xs">
                                <span class="text-xs uppercase font-bold tracking-wider bg-white/20 px-2 py-0.5 rounded-md mb-1">
                                    {{ $agenda->start_date->translatedFormat('l') }}
                                </span>
                                <span class="text-2xl font-extrabold leading-none tracking-tight">{{ $agenda->start_date->format('d') }}</span>
                                <span class="text-xs uppercase font-bold tracking-wider mt-1 opacity-90">
                                    {{ $agenda->start_date->translatedFormat('M Y') }}
                                </span>
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-bold text-slate-900 leading-snug text-base line-clamp-2 capitalize">
                                    {{ $agenda->title }}
                                </h3>
                                @if ($agenda->location)
                                    <p class="mt-2 flex items-center gap-1.5 text-xs sm:text-sm text-slate-600 font-medium">
                                        <span class="material-symbols-outlined text-sm text-desa-600">location_on</span>
                                        <span class="truncate">{{ $agenda->location }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600 font-medium">
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-sm text-desa-600">schedule</span>
                                {{ $agenda->start_date->translatedFormat('l, d M Y — H:i') }} WIB
                            </span>
                            @if ($agenda->start_date->isPast())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">Selesai</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">Mendatang</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-xs">
                        <span class="material-symbols-outlined text-5xl text-slate-400 mb-3 block">event</span>
                        <p class="text-slate-600 font-medium text-sm">Belum ada agenda kegiatan terdekat saat ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 text-center sm:hidden">
                <a href="{{ route('agenda') }}" wire:navigate
                    class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-3 border border-slate-300 bg-white text-slate-800 rounded-xl text-xs font-bold shadow-xs">
                    Semua Kegiatan <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── POTENSI NAGARI ───────────────────────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="flex items-end justify-between mb-10 md:mb-12">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-desa-50 text-desa-700 border border-desa-200">
                    Kekayaan Lokal
                </span>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mt-3">
                    Potensi Nagari
                </h2>
                <p class="text-sm md:text-base text-slate-600 mt-1.5">
                    Eksplorasi Sumber Daya Alam, Pariwisata, dan Kebudayaan Lokal Nagari
                </p>
            </div>
            <a href="{{ route('potensi') }}" wire:navigate
                class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-800 hover:border-desa-300 hover:text-desa-700 hover:bg-desa-50 text-xs font-bold shadow-xs transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-desa-500">
                Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            @forelse($potentials as $p)
                <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-950 shadow-xs hover:shadow-md relative aspect-[3/4] transition-all duration-300">
                    @if ($p->thumbnail)
                        <img src="{{ Storage::url($p->thumbnail) }}" alt="{{ $p->title }}"
                            class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy" decoding="async">
                    @endif
                    {{-- Bottom Fade Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>

                    {{-- Content --}}
                    <div class="absolute inset-0 p-6 flex flex-col justify-end z-10">
                        <span class="bg-amber-500 text-white font-bold px-2.5 py-1 rounded-md text-xs uppercase tracking-wider self-start mb-2.5 shadow-xs">
                            {{ $p->category }}
                        </span>
                        <h3 class="font-bold text-white text-base sm:text-lg leading-snug drop-shadow group-hover:text-amber-200 transition-colors capitalize">
                            {{ $p->title }}
                        </h3>
                    </div>
                </div>
            @empty
                <div class="col-span-4 bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-xs">
                    <span class="material-symbols-outlined text-5xl text-slate-400 mb-3 block">eco</span>
                    <p class="text-slate-600 font-medium text-sm">Belum ada data potensi nagari terpublikasi.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ─── UMKM & PRODUK DESA ───────────────────────────── --}}
    <section class="bg-amber-50/30 py-16 md:py-24 border-t border-amber-200/60">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10 md:mb-12">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-100 text-amber-900 border border-amber-200">
                        Ekonomi Mandiri
                    </span>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mt-3">
                        UMKM & Produk Nagari
                    </h2>
                    <p class="text-sm md:text-base text-slate-600 mt-1.5">
                        Dukung Usaha Lokal dengan Membeli Produk-Produk Unggulan Warga Nagari
                    </p>
                </div>
                <a href="{{ route('umkm') }}" wire:navigate
                    class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-800 hover:border-amber-300 hover:text-amber-800 hover:bg-amber-50 text-xs font-bold shadow-xs transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500">
                    Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @forelse($products as $product)
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 flex gap-4 shadow-xs hover:shadow-md hover:border-amber-300 transition-all duration-200">
                        <div class="flex-shrink-0 h-20 w-20 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden">
                            @if ($product->photo)
                                <img src="{{ Storage::url($product->photo) }}"
                                    alt="{{ $product->business_name }}" class="h-full w-full object-cover hover:scale-105 transition-transform duration-300"
                                    loading="lazy" decoding="async">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-amber-50 text-amber-600">
                                    <span class="material-symbols-outlined text-3xl">storefront</span>
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-slate-900 text-base truncate capitalize">
                                    {{ $product->business_name }}
                                </h3>
                                <p class="text-xs text-slate-600 mt-1 flex items-center gap-1 font-medium">
                                    <span class="material-symbols-outlined text-xs text-slate-400">person</span>
                                    <span class="truncate">{{ $product->owner_name }}</span>
                                </p>
                            </div>
                            @if ($product->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->whatsapp) }}"
                                    target="_blank" rel="noopener"
                                    class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3.5 py-1.5 rounded-lg text-xs self-start transition-all shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                                    <span class="material-symbols-outlined text-xs">chat</span>
                                    Hubungi WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-xs">
                        <span class="material-symbols-outlined text-5xl text-slate-400 mb-3 block">storefront</span>
                        <p class="text-slate-600 font-medium text-sm">Belum ada data UMKM terpublikasi saat ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 text-center sm:hidden">
                <a href="{{ route('umkm') }}" wire:navigate
                    class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-3 border border-slate-300 bg-white text-slate-800 rounded-xl text-xs font-bold shadow-xs">
                    Lihat Semua Produk <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── STATISTIK PENGUNJUNG WEBSITE ─────────────────────── --}}
    <livewire:public-site.visitor-counter />

    {{-- ─── PETA LOKASI & DETAIL KONTAK ─────────────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Map Card --}}
            <div class="lg:col-span-7 bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                <div class="p-5 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 flex items-center gap-2.5 text-base">
                        <span class="material-symbols-outlined text-desa-600">map</span>
                        Peta Wilayah Nagari
                    </h3>
                </div>
                <div class="aspect-[16/10] w-full bg-slate-100">
                    @if ($village?->map_embed_url)
                        <iframe src="{{ $village->map_embed_url }}" class="w-full h-full border-0" loading="lazy"
                            allowfullscreen title="Peta Wilayah Nagari"></iframe>
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                            <span class="material-symbols-outlined text-5xl">map</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quick Info Card --}}
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200 shadow-sm">
                    <h3 class="font-bold text-slate-900 mb-6 flex items-center gap-2.5 text-base border-b border-slate-200 pb-4">
                        <span class="material-symbols-outlined text-desa-600">info</span>
                        Informasi Geografis & Kantor
                    </h3>
                    <div class="space-y-4">
                        @foreach ([
                            ['icon' => 'location_on', 'label' => 'Alamat Kantor', 'value' => $village?->address ?? '-'], 
                            ['icon' => 'domain', 'label' => 'Kecamatan', 'value' => $village?->district ?? '-'], 
                            ['icon' => 'apartment', 'label' => 'Kabupaten', 'value' => $village?->regency ?? '-'], 
                            ['icon' => 'public', 'label' => 'Provinsi', 'value' => $village?->province ?? '-'], 
                            ['icon' => 'tag', 'label' => 'Kode Nagari/Desa', 'value' => $village?->village_code ?? '-']
                        ] as $info)
                            <div class="flex items-start gap-3.5">
                                <div class="h-10 w-10 rounded-xl bg-desa-100 border border-desa-200 flex items-center justify-center flex-shrink-0 text-desa-700">
                                    <span class="material-symbols-outlined text-lg">{{ $info['icon'] }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                        {{ $info['label'] }}
                                    </p>
                                    <p class="font-bold text-slate-900 mt-1 leading-relaxed text-sm md:text-base">
                                        {{ $info['value'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Hubungi Kami Banner --}}
                <a href="{{ route('kontak') }}" wire:navigate
                    class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:border-desa-300 hover:shadow-md transition-all duration-200 flex items-center gap-4 group focus:outline-none focus-visible:ring-2 focus-visible:ring-desa-500">
                    <div class="h-12 w-12 rounded-xl bg-desa-100 text-desa-700 border border-desa-200 flex items-center justify-center group-hover:bg-desa-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-xl">chat</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-900 text-base group-hover:text-desa-700 transition-colors">
                            Layanan Kontak & Aspirasi
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed mt-0.5">
                            Kirim aspirasi atau keluhan resmi secara online ke Pemerintah Nagari
                        </p>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 group-hover:text-desa-600 transition-colors">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
</div>
