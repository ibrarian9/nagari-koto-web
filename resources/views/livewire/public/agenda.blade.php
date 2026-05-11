<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <h1 data-aos="fade-up" class="section-title text-center">Agenda Kegiatan</h1>
        <p data-aos="fade-up" data-aos-delay="100" class="section-subtitle text-center mb-10">Jadwal kegiatan dan acara desa</p>

        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-desa-500">upcoming</span> Akan Datang</h2>
        <div class="space-y-4 mb-12">
            @forelse($upcoming as $agenda)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" class="card p-5 flex flex-col sm:flex-row items-start gap-4">
                    <div class="flex-shrink-0 flex flex-col items-center rounded-xl bg-desa-500 text-white px-4 py-3 min-w-[70px]">
                        <span class="text-2xl font-bold">{{ $agenda->start_date->format('d') }}</span>
                        <span class="text-xs uppercase">{{ $agenda->start_date->translatedFormat('M Y') }}</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 text-lg">{{ $agenda->title }}</h3>
                        @if($agenda->location)<p class="flex items-center gap-1 text-sm text-gray-500 mt-1"><span class="material-symbols-outlined text-sm">location_on</span>{{ $agenda->location }}</p>@endif
                        @if($agenda->description)<p class="text-sm text-gray-600 mt-2">{{ $agenda->description }}</p>@endif
                        <p class="text-xs text-gray-400 mt-2">{{ $agenda->start_date->translatedFormat('d M Y H:i') }}@if($agenda->end_date) — {{ $agenda->end_date->translatedFormat('d M Y H:i') }}@endif</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400 py-8">Belum ada agenda yang akan datang.</p>
            @endforelse
        </div>

        @if($past->count())
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm font-medium mb-4">
                    <span class="material-symbols-outlined text-base" x-text="open ? 'expand_less' : 'expand_more'">expand_more</span>
                    Agenda Sebelumnya ({{ $past->count() }})
                </button>
                <div x-show="open" x-transition class="space-y-3">
                    @foreach($past as $agenda)
                        <div class="card p-4 opacity-75 flex items-center gap-4">
                            <div class="flex-shrink-0 rounded-lg bg-gray-100 px-3 py-2 text-center min-w-[60px]">
                                <span class="text-lg font-bold text-gray-500">{{ $agenda->start_date->format('d') }}</span>
                                <span class="text-xs text-gray-400 block">{{ $agenda->start_date->translatedFormat('M') }}</span>
                            </div>
                            <div><h4 class="font-medium text-gray-700">{{ $agenda->title }}</h4>@if($agenda->location)<p class="text-xs text-gray-400">{{ $agenda->location }}</p>@endif</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</div>
