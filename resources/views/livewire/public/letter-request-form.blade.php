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
                {{-- Jenis Surat --}}
                <div>
                    <label class="form-label">Jenis Surat</label>
                    <select wire:model.live="letter_type" class="form-input w-full"><option value="">— Pilih Jenis Surat —</option>@foreach($letterTypes as $k => $v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select>
                    @error('letter_type')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Info Box Nikah --}}
                @if($isNikah)
                    <div x-data="{ showPdf: false }" class="relative">
                        {{-- Info Card --}}
                        <div class="rounded-2xl bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 border border-blue-200/60 p-5 space-y-4 shadow-sm">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 h-10 w-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-md shadow-blue-500/20">
                                    <span class="material-symbols-outlined text-white text-lg">info</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-sm">Persyaratan Surat Pengantar Nikah</h3>
                                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">Siapkan dokumen berikut sebelum mengisi formulir:</p>
                                </div>
                            </div>

                            {{-- Step indicators --}}
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div class="flex items-center gap-3 bg-white/70 rounded-xl p-3 border border-white shadow-sm">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center text-sm font-bold text-blue-700">1</div>
                                    <div class="text-xs"><p class="font-semibold text-gray-800">KTP Mempelai Pria</p><p class="text-gray-400">Foto/scan jelas</p></div>
                                </div>
                                <div class="flex items-center gap-3 bg-white/70 rounded-xl p-3 border border-white shadow-sm">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-lg bg-pink-100 flex items-center justify-center text-sm font-bold text-pink-700">2</div>
                                    <div class="text-xs"><p class="font-semibold text-gray-800">KTP Mempelai Wanita</p><p class="text-gray-400">Foto/scan jelas</p></div>
                                </div>
                                <div class="flex items-center gap-3 bg-white/70 rounded-xl p-3 border border-white shadow-sm">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-lg bg-amber-100 flex items-center justify-center text-sm font-bold text-amber-700">3</div>
                                    <div class="text-xs"><p class="font-semibold text-gray-800">Formulir N1</p><p class="text-gray-400">Diisi & difoto</p></div>
                                </div>
                            </div>

                            {{-- Action buttons --}}
                            @if($hasTemplate)
                                <div class="flex flex-wrap gap-2 pt-1">
                                    <button @click="showPdf = true" type="button"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-blue-200 hover:border-blue-400 hover:bg-blue-50 text-blue-700 text-sm font-medium transition-all shadow-sm hover:shadow">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                        Lihat Formulir N1
                                    </button>
                                    <a href="{{ asset('storage/templates/formulir-nikah-n1.pdf') }}" download
                                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-medium transition-all shadow-md shadow-blue-500/20 hover:shadow-lg">
                                        <span class="material-symbols-outlined text-lg">download</span>
                                        Simpan PDF
                                    </a>
                                </div>
                            @else
                                <p class="text-xs text-blue-500 italic flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm">info</span>
                                    Template formulir belum tersedia. Silakan minta formulir N1 di Kantor Nagari.
                                </p>
                            @endif
                        </div>

                        {{-- PDF Viewer Modal --}}
                        @if($hasTemplate)
                        <template x-teleport="body">
                            <div x-show="showPdf" x-transition.opacity.duration.200ms
                                 class="fixed inset-0 z-[999] flex items-center justify-center p-4"
                                 @keydown.escape.window="showPdf = false" style="display:none">
                                {{-- Backdrop --}}
                                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showPdf = false"></div>
                                {{-- Modal --}}
                                <div x-show="showPdf" x-transition.scale.origin.center.duration.200ms
                                     class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">
                                    {{-- Header --}}
                                    <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 bg-gray-50/80">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-lg bg-red-100 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-red-600 text-sm">picture_as_pdf</span>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900 text-sm">Formulir Nikah (N1)</h3>
                                                <p class="text-xs text-gray-400">Preview dokumen</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ asset('storage/templates/formulir-nikah-n1.pdf') }}" download
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-desa-600 hover:bg-desa-700 text-white text-xs font-medium transition-colors">
                                                <span class="material-symbols-outlined text-sm">download</span> Simpan
                                            </a>
                                            <button @click="showPdf = false" class="h-8 w-8 rounded-lg hover:bg-gray-200 flex items-center justify-center transition-colors">
                                                <span class="material-symbols-outlined text-gray-500">close</span>
                                            </button>
                                        </div>
                                    </div>
                                    {{-- PDF Embed --}}
                                    <div class="flex-1 min-h-0 bg-gray-100">
                                        <iframe x-bind:src="showPdf ? '{{ asset('storage/templates/formulir-nikah-n1.pdf') }}' : ''"
                                                class="w-full h-full min-h-[70vh]" frameborder="0"></iframe>
                                    </div>
                                </div>
                            </div>
                        </template>
                        @endif
                    </div>
                @endif

                {{-- Data Diri --}}
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

                {{-- ─── UPLOAD DOKUMEN ──────────────────────────────── --}}
                <div class="space-y-4">
                    <p class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg text-desa-500">upload_file</span>
                        Unggah Dokumen
                    </p>

                    {{-- KTP 1 (selalu tampil) --}}
                    @php $ktpLabel = $isNikah ? 'KTP Calon Mempelai Pria' : 'Foto KTP Pemohon'; @endphp
                    <div x-data="{ previewUrl: null }" class="space-y-2">
                        <label class="form-label text-sm">{{ $ktpLabel }} <span class="text-red-500">*</span></label>
                        <label class="block cursor-pointer">
                            <div class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-dashed border-gray-200 hover:border-desa-400 bg-gray-50 hover:bg-desa-50/30 transition-all text-sm text-gray-500">
                                <span class="material-symbols-outlined text-xl text-blue-400">person</span>
                                <div>
                                    <span class="font-medium text-gray-700" x-text="previewUrl ? 'Ganti foto' : 'Upload {{ $ktpLabel }}'">Upload {{ $ktpLabel }}</span>
                                    <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, WebP. Maks 2MB</p>
                                </div>
                            </div>
                            <input type="file" wire:model="ktp_image" accept="image/*" class="sr-only"
                                x-on:change="const f=$event.target.files[0]; if(f){const r=new FileReader(); r.onload=e=>previewUrl=e.target.result; r.readAsDataURL(f);}">
                        </label>
                        <template x-if="previewUrl">
                            <img :src="previewUrl" class="w-full max-h-40 object-contain rounded-lg border border-gray-200 bg-white p-1" alt="Preview KTP">
                        </template>
                        <div wire:loading wire:target="ktp_image" class="text-xs text-desa-600 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm animate-spin">progress_activity</span> Mengunggah...
                        </div>
                        @error('ktp_image')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- KTP 2 (hanya nikah) --}}
                    @if($isNikah)
                        <div x-data="{ previewUrl: null }" class="space-y-2">
                            <label class="form-label text-sm">KTP Calon Mempelai Wanita <span class="text-red-500">*</span></label>
                            <label class="block cursor-pointer">
                                <div class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-dashed border-pink-200 hover:border-pink-400 bg-pink-50/30 hover:bg-pink-50 transition-all text-sm text-gray-500">
                                    <span class="material-symbols-outlined text-xl text-pink-400">person</span>
                                    <div>
                                        <span class="font-medium text-gray-700" x-text="previewUrl ? 'Ganti foto' : 'Upload KTP Calon Mempelai Wanita'">Upload KTP Calon Mempelai Wanita</span>
                                        <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, WebP. Maks 2MB</p>
                                    </div>
                                </div>
                                <input type="file" wire:model="ktp_image_2" accept="image/*" class="sr-only"
                                    x-on:change="const f=$event.target.files[0]; if(f){const r=new FileReader(); r.onload=e=>previewUrl=e.target.result; r.readAsDataURL(f);}">
                            </label>
                            <template x-if="previewUrl">
                                <img :src="previewUrl" class="w-full max-h-40 object-contain rounded-lg border border-gray-200 bg-white p-1" alt="Preview KTP 2">
                            </template>
                            <div wire:loading wire:target="ktp_image_2" class="text-xs text-desa-600 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm animate-spin">progress_activity</span> Mengunggah...
                            </div>
                            @error('ktp_image_2')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        {{-- Formulir Nikah --}}
                        <div x-data="{ previewUrl: null }" class="space-y-2">
                            <label class="form-label text-sm">Formulir Nikah (N1) yang Sudah Diisi <span class="text-red-500">*</span></label>
                            <label class="block cursor-pointer">
                                <div class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-dashed border-amber-200 hover:border-amber-400 bg-amber-50/30 hover:bg-amber-50 transition-all text-sm text-gray-500">
                                    <span class="material-symbols-outlined text-xl text-amber-500">description</span>
                                    <div>
                                        <span class="font-medium text-gray-700" x-text="previewUrl ? 'Ganti foto formulir' : 'Upload Formulir Nikah (foto/scan)'">Upload Formulir Nikah (foto/scan)</span>
                                        <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, WebP. Maks 4MB</p>
                                    </div>
                                </div>
                                <input type="file" wire:model="nikah_form_image" accept="image/*" class="sr-only"
                                    x-on:change="const f=$event.target.files[0]; if(f){const r=new FileReader(); r.onload=e=>previewUrl=e.target.result; r.readAsDataURL(f);}">
                            </label>
                            <template x-if="previewUrl">
                                <img :src="previewUrl" class="w-full max-h-40 object-contain rounded-lg border border-gray-200 bg-white p-1" alt="Preview Formulir">
                            </template>
                            <div wire:loading wire:target="nikah_form_image" class="text-xs text-desa-600 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm animate-spin">progress_activity</span> Mengunggah...
                            </div>
                            @error('nikah_form_image')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    @endif
                </div>

                {{-- Keperluan --}}
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
