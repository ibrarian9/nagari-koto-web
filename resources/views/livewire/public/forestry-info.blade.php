<div>
    {{-- ─── HERO SECTION ─────────────────────────────────── --}}
    <x-hero-section slug="kehutanan" gradient="from-emerald-800 via-green-900 to-emerald-950" class="py-16 md:py-24">
        <x-slot:decorations>
            <div class="absolute inset-0">
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-500/10 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-green-400/10 rounded-full blur-3xl -translate-x-1/3 translate-y-1/3"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-amber-500/5 rounded-full blur-3xl"></div>
                {{-- Tree pattern overlay --}}
                <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 80 80%22><text y=%2240%22 font-size=%2230%22>🌲</text></svg>'); background-size: 80px;"></div>
            </div>
        </x-slot:decorations>
        <div class="text-center">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 mb-5">
                <span class="material-symbols-outlined text-white text-3xl">forest</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Data Kehutanan
            </h1>
            <p class="mt-3 text-lg text-emerald-200 max-w-2xl mx-auto">
                Informasi kawasan hutan dan lahan {{ $village?->name ?? 'desa' }}
            </p>
        </div>

        {{-- Hero Stats --}}
        <div class="mt-10 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4 text-center">
                <span class="text-3xl font-extrabold text-white">{{ number_format($summary['total_area'], 0, ',', '.') }}</span>
                <p class="text-xs text-emerald-300 mt-1 font-medium">Total Luas (Ha)</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4 text-center">
                <span class="text-3xl font-extrabold text-white">{{ $summary['total_zones'] }}</span>
                <p class="text-xs text-emerald-300 mt-1 font-medium">Kawasan</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4 text-center">
                <span class="text-3xl font-extrabold text-emerald-300">{{ $summary['aktif'] }}</span>
                <p class="text-xs text-emerald-300 mt-1 font-medium">Aktif</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4 text-center">
                <span class="text-3xl font-extrabold {{ $summary['kritis'] > 0 ? 'text-red-400' : 'text-emerald-300' }}">{{ $summary['kritis'] }}</span>
                <p class="text-xs text-emerald-300 mt-1 font-medium">Kritis</p>
            </div>
        </div>
    </x-hero-section>

    {{-- ─── CATEGORY BREAKDOWN ────────────────────────────── --}}
    @if($byCategory->count())
        <section class="relative -mt-6 z-10 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 mb-12">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                @php
                    $catIcons = [
                        'hutan_lindung' => ['icon' => 'shield', 'from' => 'from-emerald-500', 'to' => 'to-green-600'],
                        'hutan_produksi' => ['icon' => 'carpenter', 'from' => 'from-amber-500', 'to' => 'to-orange-600'],
                        'hutan_rakyat' => ['icon' => 'park', 'from' => 'from-green-500', 'to' => 'to-emerald-600'],
                        'lahan_kritis' => ['icon' => 'warning', 'from' => 'from-red-500', 'to' => 'to-rose-600'],
                        'rehabilitasi' => ['icon' => 'healing', 'from' => 'from-blue-500', 'to' => 'to-cyan-600'],
                    ];
                @endphp
                @foreach(\App\Models\ForestryRecord::CATEGORIES as $catKey => $catLabel)
                    @php
                        $catData = $byCategory->get($catKey);
                        $ci = $catIcons[$catKey] ?? ['icon' => 'forest', 'from' => 'from-gray-500', 'to' => 'to-gray-600'];
                    @endphp
                    <button wire:click="$set('categoryFilter', '{{ $categoryFilter === $catKey ? '' : $catKey }}')"
                        class="bg-white rounded-xl shadow-lg border transition-all duration-300 p-4 text-center hover:shadow-xl hover:-translate-y-0.5 {{ $categoryFilter === $catKey ? 'border-emerald-400 ring-2 ring-emerald-200' : 'border-gray-100' }}">
                        <div class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gradient-to-br {{ $ci['from'] }} {{ $ci['to'] }} mb-2">
                            <span class="material-symbols-outlined text-white text-lg">{{ $ci['icon'] }}</span>
                        </div>
                        <h4 class="text-xs font-semibold text-gray-700 leading-tight">{{ $catLabel }}</h4>
                        <p class="text-lg font-bold text-gray-900 mt-1">{{ $catData?->total ?? 0 }}</p>
                        <p class="text-[10px] text-gray-400">{{ number_format($catData?->total_area ?? 0, 1, ',', '.') }} Ha</p>
                    </button>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ─── RECORDS LIST ─────────────────────────────────── --}}
    <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 pb-16">
        @if($categoryFilter)
            <div class="flex items-center gap-2 mb-6">
                <span class="text-sm text-gray-500">Filter:</span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                    {{ \App\Models\ForestryRecord::CATEGORIES[$categoryFilter] ?? $categoryFilter }}
                    <button wire:click="$set('categoryFilter', '')" class="hover:text-emerald-900">
                        <span class="material-symbols-outlined text-xs">close</span>
                    </button>
                </span>
            </div>
        @endif

        @if($records->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($records as $record)
                    @php
                        $statusConfig = match($record->status) {
                            'aktif' => ['class' => 'bg-emerald-100 text-emerald-700', 'icon' => 'check_circle'],
                            'dalam_pemulihan' => ['class' => 'bg-amber-100 text-amber-700', 'icon' => 'autorenew'],
                            'kritis' => ['class' => 'bg-red-100 text-red-700', 'icon' => 'error'],
                            default => ['class' => 'bg-gray-100 text-gray-700', 'icon' => 'info'],
                        };
                        $ci = $catIcons[$record->category] ?? ['icon' => 'forest', 'from' => 'from-gray-500', 'to' => 'to-gray-600'];
                    @endphp
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden group">
                        {{-- Image / Placeholder --}}
                        <div class="aspect-[16/9] bg-gradient-to-br from-emerald-100 to-green-50 overflow-hidden relative">
                            @if($record->thumbnail)
                                <img src="{{ Storage::url($record->thumbnail) }}" alt="{{ $record->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="material-symbols-outlined text-6xl text-emerald-200 group-hover:scale-110 transition-transform duration-300">forest</span>
                                </div>
                            @endif
                            {{-- Category badge overlay --}}
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white/90 backdrop-blur-sm text-xs font-semibold text-gray-700 shadow-sm">
                                    <span class="material-symbols-outlined text-xs {{ str_replace(['from-', 'to-'], 'text-', $ci['from']) }}">{{ $ci['icon'] }}</span>
                                    {{ $record->category_label }}
                                </span>
                            </div>
                            {{-- Status badge overlay --}}
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg {{ $statusConfig['class'] }} text-xs font-semibold shadow-sm">
                                    <span class="material-symbols-outlined text-xs">{{ $statusConfig['icon'] }}</span>
                                    {{ $record->status_label }}
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-5">
                            <h3 class="font-bold text-gray-900 text-lg leading-tight mb-2 group-hover:text-emerald-700 transition-colors">
                                {{ $record->title }}
                            </h3>

                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-sm text-gray-500 mb-3">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm text-emerald-500">straighten</span>
                                    {{ number_format($record->area_ha, 1, ',', '.') }} Ha
                                </span>
                                @if($record->location)
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm text-emerald-500">location_on</span>
                                        {{ $record->location }}
                                    </span>
                                @endif
                                @if($record->year)
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm text-emerald-500">calendar_today</span>
                                        {{ $record->year }}
                                    </span>
                                @endif
                            </div>

                            @if($record->description)
                                <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">{{ $record->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center h-20 w-20 rounded-2xl bg-emerald-50 mb-6">
                    <span class="material-symbols-outlined text-4xl text-emerald-300">forest</span>
                </div>
                <h2 class="text-xl font-bold text-gray-400 mb-2">
                    @if($categoryFilter)
                        Tidak ada data untuk kategori ini
                    @else
                        Data belum tersedia
                    @endif
                </h2>
                <p class="text-gray-400">Informasi data kehutanan nagari sedang dalam proses pengisian.</p>
                @if($categoryFilter)
                    <button wire:click="$set('categoryFilter', '')" class="mt-4 btn-secondary btn-sm">
                        <span class="material-symbols-outlined text-base">filter_alt_off</span> Reset Filter
                    </button>
                @endif
            </div>
        @endif
    </section>

    {{-- ─── INFO SECTION ─────────────────────────────────── --}}
    @if($records->count())
        <section class="bg-gradient-to-r from-emerald-700 to-green-800 py-10">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 text-white">
                    <div>
                        <h3 class="text-xl font-bold">Menjaga Hutan, Melestarikan Kehidupan</h3>
                        <p class="text-emerald-200 mt-1">Data ini merupakan bentuk transparansi pengelolaan kawasan hutan nagari.</p>
                    </div>
                    <a href="{{ route('kontak') }}" wire:navigate class="inline-flex items-center gap-2 px-6 py-3 bg-white text-emerald-700 rounded-xl font-semibold hover:bg-gray-100 transition-colors shadow-lg flex-shrink-0">
                        <span class="material-symbols-outlined text-lg">eco</span>
                        Info Lebih Lanjut
                    </a>
                </div>
            </div>
        </section>
    @endif
</div>
