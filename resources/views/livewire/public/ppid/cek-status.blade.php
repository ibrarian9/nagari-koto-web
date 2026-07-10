<div>
    <section class="mx-auto max-w-xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-gradient-to-br from-violet-500 to-violet-600 mb-4 shadow-lg shadow-violet-500/20">
                <span class="material-symbols-outlined text-white text-2xl">search</span>
            </div>
            <h1 class="section-title">Cek Status Permohonan</h1>
            <p class="section-subtitle">Masukkan nomor permohonan untuk melihat status</p>
        </div>

        <form wire:submit="cekStatus" class="card p-6 mb-6">
            <label class="form-label">Nomor Permohonan</label>
            <div class="flex gap-2">
                <input type="text" wire:model="nomor_permohonan" class="form-input flex-1 font-mono" placeholder="PPID-2026-05-0001">
                <button type="submit" class="btn-primary whitespace-nowrap" wire:loading.attr="disabled">
                    <span wire:loading.remove>Lacak</span>
                    <span wire:loading>Mencari...</span>
                </button>
            </div>
            @error('nomor_permohonan')<p class="form-error">{{ $message }}</p>@enderror
        </form>

        @if($searched)
            @if($result)
                <div class="card p-6 space-y-4">
                    {{-- Status Badge --}}
                    <div class="text-center">
                        <span class="badge {{ $result->status_color }} text-base px-4 py-1.5">{{ $result->status_label }}</span>
                    </div>

                    {{-- Details --}}
                    <div class="divide-y divide-gray-100 text-sm">
                        <div class="flex justify-between py-2.5">
                            <span class="text-gray-500">Nomor Permohonan</span>
                            <span class="font-mono font-semibold text-gray-900">{{ $result->nomor_permohonan }}</span>
                        </div>
                        <div class="flex justify-between py-2.5">
                            <span class="text-gray-500">Nama Pemohon</span>
                            <span class="text-gray-900">{{ $result->nama_pemohon }}</span>
                        </div>
                        <div class="flex justify-between py-2.5">
                            <span class="text-gray-500">Tanggal Pengajuan</span>
                            <span class="text-gray-900">{{ $result->created_at->isoFormat('D MMMM Y') }}</span>
                        </div>
                        <div class="flex justify-between py-2.5">
                            <span class="text-gray-500">Informasi Diminta</span>
                            <span class="text-gray-900 text-right max-w-[60%]">{{ Str::limit($result->informasi_diminta, 100) }}</span>
                        </div>
                        @if($result->catatan_petugas)
                            <div class="flex justify-between py-2.5">
                                <span class="text-gray-500">Catatan Petugas</span>
                                <span class="text-gray-900 text-right max-w-[60%]">{{ $result->catatan_petugas }}</span>
                            </div>
                        @endif
                        @if($result->status === 'selesai' && $result->tanggal_selesai)
                            <div class="flex justify-between py-2.5">
                                <span class="text-gray-500">Tanggal Selesai</span>
                                <span class="text-gray-900">{{ $result->tanggal_selesai->isoFormat('D MMMM Y') }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Download if available --}}
                    @if($result->status === 'selesai' && $result->dokumen_balasan)
                        <a href="{{ Storage::url($result->dokumen_balasan) }}" target="_blank" class="btn-primary w-full flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">download</span>
                            Download Dokumen Balasan
                        </a>
                    @endif

                    {{-- Overdue warning --}}
                    @if($result->is_overdue)
                        <div class="rounded-lg bg-amber-50 border border-amber-200 p-3 flex items-start gap-2 text-sm text-amber-800">
                            <span class="material-symbols-outlined text-amber-500 text-base mt-0.5">warning</span>
                            <p>Permohonan ini sudah melebihi batas waktu 10 hari kerja. Silakan hubungi kantor nagari untuk informasi lebih lanjut.</p>
                        </div>
                    @endif
                </div>
            @else
                <div class="card p-8 text-center">
                    <span class="material-symbols-outlined text-4xl text-red-300 mb-3">search_off</span>
                    <p class="text-gray-600 font-medium">{{ $errorMessage }}</p>
                </div>
            @endif
        @endif
    </section>
</div>
