{{-- ─── KOMENTAR PPID ─────────────────────────────────── --}}
<section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Approved Comments --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-500">forum</span> Komentar Masyarakat
            </h2>
            @if ($approvedComments->count())
                <div class="space-y-4">
                    @foreach ($approvedComments as $cmt)
                        <div class="card p-5">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="h-8 w-8 rounded-full bg-desa-100 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-desa-600 text-sm">person</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-900 text-sm">{{ $cmt->nama }}</span>
                                    <span class="text-xs text-gray-400 ml-2">{{ $cmt->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $cmt->komentar }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card p-8 text-center">
                    <span class="material-symbols-outlined text-4xl text-gray-200 mb-2">chat_bubble_outline</span>
                    <p class="text-gray-400 text-sm">Belum ada komentar.</p>
                </div>
            @endif
        </div>

        {{-- Comment Form --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-500">edit</span> Kirim Komentar
            </h2>

            @if ($cmtSubmitted)
                <div class="card p-8 text-center">
                    <span class="material-symbols-outlined text-5xl text-green-500 mb-3">check_circle</span>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Komentar Terkirim!</h3>
                    <p class="text-sm text-gray-500 mb-4">Komentar Anda akan tampil setelah disetujui oleh admin.</p>
                    <button wire:click="resetCommentForm" class="btn-secondary">Kirim Komentar Lain</button>
                </div>
            @else
                <div class="card p-6">
                    {{-- Notice --}}
                    <div class="rounded-lg bg-amber-50 border border-amber-200 p-3 flex items-start gap-2 mb-5">
                        <span class="material-symbols-outlined text-amber-500 text-base mt-0.5">info</span>
                        <p class="text-xs text-amber-700">Komentar akan ditampilkan setelah disetujui oleh admin. Harap gunakan bahasa yang sopan dan santun.</p>
                    </div>

                    <form wire:submit="submitComment" class="space-y-4">
                        <div>
                            <label class="form-label">Komentar <span class="text-red-400">*</span></label>
                            <textarea wire:model="cmtKomentar" class="form-input w-full" rows="4" placeholder="Tulis komentar Anda..." required></textarea>
                            @error('cmtKomentar')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Nama <span class="text-red-400">*</span></label>
                                <input type="text" wire:model="cmtNama" class="form-input w-full" placeholder="Nama Anda" required>
                                @error('cmtNama')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label">No HP <span class="text-red-400">*</span></label>
                                <input type="text" wire:model="cmtNoHp" class="form-input w-full" placeholder="08xxxxxxxxxx" required>
                                @error('cmtNoHp')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Alamat Email <span class="text-gray-400 text-xs">(opsional)</span></label>
                            <input type="email" wire:model="cmtEmail" class="form-input w-full" placeholder="email@contoh.com">
                        </div>

                        {{-- Simple CAPTCHA --}}
                        <div>
                            <label class="form-label">Kode Captcha <span class="text-red-400">*</span></label>
                            <div class="flex items-center gap-3 mb-2">
                                <div class="px-5 py-2.5 bg-gray-800 rounded-lg select-none" style="letter-spacing: 6px;">
                                    <span class="text-xl font-bold text-white font-mono tracking-widest" style="text-decoration: line-through; text-decoration-color: rgba(255,255,255,0.3);">{{ $captchaCode }}</span>
                                </div>
                                <button type="button" wire:click="generateCaptcha" class="text-desa-600 hover:text-desa-700 transition-colors" title="Generate ulang">
                                    <span class="material-symbols-outlined">refresh</span>
                                </button>
                            </div>
                            <input type="text" wire:model="cmtCaptcha" class="form-input w-full" placeholder="Masukkan kode di atas" required>
                            @error('cmtCaptcha')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="btn-primary w-full justify-center" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submitComment" class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base">send</span> Kirim Komentar
                            </span>
                            <span wire:loading wire:target="submitComment" class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Mengirim...
                            </span>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</section>
