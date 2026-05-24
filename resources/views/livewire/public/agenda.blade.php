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
                <span class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base">upcoming</span>
                    {{ $upcoming->count() }} Akan Datang
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base">history</span>
                    {{ $past->count() }} Selesai
                </span>
            </div>
        </div>
    </x-hero-section>

    {{-- ─── UPCOMING ─────────────────────────────────────── --}}
    <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <span class="material-symbols-outlined text-amber-500">upcoming</span> Akan Datang
        </h2>

        <div class="space-y-5">
            @forelse($upcoming as $agenda)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="flex flex-col sm:flex-row">
                        {{-- Date badge --}}
                        <div class="flex-shrink-0 flex flex-col items-center justify-center bg-gradient-to-br from-amber-500 to-orange-600 text-white px-6 py-4 sm:min-w-[100px]">
                            <span class="text-3xl font-extrabold leading-none">{{ $agenda->start_date->format('d') }}</span>
                            <span class="text-xs uppercase font-semibold mt-1 tracking-wide">{{ $agenda->start_date->translatedFormat('M Y') }}</span>
                            <span class="text-[10px] text-amber-200 mt-0.5">{{ $agenda->start_date->format('H:i') }} WIB</span>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 p-5">
                            <h3 class="font-bold text-gray-900 text-lg">{{ $agenda->title }}</h3>

                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-sm text-gray-500">
                                @if($agenda->location)
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm text-amber-500">location_on</span>
                                        {{ $agenda->location }}
                                    </span>
                                @endif
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm text-amber-500">schedule</span>
                                    {{ $agenda->start_date->translatedFormat('d M Y H:i') }}
                                    @if($agenda->end_date) — {{ $agenda->end_date->translatedFormat('d M Y H:i') }}@endif
                                </span>
                            </div>

                            @if($agenda->description)
                                <p class="text-sm text-gray-600 mt-3 leading-relaxed">{{ $agenda->description }}</p>
                            @endif
                        </div>

                        {{-- Flyer --}}
                        @if($agenda->flyer)
                            <div class="flex-shrink-0 hidden sm:block sm:w-28 md:w-32">
                                <a href="{{ Storage::url($agenda->flyer) }}" target="_blank"
                                    class="block aspect-square group relative overflow-hidden sm:rounded-r-2xl">
                                    <img src="{{ Storage::url($agenda->flyer) }}" alt="Flyer {{ $agenda->title }}"
                                        class="w-full h-full object-cover group-hover:brightness-90 transition-all" loading="lazy" decoding="async">
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/20 transition-all">
                                        <span class="material-symbols-outlined text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-lg">zoom_in</span>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-amber-50 mb-4">
                        <span class="material-symbols-outlined text-3xl text-amber-300">event_available</span>
                    </div>
                    <p class="text-gray-400 font-medium">Belum ada agenda yang akan datang.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ─── PAST ─────────────────────────────────────────── --}}
    @if($past->count())
        <section class="bg-gray-50/50 border-t border-gray-100">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12">
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm font-semibold mb-6 transition-colors">
                        <span class="material-symbols-outlined text-base" x-text="open ? 'expand_less' : 'expand_more'">expand_more</span>
                        <span class="material-symbols-outlined text-base text-gray-400">history</span>
                        Agenda Sebelumnya ({{ $past->count() }})
                    </button>
                    <div x-show="open" x-transition class="space-y-3">
                        @foreach($past as $agenda)
                            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex items-center gap-4 opacity-75 hover:opacity-100 transition-opacity">
                                <div class="flex-shrink-0 rounded-lg bg-gray-100 px-3 py-2 text-center min-w-[60px]">
                                    <span class="text-lg font-bold text-gray-500">{{ $agenda->start_date->format('d') }}</span>
                                    <span class="text-xs text-gray-400 block">{{ $agenda->start_date->translatedFormat('M') }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-700 truncate">{{ $agenda->title }}</h4>
                                    @if($agenda->location)<p class="text-xs text-gray-400">{{ $agenda->location }}</p>@endif
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
