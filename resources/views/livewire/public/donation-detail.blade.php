<div>
    {{-- ─── HERO ─────────────────────────────────────────── --}}
    <section class="relative bg-gradient-to-br from-rose-700 via-rose-800 to-pink-900 overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 right-0 w-96 h-96 bg-rose-400/10 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-pink-300/10 rounded-full blur-3xl -translate-x-1/3 translate-y-1/3"></div>
        </div>
        <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <a href="{{ route('donasi') }}" wire:navigate class="inline-flex items-center gap-1.5 text-rose-300 hover:text-white text-sm font-medium mb-4 transition-colors">
                <span class="material-symbols-outlined text-base">arrow_back</span> Kembali ke Donasi
            </a>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                {{ $campaign->title }}
            </h1>
            <p class="mt-2 text-rose-200 text-sm">
                Dibuat oleh {{ $campaign->creator?->name ?? 'Admin' }} · {{ $campaign->start_date->format('d M Y') }}
                @if($campaign->end_date) — {{ $campaign->end_date->format('d M Y') }}@endif
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 -mt-6 relative z-10 pb-16">
        <div class="space-y-6">
            {{-- Image --}}
            @if($campaign->thumbnail)
                <div class="rounded-2xl overflow-hidden shadow-lg">
                    <img src="{{ Storage::url($campaign->thumbnail) }}" alt="{{ $campaign->title }}" class="w-full aspect-video object-cover" loading="lazy" decoding="async">
                </div>
            @endif

            {{-- Progress Card --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-2xl font-extrabold text-green-600">Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-400">terkumpul dari target Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</p>
                    </div>
                    <span class="text-2xl font-bold {{ $campaign->progress_percent >= 100 ? 'text-green-600' : 'text-gray-400' }}">{{ $campaign->progress_percent }}%</span>
                </div>
                <div class="h-3 bg-gray-100 rounded-full overflow-hidden mb-4">
                    <div class="h-full bg-gradient-to-r from-rose-400 to-pink-500 rounded-full transition-all duration-700" style="width: {{ min(100, $campaign->progress_percent) }}%"></div>
                </div>
                <div class="flex items-center gap-6 text-sm text-gray-500">
                    <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-base text-rose-400">group</span> {{ $donorCount }} donatur</span>
                    @if($campaign->end_date)
                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-base text-rose-400">schedule</span>
                            @if($campaign->is_expired) Berakhir @else {{ $campaign->end_date->diffInDays(now()) }} hari lagi @endif
                        </span>
                    @endif
                </div>
            </div>

            {{-- Bank Account & How to Donate --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-2 flex items-center gap-2 text-lg">
                    <span class="material-symbols-outlined text-rose-500">account_balance</span> Cara Berdonasi
                </h3>
                <p class="text-sm text-gray-500 mb-5">Transfer langsung ke rekening resmi Nagari di bawah ini. Admin akan mencatat donasi Anda setelah memverifikasi mutasi bank.</p>

                @if(!empty($donationSetting->bank_accounts))
                    <div class="space-y-3 mb-5">
                        @foreach($donationSetting->bank_accounts as $account)
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-gray-50 to-rose-50/30 rounded-xl border border-gray-100 group hover:border-rose-200 transition-colors">
                                <div class="flex-shrink-0 h-12 w-12 rounded-xl bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center shadow-md">
                                    <span class="material-symbols-outlined text-white text-xl">account_balance</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-rose-600 uppercase tracking-wider">{{ $account['bank'] ?? 'Bank' }}</p>
                                    <p class="text-lg font-bold text-gray-900 tracking-wide font-mono">{{ $account['account_number'] ?? '-' }}</p>
                                    <p class="text-sm text-gray-500">a.n. {{ $account['account_name'] ?? '-' }}</p>
                                </div>
                                <button onclick="navigator.clipboard.writeText('{{ $account['account_number'] ?? '' }}'); this.querySelector('span').textContent='check'; setTimeout(() => this.querySelector('span').textContent='content_copy', 1500)"
                                    class="flex-shrink-0 h-9 w-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-400 hover:text-rose-500 hover:border-rose-300 transition-all shadow-sm" title="Salin nomor rekening">
                                    <span class="material-symbols-outlined text-base">content_copy</span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($donationSetting->transfer_instructions)
                    <div class="p-4 bg-amber-50 border border-amber-200/60 rounded-xl flex items-start gap-3">
                        <span class="material-symbols-outlined text-amber-500 text-base mt-0.5">info</span>
                        <p class="text-sm text-amber-700 leading-relaxed">{{ $donationSetting->transfer_instructions }}</p>
                    </div>
                @endif

                {{-- Steps --}}
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach([
                        ['icon' => 'account_balance', 'step' => '1', 'title' => 'Transfer', 'desc' => 'Transfer ke rekening di atas sesuai nominal yang Anda inginkan'],
                        ['icon' => 'verified', 'step' => '2', 'title' => 'Verifikasi', 'desc' => 'Admin akan memverifikasi melalui mutasi rekening bank'],
                        ['icon' => 'favorite', 'step' => '3', 'title' => 'Tercatat', 'desc' => 'Donasi Anda tercatat dan dipublikasikan di halaman ini'],
                    ] as $s)
                        <div class="text-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-rose-100 text-rose-600 mb-2">
                                <span class="material-symbols-outlined text-lg">{{ $s['icon'] }}</span>
                            </div>
                            <p class="font-bold text-gray-900 text-sm">{{ $s['title'] }}</p>
                            <p class="text-xs text-gray-400 mt-1 leading-relaxed">{{ $s['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Description --}}
            @if($campaign->description)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-rose-500">description</span> Tentang Program
                    </h3>
                    <div class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $campaign->description }}</div>
                </div>
            @endif

            {{-- Recent Donors --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-rose-500">volunteer_activism</span> Donatur Terbaru
                </h3>
                @if($recentDonors->count())
                    <div class="space-y-3">
                        @foreach($recentDonors as $d)
                            <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 hover:bg-rose-50/50 transition-colors">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-lg text-rose-400">person</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold text-gray-800 text-sm">{{ $d->display_name }}</span>
                                        <span class="font-bold text-green-600 text-sm">Rp {{ number_format($d->amount, 0, ',', '.') }}</span>
                                    </div>
                                    @if($d->message && !$d->is_anonymous)
                                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $d->message }}</p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">{{ $d->paid_at?->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <span class="material-symbols-outlined text-3xl text-gray-200">favorite_border</span>
                        <p class="text-sm text-gray-400 mt-2">Jadilah donatur pertama!</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
