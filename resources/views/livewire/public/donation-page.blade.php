<div>
    {{-- ─── HERO ─────────────────────────────────────────── --}}
    <section class="relative bg-gradient-to-br from-rose-700 via-rose-800 to-pink-900 overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 right-0 w-96 h-96 bg-rose-400/10 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-pink-300/10 rounded-full blur-3xl -translate-x-1/3 translate-y-1/3"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-amber-400/5 rounded-full blur-3xl"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24 text-center">
            <div data-aos="zoom-in" class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 mb-5">
                <span class="material-symbols-outlined text-white text-3xl">favorite</span>
            </div>
            <h1 data-aos="fade-up" data-aos-delay="100" class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Donasi untuk Nagari
            </h1>
            <p data-aos="fade-up" data-aos-delay="200" class="mt-3 text-lg text-rose-200 max-w-2xl mx-auto">
                Mari bersama membangun {{ $village?->name ?? 'nagari' }} menjadi lebih baik melalui donasi
            </p>

            <div data-aos="fade-up" data-aos-delay="300" class="mt-10 grid grid-cols-3 gap-4 max-w-2xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4 text-center">
                    <span class="text-2xl font-extrabold text-white">Rp {{ number_format($summary['total_collected'], 0, ',', '.') }}</span>
                    <p class="text-xs text-rose-300 mt-1 font-medium">Total Terkumpul</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4 text-center">
                    <span class="text-2xl font-extrabold text-white">{{ $summary['total_donors'] }}</span>
                    <p class="text-xs text-rose-300 mt-1 font-medium">Donatur</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4 text-center">
                    <span class="text-2xl font-extrabold text-white">{{ $summary['active_campaigns'] }}</span>
                    <p class="text-xs text-rose-300 mt-1 font-medium">Program Aktif</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── CAMPAIGNS ────────────────────────────────────── --}}
    <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-12">
        @if($campaigns->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($campaigns as $c)
                    <a href="{{ route('donasi.detail', $c->slug) }}" wire:navigate
                        data-aos="fade-up" data-aos-delay="{{ $loop->index % 3 * 100 }}"
                        class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden group block">
                        {{-- Image --}}
                        <div class="aspect-[16/9] bg-gradient-to-br from-rose-100 to-pink-50 overflow-hidden relative">
                            @if($c->thumbnail)
                                <img src="{{ Storage::url($c->thumbnail) }}" alt="{{ $c->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="material-symbols-outlined text-6xl text-rose-200 group-hover:scale-110 transition-transform duration-300">favorite</span>
                                </div>
                            @endif
                            @if($c->end_date)
                                <div class="absolute top-3 right-3 px-2.5 py-1 rounded-lg bg-black/50 backdrop-blur-sm text-xs font-semibold text-white">
                                    s.d. {{ $c->end_date->format('d M Y') }}
                                </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <h3 class="font-bold text-gray-900 text-lg leading-tight mb-3 group-hover:text-rose-600 transition-colors">{{ $c->title }}</h3>

                            {{-- Progress bar --}}
                            <div class="mb-3">
                                <div class="flex justify-between text-sm mb-1.5">
                                    <span class="font-bold text-green-600">Rp {{ number_format($c->collected_amount, 0, ',', '.') }}</span>
                                    <span class="text-gray-400">{{ $c->progress_percent }}%</span>
                                </div>
                                <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-rose-400 to-pink-500 rounded-full transition-all duration-500" style="width: {{ min(100, $c->progress_percent) }}%"></div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Target: Rp {{ number_format($c->target_amount, 0, ',', '.') }}</p>
                            </div>

                            <div class="flex items-center justify-between text-sm text-gray-500 pt-3 border-t border-gray-100">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm text-rose-400">group</span>
                                    {{ $c->donor_count ?? 0 }} donatur
                                </span>
                                <span class="flex items-center gap-1 text-rose-500 font-medium group-hover:gap-2 transition-all">
                                    Donasi <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center h-20 w-20 rounded-2xl bg-rose-50 mb-6">
                    <span class="material-symbols-outlined text-4xl text-rose-300">favorite</span>
                </div>
                <h2 class="text-xl font-bold text-gray-400 mb-2">Belum ada program donasi</h2>
                <p class="text-gray-400">Program donasi nagari akan segera tersedia.</p>
            </div>
        @endif
    </section>
</div>
