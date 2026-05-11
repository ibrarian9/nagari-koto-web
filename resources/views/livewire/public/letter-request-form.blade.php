<div>
    <section class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('surat.info') }}" wire:navigate class="inline-flex items-center gap-1 text-sm text-desa-600 hover:text-desa-800 mb-4"><span class="material-symbols-outlined text-base">arrow_back</span> Kembali</a>
        <h1 class="section-title">Ajukan Permohonan Surat</h1>
        <p class="section-subtitle mb-8">Isi formulir di bawah ini dengan data yang benar</p>

        @if($submitted)
            <div class="card p-8 text-center">
                <span class="material-symbols-outlined text-5xl text-green-500 mb-4">check_circle</span>
                <h2 class="text-xl font-bold text-gray-900">Permohonan Berhasil Diajukan!</h2>
                <p class="text-gray-500 mt-2">Silakan pantau status permohonan Anda.</p>
                <a href="{{ route('surat.status') }}" wire:navigate class="btn-primary mt-6">Cek Status Surat</a>
            </div>
        @else
            <form wire:submit="submit" class="card p-6 space-y-5">
                <div>
                    <label class="form-label">Jenis Surat</label>
                    <select wire:model="letter_type" class="form-input w-full"><option value="">— Pilih Jenis Surat —</option>@foreach($letterTypes as $k => $v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select>
                    @error('letter_type')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" wire:model="full_name" class="form-input w-full" placeholder="Sesuai KTP">
                    @error('full_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">NIK (16 digit)</label>
                    <input type="text" wire:model="nik" class="form-input w-full" maxlength="16" placeholder="Nomor Induk Kependudukan">
                    @error('nik')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Alamat</label>
                    <textarea wire:model="address" class="form-input w-full" rows="3" placeholder="Alamat lengkap"></textarea>
                    @error('address')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Keperluan</label>
                    <textarea wire:model="purpose" class="form-input w-full" rows="2" placeholder="Opsional"></textarea>
                    @error('purpose')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
                    <span wire:loading.remove>Ajukan Permohonan</span>
                    <span wire:loading>Mengirim...</span>
                </button>
            </form>
        @endif
    </section>
</div>
