<div>
    <section class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="section-title">Permohonan Informasi Publik</h1>
        <p class="section-subtitle mb-8">Isi formulir di bawah ini untuk mengajukan permohonan informasi</p>

        @if($submitted)
            <div class="card p-8 text-center">
                <span class="material-symbols-outlined text-5xl text-green-500 mb-4">check_circle</span>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Permohonan Berhasil Dikirim!</h2>
                <p class="text-gray-500 mb-4">Simpan nomor permohonan Anda untuk melacak status:</p>
                <div class="inline-block bg-desa-50 border border-desa-200 rounded-xl px-6 py-3 mb-6">
                    <p class="text-xs text-desa-500 mb-1">Nomor Permohonan</p>
                    <p class="text-2xl font-bold text-desa-700 tracking-wide font-mono">{{ $nomor }}</p>
                </div>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('ppid.cek-status') }}" wire:navigate class="btn-primary">
                        <span class="material-symbols-outlined">search</span> Cek Status
                    </a>
                    <a href="{{ route('ppid.home') }}" wire:navigate class="btn-secondary">Kembali ke PPID</a>
                </div>
            </div>
        @else
            <div class="rounded-xl bg-blue-50 border border-blue-200 p-4 flex items-start gap-3 mb-6">
                <span class="material-symbols-outlined text-blue-500 mt-0.5">info</span>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Informasi Penting</p>
                    <p>Berdasarkan UU No. 14 Tahun 2008, setiap warga negara berhak memperoleh informasi publik. Permohonan akan diproses dalam waktu <strong>10 hari kerja</strong>.</p>
                </div>
            </div>

            <form wire:submit="submit" class="card p-6 space-y-5">
                <p class="text-sm font-semibold text-gray-700 flex items-center gap-2 pb-2 border-b border-gray-100">
                    <span class="material-symbols-outlined text-lg text-desa-500">person</span> Data Pemohon
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Nama Pemohon <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="nama_pemohon" class="form-input w-full" placeholder="Nama lengkap">
                        @error('nama_pemohon')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">NIK (16 digit) <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="nik" class="form-input w-full" maxlength="16" placeholder="Nomor Induk Kependudukan">
                        @error('nik')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="no_telepon" class="form-input w-full" placeholder="08xxxxxxxxxx">
                        @error('no_telepon')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Email <span class="text-gray-400 text-xs">(opsional)</span></label>
                        <input type="email" wire:model="email" class="form-input w-full" placeholder="email@contoh.com">
                        @error('email')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="form-label">Alamat <span class="text-red-500">*</span></label>
                    <textarea wire:model="alamat" class="form-input w-full" rows="2" placeholder="Alamat lengkap"></textarea>
                    @error('alamat')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <p class="text-sm font-semibold text-gray-700 flex items-center gap-2 pb-2 border-b border-gray-100 pt-2">
                    <span class="material-symbols-outlined text-lg text-desa-500">description</span> Detail Informasi
                </p>

                <div>
                    <label class="form-label">Informasi yang Diminta <span class="text-red-500">*</span></label>
                    <textarea wire:model="informasi_diminta" class="form-input w-full" rows="3" placeholder="Jelaskan informasi apa yang Anda butuhkan secara detail..."></textarea>
                    @error('informasi_diminta')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Tujuan Penggunaan Informasi <span class="text-red-500">*</span></label>
                    <textarea wire:model="tujuan_penggunaan" class="form-input w-full" rows="2" placeholder="Jelaskan untuk apa informasi ini akan digunakan..."></textarea>
                    @error('tujuan_penggunaan')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Format Informasi <span class="text-red-500">*</span></label>
                        <select wire:model="format_informasi" class="form-input w-full">
                            @foreach($formatOptions as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        @error('format_informasi')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Cara Mendapatkan <span class="text-red-500">*</span></label>
                        <select wire:model="cara_mendapatkan" class="form-input w-full">
                            @foreach($caraOptions as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        @error('cara_mendapatkan')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- KTP Upload --}}
                <div x-data="{ previewUrl: null }" class="space-y-2">
                    <label class="form-label">Lampiran KTP <span class="text-gray-400 text-xs">(opsional)</span></label>
                    <label class="block cursor-pointer">
                        <div class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-dashed border-gray-200 hover:border-desa-400 bg-gray-50 hover:bg-desa-50/30 transition-all text-sm text-gray-500">
                            <span class="material-symbols-outlined text-xl text-gray-400">photo_camera</span>
                            <div>
                                <span class="font-medium text-gray-700" x-text="previewUrl ? 'Ganti foto' : 'Upload foto KTP'">Upload foto KTP</span>
                                <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, WebP. Maks 2MB</p>
                            </div>
                        </div>
                        <input type="file" wire:model="lampiran" accept="image/*" class="sr-only"
                            x-on:change="const f=$event.target.files[0]; if(f){const r=new FileReader(); r.onload=e=>previewUrl=e.target.result; r.readAsDataURL(f);}">
                    </label>
                    <template x-if="previewUrl">
                        <img :src="previewUrl" class="w-full max-h-40 object-contain rounded-lg border border-gray-200 bg-white p-1" alt="Preview">
                    </template>
                    <div wire:loading wire:target="lampiran" class="text-xs text-desa-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm animate-spin">progress_activity</span> Mengunggah...
                    </div>
                    @error('lampiran')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
                    <span wire:loading.remove>Kirim Permohonan</span>
                    <span wire:loading>Mengirim...</span>
                </button>
            </form>
        @endif
    </section>
</div>
