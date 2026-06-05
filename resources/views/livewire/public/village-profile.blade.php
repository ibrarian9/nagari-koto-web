<div>
    @if ($village?->photo)
        @push('preload')
            <link rel="preload" as="image" href="{{ Storage::url($village->photo) }}">
        @endpush
    @endif
    {{-- ─── HERO ─────────────────────────────────── --}}
    <section class="relative bg-gradient-to-br from-desa-600 via-desa-700 to-desa-900 overflow-hidden">
        @if ($village?->photo)
            <img src="{{ Storage::url($village->photo) }}" alt="{{ $village->name }}"
                class="absolute inset-0 w-full h-full object-cover" fetchpriority="high">
            <div class="absolute inset-0 bg-gradient-to-br from-desa-900/85 via-desa-800/80 to-desa-900/90"></div>
        @else
            <div class="absolute inset-0 opacity-10">
                <div
                    class="absolute top-0 right-0 w-96 h-96 bg-amber-400 rounded-full filter blur-3xl translate-x-1/2 -translate-y-1/2">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-64 h-64 bg-white rounded-full filter blur-3xl -translate-x-1/2 translate-y-1/2">
                </div>
            </div>
        @endif
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 items-center">
                <div class="lg:col-span-3">
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-white/10 backdrop-blur-sm px-4 py-1.5 text-sm text-amber-300 mb-4">
                        <span class="material-symbols-outlined text-base">location_city</span>
                        Profil Desa
                    </div>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight tracking-tight">
                        {{ $village?->name ?? 'Nagari Duo Koto' }}
                    </h1>
                    <p class="mt-3 text-lg text-desa-100 max-w-lg">
                        {{ $village?->tagline ?? 'Membangun desa maju, sejahtera, dan berbudaya' }}
                    </p>
                    @if ($village?->address)
                        <p class="mt-4 flex items-center gap-2 text-sm text-desa-200">
                            <span class="material-symbols-outlined text-base">location_on</span>
                            {{ $village->address }}
                        </p>
                    @endif
                </div>
                {{-- Quick Info Cards --}}
                <div class="lg:col-span-2 grid grid-cols-2 gap-3">
                    @foreach ([['icon' => 'tag', 'value' => $village?->village_code ?? '-', 'label' => 'Kode Desa'], ['icon' => 'landscape', 'value' => ($village?->area_ha ?? '-') . ' Ha', 'label' => 'Luas Wilayah'], ['icon' => 'calendar_month', 'value' => $village?->established_year ?? '-', 'label' => 'Tahun Berdiri'], ['icon' => 'groups', 'value' => $latestStats ? number_format($latestStats->total_population) : '-', 'label' => 'Penduduk']] as $qi)
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center border border-white/10">
                            <span
                                class="material-symbols-outlined text-amber-300 text-xl mb-1">{{ $qi['icon'] }}</span>
                            <p class="text-xl font-extrabold text-white">{{ $qi['value'] }}</p>
                            <p class="text-xs text-desa-200">{{ $qi['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ─── NAVIGATION TABS ─────────────────────────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12" x-data="{ tab: 'sejarah' }">
        <div class="flex flex-wrap justify-center gap-2 mb-8">
            @foreach ([['key' => 'sejarah', 'label' => 'Sejarah', 'icon' => 'history_edu'], ['key' => 'visi', 'label' => 'Visi & Misi', 'icon' => 'flag'], ['key' => 'wilayah', 'label' => 'Wilayah', 'icon' => 'domain'], ['key' => 'peta', 'label' => 'Peta Desa', 'icon' => 'map']] as $t)
                <button @click="tab = '{{ $t['key'] }}'"
                    :class="tab === '{{ $t['key'] }}' ? 'bg-desa-500 text-white shadow-md' :
                        'bg-white text-gray-600 hover:bg-gray-50'"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 border border-gray-200">
                    <span class="material-symbols-outlined text-lg">{{ $t['icon'] }}</span>
                    <span class="hidden sm:inline">{{ $t['label'] }}</span>
                </button>
            @endforeach
        </div>

        {{-- Tab 1: Sejarah --}}
        <div x-show="tab === 'sejarah'" x-transition>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Sejarah Content --}}
                <div class="lg:col-span-2 card p-6 md:p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-500">history_edu</span>
                        Sejarah Desa
                    </h2>
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {!! $village?->history ?? '<p class="text-gray-400">Belum ada data sejarah.</p>' !!}
                    </div>
                </div>
                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Kepala Desa --}}
                    @if ($kepala)
                        <div class="card p-6 text-center">
                            <div
                                class="mx-auto h-24 w-24 rounded-full bg-gray-100 overflow-hidden mb-3 ring-4 ring-desa-100">
                                @if ($kepala->photo)
                                    <img src="{{ Storage::url($kepala->photo) }}" alt="{{ $kepala->name }}"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-desa-50">
                                        <span class="material-symbols-outlined text-4xl text-desa-300">person</span>
                                    </div>
                                @endif
                            </div>
                            <h3 class="font-bold text-gray-900">{{ $kepala->name }}</h3>
                            <p class="text-sm text-desa-600 font-medium">{{ $kepala->position }}</p>
                            <a href="{{ route('pemerintahan') }}" wire:navigate
                                class="mt-3 inline-flex items-center gap-1 text-xs text-desa-500 hover:text-desa-700 transition-colors">
                                Lihat Struktur Lengkap
                                <span class="material-symbols-outlined text-xs">arrow_forward</span>
                            </a>
                        </div>
                    @endif

                    {{-- Info Administratif --}}
                    <div class="card p-6">
                        <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-desa-500 text-lg">apartment</span>
                            Wilayah Administratif
                        </h3>
                        <div class="space-y-3 text-sm">
                            @foreach ([['label' => 'Provinsi', 'value' => $village?->province ?? '-'], ['label' => 'Kabupaten', 'value' => $village?->regency ?? '-'], ['label' => 'Kecamatan', 'value' => $village?->district ?? '-'], ['label' => 'Kode Desa', 'value' => $village?->village_code ?? '-']] as $item)
                                <div class="flex justify-between">
                                    <span class="text-gray-400">{{ $item['label'] }}</span>
                                    <span class="font-medium text-gray-900">{{ $item['value'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Statistik Singkat --}}
                    @if ($latestStats)
                        <div class="card p-6">
                            <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-desa-500 text-lg">bar_chart</span>
                                Statistik {{ $latestStats->year }}
                            </h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Penduduk</span>
                                    <span
                                        class="font-bold text-gray-900">{{ number_format($latestStats->total_population) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Laki-laki</span>
                                    <span
                                        class="font-medium text-blue-600">{{ number_format($latestStats->male) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Perempuan</span>
                                    <span
                                        class="font-medium text-pink-600">{{ number_format($latestStats->female) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Kepala Keluarga</span>
                                    <span
                                        class="font-medium text-gray-900">{{ number_format($latestStats->total_families) }}</span>
                                </div>
                            </div>
                            <a href="{{ route('infografis') }}" wire:navigate
                                class="mt-4 inline-flex items-center gap-1 text-xs text-desa-500 hover:text-desa-700 transition-colors">
                                Lihat Infografis Lengkap
                                <span class="material-symbols-outlined text-xs">arrow_forward</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tab 2: Visi & Misi --}}
        <div x-show="tab === 'visi'" x-transition>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Visi --}}
                <div class="card p-6 md:p-8 bg-gradient-to-br from-desa-50 to-white border-2 border-desa-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-12 w-12 rounded-xl bg-desa-500 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-2xl">flag</span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Visi</h2>
                    </div>
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {!! $village?->vision ?? '<p class="text-gray-400">Belum ada data visi.</p>' !!}
                    </div>
                </div>
                {{-- Misi --}}
                <div class="card p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-12 w-12 rounded-xl bg-desa-500 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-2xl">checklist</span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Misi</h2>
                    </div>
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {!! $village?->mission ?? '<p class="text-gray-400">Belum ada data misi.</p>' !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab 3: Wilayah --}}
        <div x-show="tab === 'wilayah'" x-transition>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 card p-6 md:p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-500">domain</span>
                        Informasi Wilayah
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ([['icon' => 'public', 'label' => 'Provinsi', 'value' => $village?->province ?? '-'], ['icon' => 'apartment', 'label' => 'Kabupaten/Kota', 'value' => $village?->regency ?? '-'], ['icon' => 'domain', 'label' => 'Kecamatan', 'value' => $village?->district ?? '-'], ['icon' => 'tag', 'label' => 'Kode Desa', 'value' => $village?->village_code ?? '-'], ['icon' => 'landscape', 'label' => 'Luas Wilayah', 'value' => ($village?->area_ha ?? '-') . ' Ha'], ['icon' => 'calendar_month', 'label' => 'Tahun Berdiri', 'value' => $village?->established_year ?? '-']] as $item)
                            <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50">
                                <div
                                    class="h-10 w-10 rounded-lg bg-desa-50 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-desa-600">{{ $item['icon'] }}</span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">{{ $item['label'] }}</p>
                                    <p class="font-bold text-gray-900">{{ $item['value'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($village?->address)
                        <div class="mt-6 p-4 rounded-xl bg-desa-50 flex items-start gap-3">
                            <span class="material-symbols-outlined text-desa-600 mt-0.5">location_on</span>
                            <div>
                                <p class="text-xs text-gray-400">Alamat Lengkap</p>
                                <p class="font-medium text-gray-900 text-sm">{{ $village->address }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                {{-- Demografis --}}
                @if ($latestStats)
                    <div class="space-y-6">
                        <div class="card p-6">
                            <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-desa-500 text-lg">groups</span>
                                Demografi
                            </h3>
                            <div class="text-center mb-4">
                                <p class="text-4xl font-extrabold text-desa-600">
                                    {{ number_format($latestStats->total_population) }}</p>
                                <p class="text-xs text-gray-400 mt-1">Total Penduduk ({{ $latestStats->year }})</p>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="rounded-lg bg-blue-50 p-3 text-center">
                                    <span class="material-symbols-outlined text-blue-500 text-lg">male</span>
                                    <p class="font-bold text-gray-900">{{ number_format($latestStats->male) }}</p>
                                    <p class="text-xs text-gray-400">Laki-laki</p>
                                </div>
                                <div class="rounded-lg bg-pink-50 p-3 text-center">
                                    <span class="material-symbols-outlined text-pink-500 text-lg">female</span>
                                    <p class="font-bold text-gray-900">{{ number_format($latestStats->female) }}</p>
                                    <p class="text-xs text-gray-400">Perempuan</p>
                                </div>
                            </div>
                            <div class="mt-3 rounded-lg bg-amber-50 p-3 text-center">
                                <span class="material-symbols-outlined text-amber-500 text-lg">family_restroom</span>
                                <p class="font-bold text-gray-900">{{ number_format($latestStats->total_families) }}
                                </p>
                                <p class="text-xs text-gray-400">Kepala Keluarga</p>
                            </div>
                        </div>
                        <a href="{{ route('infografis') }}" wire:navigate
                            class="card p-5 flex items-center gap-3 group hover:-translate-y-0.5 transition-all duration-300">
                            <div
                                class="h-10 w-10 rounded-lg bg-desa-50 flex items-center justify-center group-hover:bg-desa-500 transition-colors">
                                <span
                                    class="material-symbols-outlined text-desa-600 group-hover:text-white transition-colors">bar_chart</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 text-sm">Infografis Lengkap</p>
                                <p class="text-xs text-gray-400">Data usia, pendidikan, pekerjaan</p>
                            </div>
                            <span class="material-symbols-outlined text-gray-300">arrow_forward</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Tab 4: Peta --}}
        <div x-show="tab === 'peta'" x-transition>
            <div class="card overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-500">map</span>
                        Peta Lokasi Desa
                    </h2>
                    @if ($village?->address)
                        <p class="text-sm text-gray-500 hidden md:flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                            {{ $village->address }}
                        </p>
                    @endif
                </div>
                <div class="aspect-video bg-gray-100">
                    @if ($village?->map_embed_url)
                        <iframe src="{{ $village->map_embed_url }}" class="w-full h-full border-0" loading="lazy"
                            allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center">
                            <span class="material-symbols-outlined text-6xl text-gray-200 mb-3">map</span>
                            <p class="text-gray-400">Peta belum tersedia.</p>
                        </div>
                    @endif
                </div>
                @if ($village?->address)
                    <div class="p-5 bg-gray-50 md:hidden">
                        <p class="flex items-start gap-2 text-sm text-gray-600">
                            <span class="material-symbols-outlined text-desa-500 text-base mt-0.5">location_on</span>
                            {{ $village->address }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ─── CTA BAR ─────────────────────────────────── --}}
    <section class="bg-desa-50 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">Jelajahi Lebih Lanjut</h3>
                    <p class="text-sm text-gray-500">Kenali potensi, layanan, dan program desa kami</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('pemerintahan') }}" wire:navigate class="btn-secondary btn-sm">
                        <span class="material-symbols-outlined text-base">groups</span> Pemerintahan
                    </a>
                    <a href="{{ route('anggaran') }}" wire:navigate class="btn-secondary btn-sm">
                        <span class="material-symbols-outlined text-base">account_balance</span> Anggaran
                    </a>
                    <a href="{{ route('idm') }}" wire:navigate class="btn-secondary btn-sm">
                        <span class="material-symbols-outlined text-base">insights</span> IDM
                    </a>
                    <a href="{{ route('potensi') }}" wire:navigate class="btn-primary btn-sm">
                        <span class="material-symbols-outlined text-base">eco</span> Potensi Desa
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
