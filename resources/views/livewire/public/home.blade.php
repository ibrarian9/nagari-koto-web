<div>
    {{-- Preload LCP hero image --}}
    @if($village?->photo)
        @push('preload')
            <link rel="preload" as="image" href="{{ Storage::url($village->photo) }}">
        @endpush
    @endif

    {{-- ─── HERO SECTION ─────────────────────────────────── --}}
    <section class="relative bg-gradient-to-br from-desa-600 via-desa-700 to-desa-900 overflow-hidden">
        @if($village?->photo)
            <img src="{{ Storage::url($village->photo) }}" alt="{{ $village->name }}" class="absolute inset-0 w-full h-full object-cover" fetchpriority="high">
            <div class="absolute inset-0 bg-gradient-to-br from-desa-900/85 via-desa-800/80 to-desa-900/90"></div>
        @else
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-amber-400 rounded-full filter blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-desa-300 rounded-full filter blur-3xl translate-x-1/2 translate-y-1/2"></div>
                <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-white rounded-full filter blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            </div>
        @endif
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div data-aos="fade-down" data-aos-delay="100"
                        class="inline-flex items-center gap-2 rounded-full bg-white/10 backdrop-blur-sm px-4 py-1.5 text-sm text-amber-300 mb-6">
                        <span class="material-symbols-outlined text-base">location_city</span>
                        Website Resmi Pemerintah Desa
                    </div>
                    <h1 data-aos="fade-right" data-aos-delay="200" class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight">
                        {{ $village?->name ?? 'Nagari Duo Koto' }}
                    </h1>
                    <p data-aos="fade-right" data-aos-delay="300" class="mt-4 text-lg text-desa-100 max-w-lg">
                        {{ $village?->tagline ?? 'Membangun desa maju, sejahtera, dan berbudaya' }}
                    </p>
                    @if ($village?->address)
                        <p class="mt-3 flex items-center gap-2 text-sm text-desa-200">
                            <span class="material-symbols-outlined text-base">location_on</span>
                            {{ $village->district }}, {{ $village->regency }}, {{ $village->province }}
                        </p>
                    @endif
                    <div data-aos="fade-up" data-aos-delay="400" class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('profil-desa') }}" wire:navigate
                            class="btn-primary bg-white text-desa-700 hover:bg-gray-100 shadow-lg">
                            <span class="material-symbols-outlined text-lg">info</span>
                            Lihat Profil Desa
                        </a>
                        <a href="{{ route('surat.info') }}" wire:navigate
                            class="btn-secondary border-white/30 text-desa-700 hover:bg-white/10 hover:text-white">
                            <span class="material-symbols-outlined text-lg">mail</span>
                            Layanan Surat
                        </a>
                    </div>
                </div>
                {{-- Kepala Desa Card --}}
                @if ($kepala)
                    <div data-aos="fade-left" data-aos-delay="500" class="hidden lg:flex justify-center">
                        <div
                            class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 text-center max-w-xs">
                            <div
                                class="mx-auto h-32 w-32 rounded-full bg-white/20 overflow-hidden mb-4 ring-4 ring-white/30">
                                @if ($kepala->photo)
                                    <img src="{{ Storage::url($kepala->photo) }}" alt="{{ $kepala->name }}"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                @else
                                    <div class="h-full w-full flex items-center justify-center">
                                        <span class="material-symbols-outlined text-5xl text-white/60">person</span>
                                    </div>
                                @endif
                            </div>
                            <h3 class="font-bold text-white text-lg">{{ $kepala->name }}</h3>
                            <p class="text-amber-300 text-sm font-medium mt-1">{{ $kepala->position }}</p>
                            <a href="{{ route('pemerintahan') }}" wire:navigate
                                class="mt-4 inline-flex items-center gap-1 text-xs text-white/70 hover:text-white transition-colors">
                                Lihat Struktur Lengkap
                                <span class="material-symbols-outlined text-xs">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ─── STATS BAR ────────────────────────────────────── --}}
    @if ($latestStats)
        <section class="relative -mt-8 z-10 mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ([['icon' => 'groups', 'value' => number_format($latestStats->total_population), 'label' => 'Jumlah Penduduk'], ['icon' => 'family_restroom', 'value' => number_format($latestStats->total_families), 'label' => 'Kepala Keluarga'], ['icon' => 'landscape', 'value' => ($village?->area_ha ?? '-') . ' Ha', 'label' => 'Luas Wilayah'], ['icon' => 'calendar_month', 'value' => $village?->established_year ?? '-', 'label' => 'Tahun Berdiri']] as $stat)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" class="stat-card group hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-desa-50 text-desa-600 mb-3 group-hover:bg-desa-500 group-hover:text-white transition-colors duration-300">
                            <span class="material-symbols-outlined text-2xl">{{ $stat['icon'] }}</span>
                        </div>
                        <span class="text-2xl font-extrabold text-gray-900">{{ $stat['value'] }}</span>
                        <span class="text-xs text-gray-500 mt-1">{{ $stat['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ─── LAYANAN CEPAT ─────────────────────────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-8" data-aos="fade-up">
            <h2 class="section-title">Layanan Publik</h2>
            <p class="section-subtitle">Akses cepat ke layanan desa untuk masyarakat</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ([
        [
            'route' => 'surat.info',
            'icon' => 'mail',
            'label' => 'Layanan Surat',
            'desc' => 'Permohonan surat online',
            'bg_light' => 'bg-desa-50',
            'bg_hover' => 'group-hover:bg-desa-600',
            'text_color' => 'text-desa-500',
        ],
        [
            'route' => 'bansos',
            'icon' => 'volunteer_activism',
            'label' => 'Cek Bansos',
            'desc' => 'Link cek bantuan sosial',
            'bg_light' => 'bg-green-50',
            'bg_hover' => 'group-hover:bg-green-600',
            'text_color' => 'text-green-500',
        ],
        [
            'route' => 'pbb',
            'icon' => 'receipt_long',
            'label' => 'Cek PBB',
            'desc' => 'Informasi pajak bumi',
            'bg_light' => 'bg-amber-50',
            'bg_hover' => 'group-hover:bg-amber-600',
            'text_color' => 'text-amber-500',
        ],
        [
            'route' => 'infografis',
            'icon' => 'bar_chart',
            'label' => 'Infografis',
            'desc' => 'Data kependudukan',
            'bg_light' => 'bg-blue-50',
            'bg_hover' => 'group-hover:bg-blue-600',
            'text_color' => 'text-blue-500',
        ],
    ] as $svc)
                <a href="{{ route($svc['route']) }}" wire:navigate data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}"
                    class="card p-5 group text-center hover:-translate-y-1 transition-all duration-300">
                    <div
                        class="mx-auto h-14 w-14 rounded-2xl flex items-center justify-center mb-3 transition-all duration-300 shadow-sm {{ $svc['bg_light'] }} {{ $svc['bg_hover'] }} group-hover:shadow-lg">
                        <span
                            class="material-symbols-outlined text-2xl group-hover:text-white transition-colors duration-300 {{ $svc['text_color'] }}">
                            {{ $svc['icon'] }}
                        </span>

                    </div>
                    <h3 class="font-semibold text-gray-900 text-sm">{{ $svc['label'] }}</h3>
                    <p class="text-xs text-gray-400 mt-1">{{ $svc['desc'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ─── BERITA TERBARU ───────────────────────────────── --}}
    <section class="bg-gray-50/50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8" data-aos="fade-up">
                <div>
                    <h2 class="section-title">Berita Terbaru</h2>
                    <p class="section-subtitle">Informasi dan kabar terkini dari desa</p>
                </div>
                <a href="{{ route('berita.index') }}" wire:navigate class="hidden sm:inline-flex btn-secondary btn-sm">
                    Lihat Semua <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($latestPosts as $post)
                    <a href="{{ route('berita.show', $post->slug) }}" wire:navigate data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}" class="card group overflow-hidden">
                        <div class="aspect-video bg-gray-100 overflow-hidden">
                            @if ($post->thumbnail)
                                <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-desa-50">
                                    <span class="material-symbols-outlined text-4xl text-desa-300">newspaper</span>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <span class="badge badge-desa mb-2">{{ $post->category?->name ?? 'Umum' }}</span>
                            <h3
                                class="font-semibold text-gray-900 line-clamp-2 group-hover:text-desa-600 transition-colors">
                                {{ $post->title }}
                            </h3>
                            <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $post->excerpt }}</p>
                            <div class="mt-3 flex items-center gap-3 text-xs text-gray-400">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                                    {{ $post->published_at?->translatedFormat('d M Y') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                    {{ $post->views }}
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
            <div class="mt-6 text-center sm:hidden">
                <a href="{{ route('berita.index') }}" wire:navigate class="btn-secondary btn-sm">
                    Lihat Semua Berita <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── IDM HIGHLIGHT ─────────────────────────────────── --}}
    @if ($idm)
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <div data-aos="fade-up" class="card p-0 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-8 md:p-10 flex flex-col justify-center">
                        <span class="badge badge-desa mb-3 self-start">IDM {{ $idm->year }}</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2">Indeks Desa Membangun</h2>
                        <p class="text-sm text-gray-500 mb-6">Status kemajuan dan kemandirian desa berdasarkan penilaian
                            Kementerian Desa, PDT dan Transmigrasi.</p>
                        <div class="flex items-end gap-3 mb-6">
                            <span
                                class="text-5xl font-extrabold text-desa-600">{{ number_format($idm->score, 3) }}</span>
                            <span
                                class="badge text-sm px-4 py-1.5 mb-1 {{ $idm->status_color }}">{{ $idm->status_label }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            @foreach ([['label' => 'IKS', 'full' => 'Sosial', 'score' => $idm->social_score, 'color' => 'blue'], ['label' => 'IKE', 'full' => 'Ekonomi', 'score' => $idm->economic_score, 'color' => 'amber'], ['label' => 'IKL', 'full' => 'Lingkungan', 'score' => $idm->environment_score, 'color' => 'green']] as $dim)
                                <div class="text-center">
                                    <p class="text-xl font-bold text-gray-900">{{ number_format($dim['score'], 3) }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $dim['label'] }} · {{ $dim['full'] }}
                                    </p>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                        <div class="bg-{{ $dim['color'] }}-500 h-1.5 rounded-full"
                                            style="width: {{ $dim['score'] * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('idm') }}" wire:navigate class="btn-secondary btn-sm self-start">
                            Lihat Detail IDM <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </a>
                    </div>
                    <div
                        class="bg-gradient-to-br from-desa-500 to-desa-700 p-8 md:p-10 flex flex-col justify-center text-center text-white">
                        <span class="material-symbols-outlined text-6xl mb-4 opacity-80">insights</span>
                        <h3 class="text-xl font-bold mb-2">Status Desa</h3>
                        <p class="text-5xl font-extrabold mb-2">{{ $idm->status_label }}</p>
                        <p class="text-sm text-desa-200">
                            @if ($idm->status === 'mandiri')
                                Desa telah mencapai tingkat tertinggi dalam IDM
                            @elseif($idm->status === 'maju')
                                Desa terus bergerak menuju kemandirian
                            @elseif($idm->status === 'berkembang')
                                Desa sedang dalam proses peningkatan
                            @else
                                Desa memerlukan perhatian lebih untuk pembangunan
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ─── AGENDA KEGIATAN ──────────────────────────────── --}}
    <section class="bg-desa-50/50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8" data-aos="fade-up">
                <div>
                    <h2 class="section-title">Agenda Kegiatan</h2>
                    <p class="section-subtitle">Kegiatan yang akan datang</p>
                </div>
                <a href="{{ route('agenda') }}" wire:navigate
                    class="hidden sm:inline-flex btn-secondary btn-sm">Lihat Semua</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($upcomingAgendas as $agenda)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" class="card group hover:-translate-y-1 transition-all duration-300">
                        <div class="card-body">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex-shrink-0 flex flex-col items-center rounded-xl bg-desa-500 text-white px-3 py-2 min-w-[60px] group-hover:bg-desa-600 transition-colors">
                                    <span class="text-2xl font-bold">{{ $agenda->start_date->format('d') }}</span>
                                    <span
                                        class="text-xs uppercase">{{ $agenda->start_date->translatedFormat('M') }}</span>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $agenda->title }}</h3>
                                    @if ($agenda->location)
                                        <p class="mt-1 flex items-center gap-1 text-xs text-gray-500">
                                            <span
                                                class="material-symbols-outlined text-sm">location_on</span>{{ $agenda->location }}
                                        </p>
                                    @endif
                                    <p class="mt-1 flex items-center gap-1 text-xs text-gray-400">
                                        <span class="material-symbols-outlined text-sm">schedule</span>
                                        {{ $agenda->start_date->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 card p-12 text-center">
                        <span class="material-symbols-outlined text-5xl text-gray-200 mb-3">event</span>
                        <p class="text-gray-400">Belum ada agenda kegiatan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ─── POTENSI DESA ─────────────────────────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-end justify-between mb-8" data-aos="fade-up">
            <div>
                <h2 class="section-title">Potensi Desa</h2>
                <p class="section-subtitle">Kekayaan dan potensi unggulan desa</p>
            </div>
            <a href="{{ route('potensi') }}" wire:navigate class="hidden sm:inline-flex btn-secondary btn-sm">Lihat
                Semua</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($potentials as $p)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" class="card group overflow-hidden hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-video bg-gray-100 overflow-hidden">
                        @if ($p->thumbnail)
                            <img src="{{ Storage::url($p->thumbnail) }}" alt="{{ $p->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-amber-50">
                                <span class="material-symbols-outlined text-4xl text-amber-300">eco</span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <span class="badge badge-success text-xs mb-2">{{ ucfirst($p->category) }}</span>
                        <h3 class="font-semibold text-gray-900 line-clamp-2">{{ $p->title }}</h3>
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

    {{-- ─── UMKM ─────────────────────────────────────────── --}}
    <section class="bg-gradient-to-br from-amber-50 to-orange-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8" data-aos="fade-up">
                <div>
                    <h2 class="section-title">UMKM & Produk Desa</h2>
                    <p class="section-subtitle">Dukung usaha lokal desa</p>
                </div>
                <a href="{{ route('umkm') }}" wire:navigate class="hidden sm:inline-flex btn-amber btn-sm">Lihat
                    Semua</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" class="card group hover:-translate-y-0.5 transition-all duration-300">
                        <div class="card-body flex gap-4">
                            <div class="flex-shrink-0 h-16 w-16 rounded-xl bg-gray-100 overflow-hidden">
                                @if ($product->photo)
                                    <img src="{{ Storage::url($product->photo) }}"
                                        alt="{{ $product->business_name }}" class="h-full w-full object-cover" loading="lazy" decoding="async">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-amber-50">
                                        <span class="material-symbols-outlined text-amber-400">storefront</span>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-semibold text-gray-900 truncate">{{ $product->business_name }}</h3>
                                <p class="text-sm text-gray-500">{{ $product->owner_name }}</p>
                                @if ($product->whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->whatsapp) }}"
                                        target="_blank" rel="noopener"
                                        class="mt-2 inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700 hover:bg-green-200 transition-colors">
                                        WhatsApp
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 card p-12 text-center">
                        <span class="material-symbols-outlined text-5xl text-gray-200 mb-3">storefront</span>
                        <p class="text-gray-400">Belum ada data UMKM.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ─── PETA & KONTAK ─────────────────────────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Map --}}
            <div data-aos="fade-right" class="card overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-500">map</span>
                        Lokasi Desa
                    </h3>
                </div>
                <div class="aspect-video bg-gray-100">
                    @if ($village?->map_embed_url)
                        <iframe src="{{ $village->map_embed_url }}" class="w-full h-full border-0" loading="lazy"
                            allowfullscreen></iframe>
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-5xl text-gray-300">map</span>
                        </div>
                    @endif
                </div>
            </div>
            {{-- Quick Info --}}
            <div class="space-y-6">
                <div data-aos="fade-left" data-aos-delay="100" class="card p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-500">info</span>
                        Informasi Desa
                    </h3>
                    <div class="space-y-3">
                        @foreach ([['icon' => 'location_on', 'label' => 'Alamat', 'value' => $village?->address ?? '-'], ['icon' => 'domain', 'label' => 'Kecamatan', 'value' => $village?->district ?? '-'], ['icon' => 'apartment', 'label' => 'Kabupaten', 'value' => $village?->regency ?? '-'], ['icon' => 'public', 'label' => 'Provinsi', 'value' => $village?->province ?? '-'], ['icon' => 'tag', 'label' => 'Kode Desa', 'value' => $village?->village_code ?? '-']] as $info)
                            <div class="flex items-center gap-3 text-sm">
                                <span
                                    class="material-symbols-outlined text-desa-400 text-lg">{{ $info['icon'] }}</span>
                                <span class="text-gray-400 w-24">{{ $info['label'] }}</span>
                                <span class="font-medium text-gray-900">{{ $info['value'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('kontak') }}" wire:navigate
                    class="card p-6 flex items-center gap-4 group hover:-translate-y-0.5 transition-all duration-300">
                    <div
                        class="h-12 w-12 rounded-xl bg-desa-50 flex items-center justify-center group-hover:bg-desa-500 transition-colors duration-300">
                        <span
                            class="material-symbols-outlined text-desa-600 group-hover:text-white transition-colors duration-300">chat</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm">Hubungi Kami</h3>
                        <p class="text-xs text-gray-400">Kirim pertanyaan atau aspirasi ke Pemerintah Desa</p>
                    </div>
                    <span class="material-symbols-outlined text-gray-300 ml-auto">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
</div>
