<div>
    {{-- ─── HERO ─────────────────────────────────────────── --}}
    <x-hero-section slug="donasi" gradient="from-desa-700 via-desa-800 to-desa-950" class="py-16 md:py-20">
        <div class="text-center">
            <div class="inline-flex items-center justify-center h-14 w-14 rounded-xl bg-white/10 border border-white/20 mb-4 text-white">
                <span class="material-symbols-outlined text-3xl">favorite</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                Donasi untuk Nagari
            </h1>
            <p class="mt-3 text-base md:text-lg text-slate-100 max-w-2xl mx-auto leading-relaxed font-normal">
                Mari bersama membangun {{ $village?->name ?? 'nagari' }} menjadi lebih baik melalui partisipasi donasi yang transparan dan akuntabel.
            </p>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto">
                <div class="bg-white/10 rounded-xl border border-white/20 p-4 text-center">
                    <span class="text-2xl font-bold text-white tracking-tight">Rp {{ number_format($summary['total_collected'], 0, ',', '.') }}</span>
                    <p class="text-xs text-slate-200 mt-1 font-semibold uppercase tracking-wider">Total Terkumpul</p>
                </div>
                <div class="bg-white/10 rounded-xl border border-white/20 p-4 text-center">
                    <span class="text-2xl font-bold text-white tracking-tight">{{ number_format($summary['total_donors']) }}</span>
                    <p class="text-xs text-slate-200 mt-1 font-semibold uppercase tracking-wider">Donatur</p>
                </div>
                <div class="bg-white/10 rounded-xl border border-white/20 p-4 text-center">
                    <span class="text-2xl font-bold text-white tracking-tight">{{ number_format($summary['active_campaigns']) }}</span>
                    <p class="text-xs text-slate-200 mt-1 font-semibold uppercase tracking-wider">Program Aktif</p>
                </div>
            </div>
        </div>
    </x-hero-section>

    {{-- ─── CAMPAIGNS ────────────────────────────────────── --}}
    <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        @if($campaigns->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($campaigns as $c)
                    <a href="{{ route('donasi.detail', $c->slug) }}" wire:navigate
                        class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-desa-300 transition-all duration-200 overflow-hidden group flex flex-col focus:outline-none focus-visible:ring-2 focus-visible:ring-desa-500 focus-visible:ring-offset-2">
                        {{-- Image --}}
                        <div class="aspect-[16/9] bg-slate-100 overflow-hidden relative border-b border-slate-100">
                            @if($c->thumbnail)
                                <img src="{{ Storage::url($c->thumbnail) }}" alt="{{ $c->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy" decoding="async">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400">
                                    <span class="material-symbols-outlined text-5xl">favorite</span>
                                </div>
                            @endif
                            @if($c->end_date)
                                <div class="absolute top-3 right-3 px-2.5 py-1 rounded-md bg-slate-900/85 text-xs font-semibold text-white shadow-sm">
                                    s.d. {{ $c->end_date->format('d M Y') }}
                                </div>
                            @endif
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between space-y-5">
                            <div>
                                <h2 class="font-bold text-slate-900 text-lg leading-snug group-hover:text-desa-700 transition-colors line-clamp-2">
                                    {{ $c->title }}
                                </h2>

                                {{-- Progress bar & stats --}}
                                <div class="mt-4 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-xs text-slate-600 font-medium block">Terkumpul:</span>
                                            <span class="font-extrabold text-emerald-700 text-base">
                                                Rp {{ number_format($c->collected_amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <span class="text-xs font-bold text-slate-700 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded">
                                            {{ $c->progress_percent }}%
                                        </span>
                                    </div>
                                    <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200/60">
                                        <div class="h-full bg-emerald-600 rounded-full transition-all duration-500" style="width: {{ min(100, $c->progress_percent) }}%"></div>
                                    </div>
                                    <div class="flex items-center justify-between text-xs text-slate-600 pt-0.5">
                                        <span>Target: <strong class="text-slate-800">Rp {{ number_format($c->target_amount, 0, ',', '.') }}</strong></span>
                                        @if($c->end_date)
                                            <span class="{{ $c->is_expired ? 'text-rose-600 font-semibold' : 'text-slate-600' }}">
                                                {{ $c->is_expired ? 'Berakhir' : $c->end_date->diffInDays(now()) . ' hari lagi' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                                <span class="flex items-center gap-1.5 text-xs text-slate-600 font-medium">
                                    <span class="material-symbols-outlined text-base text-desa-600">group</span>
                                    {{ number_format($c->donor_count ?? 0) }} Donatur
                                </span>
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-desa-50 text-desa-700 border border-desa-200 text-xs font-bold group-hover:bg-desa-600 group-hover:text-white transition-colors">
                                    Donasi Sekarang
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl border border-slate-200 p-8 max-w-md mx-auto shadow-sm">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 text-slate-500 mb-4">
                    <span class="material-symbols-outlined text-3xl">favorite_border</span>
                </div>
                <h2 class="text-lg font-bold text-slate-900 mb-1">Belum Ada Program Donasi</h2>
                <p class="text-sm text-slate-600 leading-relaxed">Program donasi nagari yang aktif akan ditampilkan di sini saat telah dipublikasikan.</p>
            </div>
        @endif
    </section>
</div>
