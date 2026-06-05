<div>
    {{-- Preload LCP hero image --}}
    @if ($village?->photo)
        @push('preload')
            <link rel="preload" as="image" href="{{ Storage::url($village->photo) }}">
        @endpush
    @endif

    {{-- ─── HERO SECTION ─────────────────────────────────── --}}
    <section
        class="relative min-h-[90vh] flex items-center justify-center bg-gradient-to-br from-desa-950 via-desa-900 to-desa-950 overflow-hidden">
        {{-- Background Image with Glassmorphism Overlay --}}
        @if ($village?->photo)
            <img src="{{ Storage::url($village->photo) }}" alt="{{ $village->name }}"
                class="absolute inset-0 w-full h-full object-cover opacity-35 scale-100 transition-all duration-[20s] ease-out hover:scale-105" fetchpriority="high">
            <div class="absolute inset-0 bg-gradient-to-r from-desa-950/95 via-desa-950/75 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-desa-950 via-transparent to-transparent"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,_var(--tw-gradient-stops))] from-amber-500/10 via-transparent to-transparent"></div>
        @else
            <div class="absolute inset-0 opacity-20">
                <div
                    class="absolute top-0 left-0 w-[600px] h-[600px] bg-amber-500/20 rounded-full filter blur-3xl -translate-x-1/3 -translate-y-1/3">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-desa-500/20 rounded-full filter blur-3xl translate-x-1/3 translate-y-1/3">
                </div>
            </div>
        @endif

        {{-- Glowing Grid Pattern --}}
        <div
            class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff02_1px,transparent_1px),linear-gradient(to_bottom,#ffffff02_1px,transparent_1px)] bg-[size:3.5rem_3.5rem] opacity-70">
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-28 md:py-36 w-full z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 text-center lg:text-left">
                    <div data-aos="fade-down" data-aos-delay="100"
                        class="inline-flex items-center gap-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-md px-4 py-1.5 text-xs md:text-sm text-amber-300 mb-6 shadow-inner tracking-wide">
                        <span class="material-symbols-outlined text-sm md:text-base text-amber-400 animate-pulse">location_city</span>
                        Portal Resmi Pemerintahan Desa
                    </div>
                    <h1 data-aos="fade-right" data-aos-delay="200"
                        class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-extrabold leading-tight tracking-tight text-white drop-shadow-md">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-white via-white to-amber-200">
                            {{ $village?->name ?? 'Nagari Duo Koto' }}
                        </span>
                    </h1>
                    <p data-aos="fade-right" data-aos-delay="300"
                        class="mt-6 text-base md:text-lg lg:text-xl text-desa-100/90 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-light">
                        {{ $village?->tagline ?? 'Membangun desa maju, sejahtera, dan berbudaya dengan keterbukaan informasi.' }}
                    </p>
                    @if ($village?->address)
                        <div
                            class="mt-6 flex items-center justify-center lg:justify-start gap-2 text-xs md:text-sm text-desa-300/80 font-medium">
                            <span class="material-symbols-outlined text-base text-amber-400">location_on</span>
                            <span>Kecamatan {{ $village->district }}, Kabupaten {{ $village->regency }}, {{ $village->province }}</span>
                        </div>
                    @endif
                    <div data-aos="fade-up" data-aos-delay="400"
                        class="mt-10 flex flex-wrap justify-center lg:justify-start gap-4">
                        <a href="{{ route('profil-desa') }}" wire:navigate
                            class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold px-6 py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-amber-500/25 hover:shadow-xl hover:shadow-amber-500/35 hover:-translate-y-0.5 active:translate-y-0 active:scale-95 group">
                            <span class="material-symbols-outlined text-lg transition-transform group-hover:rotate-12">info</span>
                            Profil Desa
                        </a>
                        <a href="{{ route('surat.info') }}" wire:navigate
                            class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/30 text-white font-semibold px-6 py-3.5 rounded-xl transition-all duration-300 shadow-md backdrop-blur-md hover:-translate-y-0.5 active:translate-y-0 active:scale-95 group">
                            <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-0.5">mail</span>
                            Layanan Surat Online
                        </a>
                    </div>
                </div>

                {{-- Kepala Desa Card --}}
                @if ($kepala)
                    <div data-aos="fade-left" data-aos-delay="500"
                        class="lg:col-span-5 hidden lg:flex justify-center xl:justify-end">
                        <div
                            class="bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 text-center max-w-sm w-full shadow-2xl relative overflow-hidden group hover:border-white/25 transition-all duration-500">
                            {{-- Card Glow Effect --}}
                            <div
                                class="absolute -top-12 -left-12 w-28 h-28 bg-amber-400/10 rounded-full filter blur-2xl group-hover:bg-amber-400/20 group-hover:scale-150 transition-all duration-700">
                            </div>

                            <div
                                class="mx-auto h-40 w-40 rounded-2xl bg-white/5 overflow-hidden mb-6 ring-4 ring-white/20 shadow-xl transition-all duration-500 group-hover:scale-105 group-hover:ring-amber-400/40 relative">
                                @if ($kepala->photo)
                                    <img src="{{ Storage::url($kepala->photo) }}" alt="{{ $kepala->name }}"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-desa-800">
                                        <span class="material-symbols-outlined text-6xl text-white/40">person</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                            </div>
                            <span
                                class="text-[10px] uppercase tracking-widest text-amber-300 font-bold bg-amber-400/10 px-4 py-1 rounded-full border border-amber-400/20">{{ $kepala->position ?? 'Kepala Desa' }}</span>
                            <h3 class="font-extrabold text-white text-xl mt-4 tracking-wide">{{ $kepala->name }}</h3>
                            <p class="text-desa-300 text-xs font-medium mt-1">NIP. {{ $kepala->nip ?? '-' }}</p>

                            <div class="mt-8 pt-6 border-t border-white/10">
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
        <section class="relative -mt-16 z-20 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div
                class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-white/95 backdrop-blur-xl rounded-3xl p-5 md:p-7 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.12)] border border-white">
                @foreach ([
                    ['icon' => 'groups', 'value' => number_format($latestStats->total_population), 'label' => 'Jumlah Penduduk', 'color' => 'text-blue-600 bg-gradient-to-br from-blue-500/10 to-blue-600/5 border-blue-500/10'], 
                    ['icon' => 'family_restroom', 'value' => number_format($latestStats->total_families), 'label' => 'Kepala Keluarga', 'color' => 'text-emerald-600 bg-gradient-to-br from-emerald-500/10 to-emerald-600/5 border-emerald-500/10'], 
                    ['icon' => 'landscape', 'value' => ($village?->area_ha ?? '-') . ' Ha', 'label' => 'Luas Wilayah', 'color' => 'text-amber-600 bg-gradient-to-br from-amber-500/10 to-amber-600/5 border-amber-500/10'], 
                    ['icon' => 'calendar_month', 'value' => $village?->established_year ?? '-', 'label' => 'Tahun Berdiri', 'color' => 'text-indigo-600 bg-gradient-to-br from-indigo-500/10 to-indigo-600/5 border-indigo-500/10']
                ] as $stat)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                        class="flex flex-col items-center justify-center p-4 rounded-2xl hover:bg-desa-50/30 transition-all duration-300 group hover:-translate-y-1 border border-transparent hover:border-desa-100">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $stat['color'] }} border mb-3.5 group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-2xl font-bold">{{ $stat['icon'] }}</span>
                        </div>
                        <span class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight">{{ $stat['value'] }}</span>
                        <span class="text-xs text-gray-500 font-semibold text-center mt-1.5 tracking-wide uppercase">{{ $stat['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ─── PORTAL LAYANAN UTAMA (8-GRID HUB) ───────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-xs uppercase tracking-widest text-desa-600 font-extrabold bg-desa-50 px-3 py-1 rounded-full border border-desa-100">Satu Pintu</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mt-3">Portal Layanan & Informasi</h2>
            <p class="section-subtitle mt-2 text-gray-500 max-w-xl mx-auto">Akses cepat, transparan, dan terintegrasi untuk seluruh layanan publik dan informasi resmi Nagari</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ([
                [
                    'route' => 'surat.info',
                    'icon' => 'mail',
                    'label' => 'Layanan Surat',
                    'desc' => 'Ajukan surat keterangan secara mandiri dan cepat',
                    'grad' => 'from-teal-400 to-emerald-600',
                    'shadow' => 'hover:shadow-teal-500/10',
                    'text' => 'text-teal-600',
                    'border' => 'hover:border-teal-200'
                ],
                [
                    'route' => 'ppid.home',
                    'icon' => 'policy',
                    'label' => 'PPID Nagari',
                    'desc' => 'Keterbukaan informasi publik & permohonan online',
                    'grad' => 'from-indigo-400 to-blue-600',
                    'shadow' => 'hover:shadow-indigo-500/10',
                    'text' => 'text-indigo-600',
                    'border' => 'hover:border-indigo-200'
                ],
                [
                    'route' => 'donasi',
                    'icon' => 'volunteer_activism',
                    'label' => 'Donasi Warga',
                    'desc' => 'Salurkan bantuan untuk program sosial kemanusiaan',
                    'grad' => 'from-rose-400 to-pink-600',
                    'shadow' => 'hover:shadow-rose-500/10',
                    'text' => 'text-rose-600',
                    'border' => 'hover:border-rose-200'
                ],
                [
                    'route' => 'umkm',
                    'icon' => 'storefront',
                    'label' => 'UMKM & Produk',
                    'desc' => 'Jelajahi produk unggulan dari pelaku usaha lokal',
                    'grad' => 'from-amber-400 to-orange-600',
                    'shadow' => 'hover:shadow-amber-500/10',
                    'text' => 'text-amber-600',
                    'border' => 'hover:border-amber-200'
                ],
                [
                    'route' => 'kehutanan',
                    'icon' => 'forest',
                    'label' => 'Hutan Nagari',
                    'desc' => 'Informasi pengelolaan & kawasan hutan nagari',
                    'grad' => 'from-emerald-400 to-green-650',
                    'shadow' => 'hover:shadow-emerald-500/10',
                    'text' => 'text-emerald-600',
                    'border' => 'hover:border-emerald-200'
                ],
                [
                    'route' => 'bamus',
                    'icon' => 'gavel',
                    'label' => 'Lembaga Bamus',
                    'desc' => 'Aspirasi dan peran Badan Permusyawaratan Nagari',
                    'grad' => 'from-cyan-400 to-blue-600',
                    'shadow' => 'hover:shadow-cyan-500/10',
                    'text' => 'text-cyan-600',
                    'border' => 'hover:border-cyan-200'
                ],
                [
                    'route' => 'anggaran',
                    'icon' => 'account_balance_wallet',
                    'label' => 'Anggaran Desa',
                    'desc' => 'Transparansi APBDes dan laporan realisasi pembangunan',
                    'grad' => 'from-purple-400 to-indigo-600',
                    'shadow' => 'hover:shadow-purple-500/10',
                    'text' => 'text-purple-600',
                    'border' => 'hover:border-purple-200'
                ],
                [
                    'route' => 'bansos',
                    'icon' => 'health_and_safety',
                    'label' => 'Cek Bansos',
                    'desc' => 'Cek penerima bantuan sosial DTKS secara terpadu',
                    'grad' => 'from-sky-400 to-blue-650',
                    'shadow' => 'hover:shadow-sky-500/10',
                    'text' => 'text-sky-600',
                    'border' => 'hover:border-sky-200'
                ],
            ] as $svc)
                <a href="{{ route($svc['route']) }}" wire:navigate data-aos="fade-up"
                    data-aos-delay="{{ $loop->index * 75 }}"
                    class="group relative bg-white border border-gray-150/70 p-6 flex flex-col items-center text-center rounded-3xl transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl {{ $svc['shadow'] }} {{ $svc['border'] }}">
                    
                    {{-- Styled Icon Container --}}
                    <div
                        class="h-16 w-16 rounded-2xl bg-gradient-to-br {{ $svc['grad'] }} flex items-center justify-center shadow-lg transition-transform duration-300 group-hover:scale-110 mb-5">
                        <span class="material-symbols-outlined text-white text-3xl font-semibold">{{ $svc['icon'] }}</span>
                    </div>

                    <h3 class="font-extrabold text-gray-900 text-base group-hover:{{ $svc['text'] }} transition-colors duration-200">
                        {{ $svc['label'] }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2.5 leading-relaxed flex-1">{{ $svc['desc'] }}</p>

                    <div class="mt-5 flex items-center justify-center h-8 w-8 rounded-full bg-gray-50 group-hover:bg-desa-50 transition-colors">
                        <span class="material-symbols-outlined text-sm font-black {{ $svc['text'] }} opacity-70 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ─── BERITA TERBARU ───────────────────────────────── --}}
    <section class="bg-gray-50/40 py-24 border-y border-gray-150/40">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12" data-aos="fade-up">
                <div>
                    <span class="text-xs uppercase tracking-widest text-desa-600 font-extrabold bg-desa-50 px-3 py-1 rounded-full border border-desa-100">Kabar Nagari</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mt-3">Berita & Kabar Terbaru</h2>
                    <p class="text-xs md:text-sm text-gray-450 mt-1">Ikuti perkembangan kegiatan dan kabar terkini dari Nagari Duo Koto</p>
                </div>
                <a href="{{ route('berita.index') }}" wire:navigate
                    class="hidden sm:inline-flex items-center gap-1.5 px-5 py-2.5 border border-desa-500 hover:bg-desa-600 hover:text-white text-desa-600 rounded-xl text-xs font-bold transition-all duration-300 shadow-sm shadow-desa-500/5">
                    Lihat Semua <span class="material-symbols-outlined text-sm font-black">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($latestPosts as $post)
                    <a href="{{ route('berita.show', $post->slug) }}" wire:navigate data-aos="fade-up"
                        data-aos-delay="{{ $loop->index * 100 }}"
                        class="group flex flex-col bg-white border border-gray-150/60 rounded-3xl overflow-hidden hover:-translate-y-1.5 transition-all duration-300 hover:shadow-2xl hover:border-desa-200">
                        <div class="aspect-[16/10] bg-gray-50 overflow-hidden relative">
                            @if ($post->thumbnail)
                                <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700 ease-out"
                                    loading="lazy" decoding="async">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-desa-50/50">
                                    <span class="material-symbols-outlined text-5xl text-desa-300/80">newspaper</span>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-white/90 backdrop-blur-md text-desa-800 font-extrabold px-3 py-1 rounded-xl text-[10px] shadow-sm border border-white/30 uppercase tracking-widest">{{ $post->category?->name ?? 'Umum' }}</span>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h3
                                    class="font-extrabold text-gray-900 group-hover:text-desa-650 transition-colors leading-snug text-base line-clamp-2">
                                    {{ $post->title }}
                                </h3>
                                <p class="mt-2.5 text-xs text-gray-450 line-clamp-2 leading-relaxed">
                                    {{ $post->excerpt }}</p>
                            </div>

                            <div
                                class="mt-6 pt-5 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400">
                                <span class="flex items-center gap-1.5 font-medium">
                                    <span class="material-symbols-outlined text-sm opacity-80">calendar_today</span>
                                    {{ $post->published_at?->translatedFormat('d M Y') }}
                                </span>
                                <span class="flex items-center gap-1 font-bold text-desa-600 group-hover:text-desa-750 transition-colors">
                                    Baca Selengkapnya
                                    <span class="material-symbols-outlined text-sm font-black transition-transform duration-200 group-hover:translate-x-0.5">arrow_forward</span>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 bg-white border border-gray-150/60 rounded-3xl p-16 text-center shadow-sm">
                        <span class="material-symbols-outlined text-5xl text-gray-200 mb-3 block">newspaper</span>
                        <p class="text-gray-450 font-medium">Belum ada berita terpublikasi saat ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10 text-center sm:hidden">
                <a href="{{ route('berita.index') }}" wire:navigate
                    class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-3 border border-desa-500 text-desa-600 rounded-xl text-xs font-bold">
                    Lihat Semua Berita <span class="material-symbols-outlined text-sm font-black">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── IDM HIGHLIGHT ─────────────────────────────────── --}}
    @if ($idm)
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24">
            <div data-aos="fade-up" class="bg-white rounded-3xl overflow-hidden border border-gray-150/60 shadow-xl shadow-gray-100">
                <div class="grid grid-cols-1 lg:grid-cols-12">
                    <div class="lg:col-span-7 p-8 md:p-12 flex flex-col justify-center bg-white">
                        <span
                            class="badge bg-desa-50 text-desa-800 font-extrabold mb-4 self-start border border-desa-200 px-3 py-1 text-2xs uppercase tracking-widest rounded-lg">IDM
                            TAHUN {{ $idm->year }}</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight leading-tight">Indeks Desa
                            Membangun (IDM)</h2>
                        <p class="text-sm text-gray-500 mt-3 mb-8 leading-relaxed max-w-xl">Pengukuran tingkat kemajuan nagari berdasarkan tiga pilar utama pembangunan yaitu dimensi sosial, ekonomi, dan lingkungan ekologi dari Kemendesa RI.</p>

                        <div class="flex items-baseline gap-3 mb-10">
                            <span
                                class="text-5xl font-black text-desa-600 tracking-tight">{{ number_format($idm->score, 4) }}</span>
                            <span
                                class="px-4 py-1.5 rounded-xl text-[10px] font-extrabold uppercase tracking-widest border {{ $idm->status_color }}">{{ $idm->status_label }}</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                            @foreach ([
                                ['label' => 'IKS', 'full' => 'Sosial', 'score' => $idm->social_score, 'bg' => 'bg-blue-500/10 text-blue-600 border-blue-500/10', 'color' => 'bg-blue-500'], 
                                ['label' => 'IKE', 'full' => 'Ekonomi', 'score' => $idm->economic_score, 'bg' => 'bg-amber-500/10 text-amber-600 border-amber-500/10', 'color' => 'bg-amber-500'], 
                                ['label' => 'IKL', 'full' => 'Lingkungan', 'score' => $idm->environment_score, 'bg' => 'bg-emerald-500/10 text-emerald-600 border-emerald-500/10', 'color' => 'bg-emerald-500']
                            ] as $dim)
                                <div class="bg-gray-50/50 rounded-2xl p-4 border border-gray-150/40">
                                    <div class="flex items-center justify-between">
                                        <span class="text-2xs font-extrabold uppercase tracking-widest text-gray-400">{{ $dim['label'] }}</span>
                                        <span class="text-xs font-bold text-gray-700">{{ number_format($dim['score'], 4) }}</span>
                                    </div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Dimensi {{ $dim['full'] }}</p>
                                    <div class="w-full bg-gray-200/70 rounded-full h-1.5 mt-3">
                                        <div class="{{ $dim['color'] }} h-1.5 rounded-full transition-all duration-1000"
                                            style="width: {{ $dim['score'] * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('idm') }}" wire:navigate
                            class="inline-flex items-center gap-1.5 text-xs text-desa-600 hover:text-desa-700 font-bold self-start group transition-colors">
                            Selengkapnya tentang IDM Nagari 
                            <span class="material-symbols-outlined text-sm font-black transition-transform duration-200 group-hover:translate-x-0.5">arrow_forward</span>
                        </a>
                    </div>

                    <div
                        class="lg:col-span-5 bg-gradient-to-br from-desa-950 via-desa-900 to-desa-950 p-8 md:p-12 flex flex-col justify-center text-center text-white relative">
                        {{-- Background Accent Glow --}}
                        <div
                            class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,#ffffff08_0%,transparent_65%)]">
                        </div>
                        <div class="relative z-10">
                            <div class="h-16 w-16 mx-auto rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-6 shadow-inner text-amber-300">
                                <span class="material-symbols-outlined text-3xl">trending_up</span>
                            </div>
                            <span class="text-2xs uppercase tracking-widest text-desa-200/70 font-extrabold">Status Pencapaian</span>
                            <p class="text-4xl md:text-5xl font-black mt-3 mb-6 tracking-wide drop-shadow-md text-amber-300 uppercase">{{ $idm->status_label }}</p>
                            <p class="text-xs md:text-sm text-desa-100/90 max-w-sm mx-auto leading-relaxed font-light">
                                @if ($idm->status === 'mandiri')
                                    Nagari telah mencapai status tertinggi dalam Indeks Desa Membangun dengan pelayanan publik mandiri, mandiri, dan prima.
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
    <section class="bg-desa-50/20 py-24 border-y border-desa-100/40">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12" data-aos="fade-up">
                <div>
                    <span class="text-xs uppercase tracking-widest text-desa-600 font-extrabold bg-desa-50 px-3 py-1 rounded-full border border-desa-100">Aktivitas Bersama</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mt-3">Agenda & Kegiatan</h2>
                    <p class="text-xs md:text-sm text-gray-450 mt-1">Saksikan dan hadiri berbagai agenda kegiatan kemasyarakatan di Nagari</p>
                </div>
                <a href="{{ route('agenda') }}" wire:navigate
                    class="hidden sm:inline-flex items-center gap-1.5 px-5 py-2.5 border border-desa-500 hover:bg-desa-600 hover:text-white text-desa-600 rounded-xl text-xs font-bold transition-all duration-300 shadow-sm shadow-desa-500/5">
                    Semua Kegiatan <span class="material-symbols-outlined text-sm font-black">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($upcomingAgendas as $agenda)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                        class="group bg-white border border-gray-150/60 rounded-3xl p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl hover:border-desa-200">
                        <div class="flex items-start gap-5">
                            <div
                                class="flex-shrink-0 flex flex-col items-center rounded-2xl bg-gradient-to-br from-desa-550 to-desa-700 text-white px-4 py-3 min-w-[72px] shadow-lg shadow-desa-650/15">
                                <span class="text-3xl font-black leading-none tracking-tight">{{ $agenda->start_date->format('d') }}</span>
                                <span class="text-[10px] uppercase font-extrabold tracking-widest mt-1.5 opacity-90">{{ $agenda->start_date->translatedFormat('M') }}</span>
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-extrabold text-gray-900 leading-snug text-base line-clamp-2 group-hover:text-desa-650 transition-colors">
                                    {{ $agenda->title }}
                                </h3>
                                @if ($agenda->location)
                                    <p class="mt-2.5 flex items-center gap-1.5 text-xs text-gray-400">
                                        <span class="material-symbols-outlined text-sm text-desa-500">location_on</span>
                                        <span class="truncate">{{ $agenda->location }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 pt-5 border-t border-gray-100 flex items-center justify-between text-2xs text-gray-400 font-semibold uppercase tracking-wider">
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-sm text-gray-300">schedule</span>
                                {{ $agenda->start_date->translatedFormat('l, d F Y') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white border border-gray-150/60 rounded-3xl p-16 text-center shadow-sm">
                        <span class="material-symbols-outlined text-5xl text-gray-200 mb-3 block">event</span>
                        <p class="text-gray-450 font-medium">Belum ada agenda kegiatan terdekat saat ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10 text-center sm:hidden">
                <a href="{{ route('agenda') }}" wire:navigate
                    class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-3 border border-desa-500 text-desa-600 rounded-xl text-xs font-bold">
                    Semua Kegiatan <span class="material-symbols-outlined text-sm font-black">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── POTENSI DESA ─────────────────────────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24">
        <div class="flex items-end justify-between mb-12" data-aos="fade-up">
            <div>
                <span class="text-xs uppercase tracking-widest text-desa-600 font-extrabold bg-desa-50 px-3 py-1 rounded-full border border-desa-100">Kekayaan Lokal</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mt-3">Potensi Desa</h2>
                <p class="text-xs md:text-sm text-gray-450 mt-1">Eksplorasi sumber daya alam, pariwisata, dan kebudayaan lokal Nagari</p>
            </div>
            <a href="{{ route('potensi') }}" wire:navigate
                class="hidden sm:inline-flex items-center gap-1.5 px-5 py-2.5 border border-desa-500 hover:bg-desa-600 hover:text-white text-desa-600 rounded-xl text-xs font-bold transition-all duration-300 shadow-sm shadow-desa-500/5">
                Lihat Semua <span class="material-symbols-outlined text-sm font-black">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($potentials as $p)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                    class="group overflow-hidden hover:-translate-y-2 transition-all duration-500 relative aspect-[3/4] rounded-3xl border border-gray-150/50 bg-desa-950 shadow-md hover:shadow-2xl">
                    @if ($p->thumbnail)
                        <img src="{{ Storage::url($p->thumbnail) }}" alt="{{ $p->title }}"
                            class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-700 ease-out"
                            loading="lazy" decoding="async">
                    @endif
                    {{-- Bottom Fade Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>

                    {{-- Content --}}
                    <div class="absolute inset-0 p-6 flex flex-col justify-end z-10">
                        <span
                            class="bg-amber-400/20 text-amber-300 font-extrabold px-3 py-1 rounded-lg text-[9px] uppercase tracking-widest self-start border border-amber-400/30 mb-3 shadow-inner">{{ $p->category }}</span>
                        <h3 class="font-extrabold text-white text-base leading-snug drop-shadow-md group-hover:text-amber-200 transition-colors">
                            {{ $p->title }}
                        </h3>
                    </div>
                </div>
            @empty
                <div class="col-span-4 bg-white border border-gray-150/60 rounded-3xl p-16 text-center shadow-sm">
                    <span class="material-symbols-outlined text-5xl text-gray-200 mb-3 block">eco</span>
                    <p class="text-gray-450 font-medium">Belum ada data potensi desa terpublikasi.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ─── UMKM & PRODUK DESA ───────────────────────────── --}}
    <section
        class="bg-gradient-to-br from-amber-50/40 via-orange-50/10 to-amber-50/35 py-24 border-t border-orange-100/30">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12" data-aos="fade-up">
                <div>
                    <span class="text-xs uppercase tracking-widest text-amber-700 font-extrabold bg-amber-50/80 px-3 py-1 rounded-full border border-amber-100">Ekonomi Mandiri</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mt-3">UMKM & Produk Desa</h2>
                    <p class="text-xs md:text-sm text-gray-500 mt-1">Dukung usaha lokal dengan membeli produk-produk unggulan warga Nagari</p>
                </div>
                <a href="{{ route('umkm') }}" wire:navigate
                    class="hidden sm:inline-flex items-center gap-1.5 px-5 py-2.5 border border-amber-500 hover:bg-amber-600 hover:text-white text-amber-700 rounded-xl text-xs font-bold transition-all duration-300 shadow-sm shadow-amber-500/5">
                    Lihat Semua <span class="material-symbols-outlined text-sm font-black">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($products as $product)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                        class="bg-white border border-orange-100/60 rounded-3xl p-5 flex gap-4 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 hover:border-orange-200">
                        <div
                            class="flex-shrink-0 h-20 w-20 rounded-2xl bg-gray-50 border border-gray-150/60 overflow-hidden shadow-inner">
                            @if ($product->photo)
                                <img src="{{ Storage::url($product->photo) }}"
                                    alt="{{ $product->business_name }}" class="h-full w-full object-cover hover:scale-105 transition-transform duration-500"
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
                                <h3 class="font-extrabold text-gray-900 text-base truncate">
                                    {{ $product->business_name }}</h3>
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs text-gray-300">person</span>
                                    <span class="truncate">{{ $product->owner_name }}</span>
                                </p>
                            </div>
                            @if ($product->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->whatsapp) }}"
                                    target="_blank" rel="noopener"
                                    class="inline-flex items-center gap-1.5 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white font-bold px-4 py-2 rounded-xl text-2xs self-start transition-all shadow-md shadow-green-500/10 active:scale-95 group">
                                    <span class="material-symbols-outlined text-xs font-bold transition-transform group-hover:rotate-12">chat</span>
                                    Hubungi WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white border border-orange-100 rounded-3xl p-16 text-center shadow-sm">
                        <span class="material-symbols-outlined text-5xl text-gray-200 mb-3 block">storefront</span>
                        <p class="text-gray-405 font-medium">Belum ada data UMKM terpublikasi saat ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10 text-center sm:hidden">
                <a href="{{ route('umkm') }}" wire:navigate
                    class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-3 border border-amber-500 text-amber-700 rounded-xl text-xs font-bold">
                    Lihat Semua Produk <span class="material-symbols-outlined text-sm font-black">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── PETA LOKASI & DETAIL KONTAK ─────────────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Map Card --}}
            <div data-aos="fade-right" class="lg:col-span-7 bg-white rounded-3xl overflow-hidden border border-gray-150/60 shadow-xl">
                <div class="p-6 border-b border-gray-100 bg-gray-50/30">
                    <h3 class="font-extrabold text-gray-900 flex items-center gap-2.5 text-base">
                        <span class="material-symbols-outlined text-desa-500">map</span>
                        Peta Wilayah Nagari
                    </h3>
                </div>
                <div class="aspect-[16/10] w-full bg-gray-50">
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
                    class="bg-white rounded-3xl p-6 border border-gray-150/60 shadow-xl">
                    <h3 class="font-extrabold text-gray-900 mb-6 flex items-center gap-2.5 text-base">
                        <span class="material-symbols-outlined text-desa-500">info</span>
                        Informasi Geografis & Kantor
                    </h3>
                    <div class="space-y-4">
                        @foreach ([
                            ['icon' => 'location_on', 'label' => 'Alamat Kantor', 'value' => $village?->address ?? '-'], 
                            ['icon' => 'domain', 'label' => 'Kecamatan', 'value' => $village?->district ?? '-'], 
                            ['icon' => 'apartment', 'label' => 'Kabupaten', 'value' => $village?->regency ?? '-'], 
                            ['icon' => 'public', 'label' => 'Provinsi', 'value' => $village?->province ?? '-'], 
                            ['icon' => 'tag', 'label' => 'Kode Desa/Nagari', 'value' => $village?->village_code ?? '-']
                        ] as $info)
                            <div class="flex items-start gap-3.5 text-xs md:text-sm">
                                <div
                                    class="h-9 w-9 rounded-xl bg-desa-50 border border-desa-100 flex items-center justify-center flex-shrink-0 text-desa-600">
                                    <span class="material-symbols-outlined text-base">{{ $info['icon'] }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p
                                        class="text-[9px] text-gray-400 font-extrabold uppercase tracking-widest leading-none">
                                        {{ $info['label'] }}</p>
                                    <p class="font-bold text-gray-800 mt-2 leading-relaxed">{{ $info['value'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Hubungi Kami Banner --}}
                <a href="{{ route('kontak') }}" wire:navigate
                    class="bg-white rounded-3xl p-6 border border-gray-150/60 shadow-xl hover:-translate-y-1.5 hover:shadow-2xl transition-all duration-300 hover:border-desa-250 flex items-center gap-4 group">
                    <div
                        class="h-12 w-12 rounded-2xl bg-desa-50 border border-desa-100 flex items-center justify-center group-hover:bg-desa-600 group-hover:text-white transition-all duration-350 shadow-inner">
                        <span class="material-symbols-outlined text-desa-600 group-hover:text-white transition-colors duration-300">chat</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-extrabold text-gray-900 text-sm">Layanan Kontak & Aspirasi</h3>
                        <p class="text-[11px] text-gray-400 leading-normal mt-1">Kirim aspirasi atau keluhan resmi secara online ke Pemerintah Nagari</p>
                    </div>
                    <span
                        class="material-symbols-outlined text-gray-300 group-hover:text-desa-600 transition-colors ml-auto">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
</div>
