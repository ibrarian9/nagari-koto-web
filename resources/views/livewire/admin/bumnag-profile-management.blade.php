<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Profil BUMNag</h2><p class="text-sm text-gray-500 mt-0.5">Kelola profil, visi misi, unit usaha, dan badan hukum BUMNag</p></div>
    </div>

    <x-page-guide title="Panduan BUMNag" description="Isi data profil lengkap BUMNag termasuk visi & misi, kontak, unit usaha, serta dokumen badan hukum (SK Pendirian & Dokumen PDF). Data ini akan tampil di halaman publik BUMNag." />

    <form wire:submit="save" class="space-y-8">
        {{-- Profil Dasar --}}
        <div class="card p-6">
            <h3 class="text-base font-bold text-gray-900 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-600">store</span> Informasi Dasar
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2"><label class="form-label">Nama BUMNag <span class="text-red-400">*</span></label><input type="text" wire:model="name" class="form-input w-full" placeholder="cth: BUMNag Duo Koto Mandiri">@error('name')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div class="md:col-span-2"><label class="form-label">Deskripsi</label><textarea wire:model="description" class="form-input w-full" rows="4" placeholder="Deskripsi singkat tentang BUMNag"></textarea></div>
                <div class="md:col-span-2"><label class="form-label">Sejarah BUMNag</label><textarea wire:model="sejarah" class="form-input w-full" rows="5" placeholder="Ceritakan sejarah pendirian dan perkembangan BUMNag..."></textarea></div>
                <div><label class="form-label">Visi</label><textarea wire:model="visi" class="form-input w-full" rows="3" placeholder="Visi BUMNag"></textarea></div>
                <div><label class="form-label">Misi</label><textarea wire:model="misi" class="form-input w-full" rows="3" placeholder="Misi BUMNag (pisahkan per baris)"></textarea></div>
            </div>
        </div>

        {{-- Kontak --}}
        <div class="card p-6">
            <h3 class="text-base font-bold text-gray-900 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-600">contact_phone</span> Kontak
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div><label class="form-label">Alamat</label><input type="text" wire:model="alamat" class="form-input w-full" placeholder="Alamat kantor"></div>
                <div><label class="form-label">Telepon</label><input type="text" wire:model="telepon" class="form-input w-full" placeholder="08xx"></div>
                <div><label class="form-label">Email</label><input type="email" wire:model="email" class="form-input w-full" placeholder="bumnag@nagari.id"></div>
            </div>
        </div>

        {{-- Logo --}}
        <div class="card p-6">
            <h3 class="text-base font-bold text-gray-900 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-600">image</span> Logo
            </h3>
            <x-admin-image-upload wireModel="logo" label="Logo BUMNag" :existingUrl="$existingLogo ? Storage::url($existingLogo) : null" icon="store" />
        </div>

        {{-- Unit Usaha --}}
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-desa-600">storefront</span> Unit Usaha
                </h3>
                <button type="button" wire:click="addUnit" class="btn-secondary btn-sm">
                    <span class="material-symbols-outlined text-base">add</span> Tambah Unit
                </button>
            </div>
            @if (count($units))
                <div class="space-y-4">
                    @foreach ($units as $i => $unit)
                        <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div><label class="form-label text-xs">Nama Unit</label><input type="text" wire:model="units.{{ $i }}.nama" class="form-input w-full" placeholder="Nama unit usaha"></div>
                                <div><label class="form-label text-xs">Deskripsi</label><input type="text" wire:model="units.{{ $i }}.deskripsi" class="form-input w-full" placeholder="Deskripsi singkat"></div>
                            </div>
                            <button type="button" wire:click="removeUnit({{ $i }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors mt-6">
                                <span class="material-symbols-outlined text-lg">delete</span>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 italic">Belum ada unit usaha. Klik tombol "Tambah Unit" untuk menambahkan.</p>
            @endif
        </div>

        {{-- Badan Hukum --}}
        <div class="card p-6">
            <h3 class="text-base font-bold text-gray-900 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-600">gavel</span> Badan Hukum
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="form-label">Nomor SK Pendirian</label><input type="text" wire:model="sk_pendirian" class="form-input w-full" placeholder="Nomor SK"></div>
                <div><label class="form-label">Tanggal Pendirian</label><input type="date" wire:model="tanggal_pendirian" class="form-input w-full"></div>
            </div>

            {{-- PDF Badan Hukum (ditampilkan di halaman publik) --}}
            <div class="mt-5 p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                <label class="form-label flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600 text-base">picture_as_pdf</span>
                    Dokumen Badan Hukum — PDF untuk halaman publik (maks 10MB)
                </label>
                <p class="text-xs text-gray-500 mb-3">File ini yang akan ditampilkan langsung di halaman Badan Hukum BUMNag pada website.</p>
                <input type="file" wire:model="badan_hukum_file_upload" accept=".pdf" class="form-input w-full text-sm">
                @if ($existingBadanHukum)
                    <p class="text-xs text-desa-600 mt-2 flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">check_circle</span>
                        Dokumen badan hukum sudah terunggah. <a href="{{ Storage::url($existingBadanHukum) }}" target="_blank" class="underline">Lihat</a>
                    </p>
                @endif
                @error('badan_hukum_file_upload')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save">
                <span wire:loading.remove wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base">save</span> Simpan Semua</span>
                <span wire:loading wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...</span>
            </button>
        </div>
    </form>
</div>
