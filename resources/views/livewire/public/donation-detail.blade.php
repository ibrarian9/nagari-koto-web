<div>
    {{-- ─── HERO ─────────────────────────────────────────── --}}
    <x-hero-section slug="donasi" gradient="from-desa-700 via-desa-800 to-desa-950" class="py-12 md:py-16">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('donasi') }}" wire:navigate class="inline-flex items-center gap-1.5 text-slate-200 hover:text-white text-sm font-semibold mb-4 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-desa-400 rounded-lg px-2 py-1 -ml-2">
                <span class="material-symbols-outlined text-base">arrow_back</span> Kembali ke Donasi
            </a>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">
                {{ $campaign->title }}
            </h1>
            <p class="mt-3 text-slate-200 text-sm md:text-base leading-relaxed">
                Dibuat oleh <strong class="text-white font-semibold">{{ $campaign->creator?->name ?? 'Pemerintah Nagari' }}</strong> · 
                <span>{{ $campaign->start_date->format('d M Y') }}</span>
                @if($campaign->end_date) — <span>{{ $campaign->end_date->format('d M Y') }}</span>@endif
            </p>
        </div>
    </x-hero-section>

    {{-- ─── MAIN CONTENT ─────────────────────────────────── --}}
    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 -mt-6 relative z-10 pb-16">
        <div class="space-y-6">
            {{-- Image --}}
            @if($campaign->thumbnail)
                <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-slate-100">
                    <img src="{{ Storage::url($campaign->thumbnail) }}" alt="{{ $campaign->title }}" class="w-full aspect-video object-cover" loading="eager" decoding="async">
                </div>
            @endif

            {{-- Progress Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
                <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-2 mb-4">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-600 block mb-1">Total Dana Terkumpul</span>
                        <p class="text-3xl sm:text-4xl font-extrabold text-emerald-700 tracking-tight">
                            Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-slate-600 mt-1 font-medium">
                            terkumpul dari target <strong class="text-slate-900 font-bold">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</strong>
                        </p>
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 border border-slate-200 self-start sm:self-auto">
                        <span class="text-sm font-extrabold text-slate-800">{{ $campaign->progress_percent }}%</span>
                        <span class="text-xs font-semibold text-slate-600">tercapai</span>
                    </div>
                </div>

                {{-- Progress Bar --}}
                <div class="h-3.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200/80 mb-5">
                    <div class="h-full bg-emerald-600 rounded-full transition-all duration-700" style="width: {{ min(100, $campaign->progress_percent) }}%"></div>
                </div>

                {{-- Metadata --}}
                <div class="flex flex-wrap items-center gap-6 pt-2 border-t border-slate-100 text-sm text-slate-700 font-medium">
                    <span class="inline-flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg text-desa-600">group</span>
                        <strong class="text-slate-900 font-bold">{{ number_format($donorCount) }}</strong> donatur terverifikasi
                    </span>
                    @if($campaign->end_date)
                        <span class="inline-flex items-center gap-2 {{ $campaign->is_expired ? 'text-rose-700 font-semibold' : 'text-slate-700' }}">
                            <span class="material-symbols-outlined text-lg {{ $campaign->is_expired ? 'text-rose-600' : 'text-desa-600' }}">schedule</span>
                            @if($campaign->is_expired)
                                <span>Program Telah Berakhir</span>
                            @else
                                <span>Sisa waktu: <strong class="text-slate-900 font-bold">{{ $campaign->end_date->diffInDays(now()) }}</strong> hari lagi</span>
                            @endif
                        </span>
                    @endif
                </div>
            </div>

            {{-- Bank Account & How to Donate --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8 space-y-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-desa-600">account_balance</span> Cara Berdonasi
                    </h2>
                    <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                        Salurkan donasi Anda melalui transfer langsung ke rekening resmi Nagari di bawah ini. Tim pengelola Nagari akan memverifikasi mutasi bank dan mencatat donasi Anda secara transparan.
                    </p>
                </div>

                {{-- Bank Accounts List --}}
                @if(!empty($donationSetting->bank_accounts))
                    <div class="space-y-4">
                        @foreach($donationSetting->bank_accounts as $account)
                            <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-colors hover:border-slate-300">
                                <div class="flex items-start sm:items-center gap-4">
                                    <div class="flex-shrink-0 h-12 w-12 rounded-xl bg-desa-100 text-desa-800 border border-desa-200 flex items-center justify-center font-bold">
                                        <span class="material-symbols-outlined text-2xl">account_balance</span>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-xs font-bold text-desa-700 uppercase tracking-wider block">
                                            {{ $account['bank'] ?? 'Bank' }}
                                        </span>
                                        <p class="text-xl sm:text-2xl font-bold text-slate-900 tracking-wider font-mono select-all">
                                            {{ $account['account_number'] ?? '-' }}
                                        </p>
                                        <p class="text-sm text-slate-600 mt-0.5">
                                            Atas Nama: <strong class="text-slate-800 font-semibold">{{ $account['account_name'] ?? '-' }}</strong>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex-shrink-0 sm:self-center" x-data="{ copied: false }">
                                    <button 
                                        type="button"
                                        @click="navigator.clipboard.writeText('{{ $account['account_number'] ?? '' }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border text-sm font-semibold transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-desa-500 focus-visible:ring-offset-2"
                                        :class="copied ? 'bg-emerald-700 text-white border-emerald-700 shadow-sm' : 'bg-white text-slate-800 border-slate-300 hover:bg-slate-100 hover:text-slate-900 shadow-xs'"
                                        aria-label="Salin nomor rekening {{ $account['bank'] ?? '' }}">
                                        <span class="material-symbols-outlined text-base" x-text="copied ? 'check' : 'content_copy'">content_copy</span>
                                        <span x-text="copied ? 'Tersalin!' : 'Salin Rekening'">Salin Rekening</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Transfer Instructions Notice --}}
                @if($donationSetting->transfer_instructions)
                    <div class="p-4 sm:p-5 bg-amber-50 border border-amber-300 rounded-xl flex items-start gap-3.5">
                        <span class="material-symbols-outlined text-amber-800 text-xl flex-shrink-0 mt-0.5">info</span>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-amber-900 uppercase tracking-wider mb-1">Petunjuk Khusus Donasi</p>
                            <p class="text-sm text-amber-950 leading-relaxed font-medium">
                                {{ $donationSetting->transfer_instructions }}
                            </p>
                        </div>
                    </div>
                @endif

                {{-- 3 Alur Steps --}}
                <div class="pt-2">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-600 mb-3">Alur & Tahapan Berdonasi</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="text-center p-5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col items-center">
                            <div class="inline-flex items-center justify-center h-11 w-11 rounded-full bg-desa-100 text-desa-700 border border-desa-200 mb-3 font-bold">
                                <span class="material-symbols-outlined text-xl">account_balance</span>
                            </div>
                            <p class="font-bold text-slate-900 text-sm">1. Transfer Dana</p>
                            <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">Transfer ke salah satu rekening resmi nagari di atas sesuai nominal keikhlasan Anda.</p>
                        </div>
                        <div class="text-center p-5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col items-center">
                            <div class="inline-flex items-center justify-center h-11 w-11 rounded-full bg-desa-100 text-desa-700 border border-desa-200 mb-3 font-bold">
                                <span class="material-symbols-outlined text-xl">verified</span>
                            </div>
                            <p class="font-bold text-slate-900 text-sm">2. Verifikasi Bank</p>
                            <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">Admin nagari mencocokkan mutasi rekening bank secara berkala setiap hari kerja.</p>
                        </div>
                        <div class="text-center p-5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col items-center">
                            <div class="inline-flex items-center justify-center h-11 w-11 rounded-full bg-desa-100 text-desa-700 border border-desa-200 mb-3 font-bold">
                                <span class="material-symbols-outlined text-xl">favorite</span>
                            </div>
                            <p class="font-bold text-slate-900 text-sm">3. Donasi Tercatat</p>
                            <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">Donasi Anda terkonfirmasi dan otomatis terdata pada daftar donatur di halaman ini.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            @if($campaign->description)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-desa-600">description</span> Tentang Program
                    </h2>
                    <div class="text-slate-700 leading-relaxed text-sm md:text-base whitespace-pre-line">
                        {{ $campaign->description }}
                    </div>
                </div>
            @endif

            {{-- Recent Donors --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-desa-600">volunteer_activism</span> Donatur Terbaru
                    </h2>
                    <span class="text-xs font-bold text-slate-700 bg-slate-100 border border-slate-200 px-3 py-1 rounded-lg">
                        {{ number_format($donorCount) }} Terverifikasi
                    </span>
                </div>

                @if($recentDonors->count())
                    <div class="space-y-3">
                        @foreach($recentDonors as $d)
                            <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200 hover:border-slate-300 transition-colors">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-desa-100 text-desa-700 border border-desa-200 flex items-center justify-center font-bold">
                                    <span class="material-symbols-outlined text-xl">person</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                                        <span class="font-bold text-slate-900 text-sm md:text-base truncate">{{ $d->display_name }}</span>
                                        <span class="font-extrabold text-emerald-700 text-sm md:text-base">Rp {{ number_format($d->amount, 0, ',', '.') }}</span>
                                    </div>
                                    @if($d->message && !$d->is_anonymous)
                                        <p class="text-xs md:text-sm text-slate-600 mt-1.5 leading-relaxed italic bg-white p-2.5 rounded-lg border border-slate-200">
                                            "{{ $d->message }}"
                                        </p>
                                    @endif
                                    <p class="text-xs text-slate-500 mt-2 font-medium flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs">schedule</span>
                                        {{ $d->paid_at?->diffForHumans() ?? 'Baru saja' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-slate-50 rounded-xl border border-slate-200 p-6">
                        <div class="inline-flex items-center justify-center h-14 w-14 rounded-full bg-white border border-slate-200 text-slate-400 mb-3">
                            <span class="material-symbols-outlined text-2xl">favorite_border</span>
                        </div>
                        <p class="font-bold text-slate-800 text-base">Belum Ada Donatur</p>
                        <p class="text-sm text-slate-600 mt-1 max-w-sm mx-auto leading-relaxed">Jadilah orang pertama yang berpartisipasi dalam program donasi nagari ini!</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
