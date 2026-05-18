<div>
    {{-- ─── HERO ─────────────────────────────────────────── --}}
    <section class="relative bg-gradient-to-br from-purple-800 via-purple-900 to-slate-900 overflow-hidden">
        <div class="absolute inset-0">
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-purple-400/10 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3">
            </div>
            <div
                class="absolute bottom-0 left-0 w-80 h-80 bg-fuchsia-400/10 rounded-full blur-3xl -translate-x-1/3 translate-y-1/3">
            </div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-20 text-center">
            <div
                class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 mb-5">
                <span class="material-symbols-outlined text-white text-3xl">domain</span>
            </div>
            <h1
                class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Lembaga Nagari
            </h1>
            <p class="mt-3 text-lg text-purple-200 max-w-2xl mx-auto">
                Organisasi dan lembaga kemasyarakatan {{ $village?->name ?? 'nagari' }}
            </p>
            <div
                class="mt-5 flex items-center justify-center gap-4 text-sm text-purple-300">
                <span class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base text-amber-400">domain</span>
                    {{ $institutions->count() }} Lembaga Aktif
                </span>
            </div>
        </div>
    </section>

    {{-- ─── FILTER BUTTONS ───────────────────────────────── --}}
    <section class="relative -mt-6 z-10 mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 mb-10">
        <div class="flex flex-wrap justify-center gap-2">
            <button wire:click="$set('typeFilter', '')"
                class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 border shadow-sm {{ !$typeFilter ? 'bg-purple-600 text-white border-purple-600 shadow-purple-200' : 'bg-white text-gray-600 border-gray-200 hover:border-purple-300 hover:text-purple-700' }}">
                Semua
            </button>
            @php
                $typeIcons = [
                    'adat' => 'temple_buddhist',
                    'kepemudaan' => 'diversity_3',
                    'perempuan' => 'female',
                    'keagamaan' => 'mosque',
                    'sosial' => 'volunteer_activism',
                    'pendidikan' => 'school',
                    'lainnya' => 'category',
                ];
            @endphp
            @foreach (\App\Models\VillageInstitution::TYPES as $key => $label)
                <button wire:click="$set('typeFilter', '{{ $typeFilter === $key ? '' : $key }}')"
                    class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 border shadow-sm flex items-center gap-1.5 {{ $typeFilter === $key ? 'bg-purple-600 text-white border-purple-600 shadow-purple-200' : 'bg-white text-gray-600 border-gray-200 hover:border-purple-300 hover:text-purple-700' }}">
                    <span class="material-symbols-outlined text-sm">{{ $typeIcons[$key] ?? 'category' }}</span>
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </section>

    {{-- ─── INSTITUTIONS GRID ────────────────────────────── --}}
    <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 pb-16">
        @if ($institutions->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($institutions as $inst)
                    @php
                        $typeColors = [
                            'adat' => 'from-amber-500 to-orange-600',
                            'kepemudaan' => 'from-blue-500 to-cyan-600',
                            'perempuan' => 'from-pink-500 to-rose-600',
                            'keagamaan' => 'from-emerald-500 to-green-600',
                            'sosial' => 'from-purple-500 to-violet-600',
                            'pendidikan' => 'from-indigo-500 to-blue-600',
                            'lainnya' => 'from-gray-500 to-slate-600',
                        ];
                        $gradient = $typeColors[$inst->type] ?? 'from-gray-500 to-slate-600';
                    @endphp
                    <div
                        class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden group">
                        {{-- Header bar --}}
                        <div class="h-2 bg-gradient-to-r {{ $gradient }}"></div>
                        <div class="p-6">
                            <div class="flex items-start gap-4 mb-4">
                                <div
                                    class="flex-shrink-0 h-14 w-14 rounded-xl bg-gradient-to-br {{ $gradient }} flex items-center justify-center shadow-md overflow-hidden">
                                    @if ($inst->logo)
                                        <img src="{{ Storage::url($inst->logo) }}" alt="{{ $inst->name }}"
                                            class="h-full w-full object-cover" loading="lazy" decoding="async">
                                    @else
                                        <span
                                            class="material-symbols-outlined text-2xl text-white">{{ $typeIcons[$inst->type] ?? 'domain' }}</span>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3
                                        class="font-bold text-gray-900 text-lg leading-tight group-hover:text-purple-700 transition-colors">
                                        {{ $inst->name }}</h3>
                                    <span
                                        class="inline-flex items-center gap-1 mt-1 text-xs font-semibold text-gray-500">
                                        <span
                                            class="material-symbols-outlined text-xs">{{ $typeIcons[$inst->type] ?? 'category' }}</span>
                                        {{ $inst->type_label }}
                                    </span>
                                </div>
                            </div>

                            @if ($inst->head_name)
                                <div class="flex items-center gap-2 mb-3 px-3 py-2 bg-gray-50 rounded-lg">
                                    <span class="material-symbols-outlined text-sm text-purple-500">person</span>
                                    <div>
                                        <p class="text-xs text-gray-400">Ketua</p>
                                        <p class="text-sm font-semibold text-gray-800">{{ $inst->head_name }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($inst->description)
                                <p class="text-sm text-gray-500 line-clamp-3 leading-relaxed mb-3">
                                    {{ $inst->description }}</p>
                            @endif

                            <div
                                class="flex flex-wrap items-center gap-3 text-xs text-gray-400 pt-3 border-t border-gray-100">
                                @if ($inst->established_year)
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs">event</span> Berdiri
                                        {{ $inst->established_year }}
                                    </span>
                                @endif
                                @if ($inst->contact)
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs">call</span>
                                        {{ $inst->contact }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center h-20 w-20 rounded-2xl bg-purple-50 mb-6">
                    <span class="material-symbols-outlined text-4xl text-purple-300">domain</span>
                </div>
                <h2 class="text-xl font-bold text-gray-400 mb-2">
                    @if ($typeFilter)
                        Tidak ada lembaga untuk kategori ini
                    @else
                        Data belum tersedia
                    @endif
                </h2>
                <p class="text-gray-400">Informasi lembaga nagari sedang dalam proses pengisian.</p>
                @if ($typeFilter)
                    <button wire:click="$set('typeFilter', '')" class="mt-4 btn-secondary btn-sm">
                        <span class="material-symbols-outlined text-base">filter_alt_off</span> Reset Filter
                    </button>
                @endif
            </div>
        @endif
    </section>
</div>
