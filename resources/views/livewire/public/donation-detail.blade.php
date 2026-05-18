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

    <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 -mt-6 relative z-10 pb-16">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            {{-- LEFT: Campaign Info --}}
            <div class="lg:col-span-3 space-y-6">
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

            {{-- RIGHT: Donation Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sticky top-24">
                    <div class="text-center mb-5">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 mb-3">
                            <span class="material-symbols-outlined text-2xl text-rose-600">favorite</span>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg">Donasi Sekarang</h3>
                        <p class="text-sm text-gray-400 mt-1">Minimal Rp 10.000</p>
                    </div>

                    @if($campaign->status !== 'active' || $campaign->is_expired)
                        <div class="text-center py-8 px-4 bg-gray-50 rounded-xl">
                            <span class="material-symbols-outlined text-3xl text-gray-300">lock</span>
                            <p class="text-gray-500 font-medium mt-2">Campaign ini sudah ditutup</p>
                        </div>
                    @else
                        <form wire:submit="submitDonation" class="space-y-4">
                            {{-- Quick amount buttons --}}
                            <div>
                                <label class="form-label">Pilih Nominal</label>
                                <div class="grid grid-cols-3 gap-2 mb-2">
                                    @foreach([10000, 25000, 50000, 100000, 250000, 500000] as $preset)
                                        <button type="button" wire:click="$set('amount', {{ $preset }})"
                                            class="py-2 rounded-lg text-xs font-semibold transition-all {{ $amount == $preset ? 'bg-rose-500 text-white shadow-md shadow-rose-200' : 'bg-gray-100 text-gray-700 hover:bg-rose-50 hover:text-rose-600' }}">
                                            {{ number_format($preset / 1000) }}rb
                                        </button>
                                    @endforeach
                                </div>
                                <input type="number" wire:model="amount" class="form-input w-full" placeholder="Nominal lainnya" min="10000">
                                @error('amount')<p class="form-error">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="form-label">Nama <span class="text-red-400">*</span></label>
                                <input type="text" wire:model="donor_name" class="form-input w-full" placeholder="Nama Anda">
                                @error('donor_name')<p class="form-error">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="form-label">Email</label>
                                <input type="email" wire:model="donor_email" class="form-input w-full" placeholder="email@contoh.com">
                                @error('donor_email')<p class="form-error">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="form-label">No. HP</label>
                                <input type="text" wire:model="donor_phone" class="form-input w-full" placeholder="08xxxxxxxxxx">
                            </div>

                            <div>
                                <label class="form-label">Pesan / Doa</label>
                                <textarea wire:model="message" class="form-input w-full" rows="2" placeholder="Semoga bermanfaat..."></textarea>
                            </div>

                            <label class="inline-flex items-center gap-2.5 cursor-pointer select-none group">
                                <input type="checkbox" wire:model="is_anonymous" class="form-checkbox">
                                <span class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Donasi sebagai anonim</span>
                            </label>

                            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-rose-500 to-pink-600 text-white font-bold text-sm hover:from-rose-600 hover:to-pink-700 transition-all shadow-lg shadow-rose-200 flex items-center justify-center gap-2"
                                wire:loading.attr="disabled" wire:target="submitDonation">
                                <span wire:loading.remove wire:target="submitDonation" class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-base">favorite</span> Donasi Sekarang
                                </span>
                                <span wire:loading wire:target="submitDonation" class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Memproses...
                                </span>
                            </button>
                        </form>

                        <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-400">
                            <span class="material-symbols-outlined text-sm">lock</span>
                            Pembayaran aman via Midtrans
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Midtrans Snap.js --}}
    @push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}" defer></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('openSnap', ({ token }) => {
                if (typeof snap !== 'undefined') {
                    snap.pay(token, {
                        onSuccess: function(result) {
                            Swal.fire({ icon: 'success', title: 'Terima Kasih!', text: 'Donasi Anda berhasil. Semoga menjadi amal kebaikan.', confirmButtonColor: '#e11d48' });
                            setTimeout(() => window.location.reload(), 2000);
                        },
                        onPending: function(result) {
                            Swal.fire({ icon: 'info', title: 'Menunggu Pembayaran', text: 'Silakan selesaikan pembayaran Anda.', confirmButtonColor: '#e11d48' });
                        },
                        onError: function(result) {
                            Swal.fire({ icon: 'error', title: 'Pembayaran Gagal', text: 'Terjadi kesalahan. Silakan coba lagi.', confirmButtonColor: '#e11d48' });
                        },
                        onClose: function() {
                            // User closed popup without completing
                        }
                    });
                }
            });
        });
    </script>
    @endpush
</div>
