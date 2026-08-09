<div>
    {{-- ─── HERO ─────────────────────────────────────────── --}}
    <x-hero-section slug="agenda" gradient="from-amber-600 via-amber-700 to-orange-800">
        <x-slot:decorations>
            <div class="absolute inset-0">
                <div class="absolute top-0 right-0 w-96 h-96 bg-amber-400/10 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-orange-300/10 rounded-full blur-3xl -translate-x-1/3 translate-y-1/3"></div>
            </div>
        </x-slot:decorations>
        <div class="text-center">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 mb-5">
                <span class="material-symbols-outlined text-white text-3xl">event</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Agenda Kegiatan
            </h1>
            <p class="mt-3 text-lg text-amber-200 max-w-2xl mx-auto">
                Jadwal kegiatan dan acara {{ $village ?? 'nagari' }}
            </p>
            <div class="mt-5 flex items-center justify-center gap-6 text-sm text-amber-300">
                <span class="flex items-center gap-1.5 font-semibold">
                    <span class="material-symbols-outlined text-base">upcoming</span>
                    {{ $upcoming->count() }} Akan Datang
                </span>
                <span class="flex items-center gap-1.5 font-semibold">
                    <span class="material-symbols-outlined text-base">history</span>
                    {{ $past->count() }} Selesai
                </span>
            </div>
        </div>
    </x-hero-section>

    {{-- ─── UPCOMING ─────────────────────────────────────── --}}
    <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <span class="material-symbols-outlined text-amber-500">upcoming</span> Kegiatan Akan Datang
        </h2>

        <div class="space-y-5">
            @forelse($upcoming as $agenda)
                <div class="bg-white rounded-2xl border border-gray-150/80 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="flex flex-col sm:flex-row">
                        {{-- Date badge (Indonesian Day & Month) --}}
                        <div class="flex-shrink-0 flex flex-col items-center justify-center bg-gradient-to-br from-amber-500 to-orange-600 text-white px-6 py-4 sm:min-w-[120px]">
                            <span class="text-xs uppercase font-extrabold tracking-wider bg-white/20 px-2 py-0.5 rounded-full mb-1">{{ $agenda->start_date->translatedFormat('l') }}</span>
                            <span class="text-3xl font-extrabold leading-none tracking-tight">{{ $agenda->start_date->format('d') }}</span>
                            <span class="text-xs uppercase font-semibold mt-1 tracking-wide">{{ $agenda->start_date->translatedFormat('M Y') }}</span>
                            <span class="text-[11px] text-amber-100 font-bold mt-1 bg-black/10 px-2 py-0.5 rounded-full">{{ $agenda->start_date->format('H:i') }} WIB</span>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 p-5 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg leading-snug">{{ $agenda->title }}</h3>

                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-2.5 text-sm text-gray-600">
                                    @if($agenda->location)
                                        <span class="flex items-center gap-1 font-medium">
                                            <span class="material-symbols-outlined text-sm text-amber-600">location_on</span>
                                            {{ $agenda->location }}
                                        </span>
                                    @endif
                                    <span class="flex items-center gap-1 font-medium text-gray-700">
                                        <span class="material-symbols-outlined text-sm text-amber-600">schedule</span>
                                        {{ $agenda->start_date->translatedFormat('l, d F Y — H:i') }} WIB
                                        @if($agenda->end_date)
                                            s/d {{ $agenda->end_date->translatedFormat('l, d F Y — H:i') }} WIB
                                        @endif
                                    </span>
                                </div>

                                @if($agenda->description)
                                    <p class="text-sm text-gray-600 mt-3 leading-relaxed">{!! nl2br(e($agenda->description)) !!}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Flyer --}}
                        @if($agenda->flyer)
                            <div class="flex-shrink-0 hidden sm:block sm:w-28 md:w-36">
                                <a href="{{ Storage::url($agenda->flyer) }}" target="_blank"
                                    class="block aspect-square group relative overflow-hidden sm:rounded-r-2xl h-full">
                                    <img src="{{ Storage::url($agenda->flyer) }}" alt="Flyer {{ $agenda->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300" loading="lazy" decoding="async">
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/30 transition-all">
                                        <span class="material-symbols-outlined text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-lg">zoom_in</span>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-16 card p-8">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-amber-50 mb-4">
                        <span class="material-symbols-outlined text-3xl text-amber-400">event_available</span>
                    </div>
                    <p class="text-gray-500 font-semibold text-base">Belum ada agenda kegiatan mendatang saat ini.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ─── PAST ─────────────────────────────────────────── --}}
    @if($past->count())
        <section class="bg-gray-50/50 border-t border-gray-150">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12">
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 text-gray-700 hover:text-amber-700 text-sm font-bold mb-6 transition-colors">
                        <span class="material-symbols-outlined text-base text-amber-600" x-text="open ? 'expand_less' : 'expand_more'">expand_more</span>
                        <span class="material-symbols-outlined text-base text-gray-500">history</span>
                        Agenda Sebelumnya ({{ $past->count() }})
                    </button>
                    <div x-show="open" x-transition class="space-y-3">
                        @foreach($past as $agenda)
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-4 opacity-80 hover:opacity-100 transition-opacity">
                                <div class="flex-shrink-0 rounded-xl bg-amber-50 px-3 py-2 text-center min-w-[80px]">
                                    <span class="text-2xs font-extrabold text-amber-700 uppercase block">{{ $agenda->start_date->translatedFormat('l') }}</span>
                                    <span class="text-lg font-black text-gray-900 leading-tight">{{ $agenda->start_date->format('d') }}</span>
                                    <span class="text-xs font-semibold text-gray-500 block">{{ $agenda->start_date->translatedFormat('M Y') }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-gray-800 text-base truncate">{{ $agenda->title }}</h4>
                                    <p class="text-xs text-gray-500 flex items-center gap-2 mt-1">
                                        <span>{{ $agenda->start_date->translatedFormat('l, d F Y — H:i') }} WIB</span>
                                        @if($agenda->location) • <span>{{ $agenda->location }}</span>@endif
                                    </p>
                                </div>
                                @if($agenda->flyer)
                                    <a href="{{ Storage::url($agenda->flyer) }}" target="_blank" class="flex-shrink-0">
                                        <img src="{{ Storage::url($agenda->flyer) }}" alt="Flyer" class="h-12 w-12 rounded-lg object-cover shadow-sm hover:shadow-md transition-shadow" loading="lazy">
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>
