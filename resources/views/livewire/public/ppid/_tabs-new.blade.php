{{-- Tab 5: Informasi Publik --}}
<div x-show="tab === 'dip'" x-transition>
    <!-- Statistik Dokumen -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-150 p-4 shadow-xs cursor-pointer hover:border-blue-200 transition-colors"
            @click="sub = 'info_berkala'">
            <div class="flex justify-between items-start">
                <span class="material-symbols-outlined text-blue-500 text-lg">schedule</span>
                <span class="text-2xl font-black text-gray-900">{{ $berkalaCount }}</span>
            </div>
            <p class="text-[10px] text-gray-450 font-bold uppercase tracking-wider mt-2">Info Berkala</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-150 p-4 shadow-xs cursor-pointer hover:border-emerald-200 transition-colors"
            @click="sub = 'info_setiapsaat'">
            <div class="flex justify-between items-start">
                <span class="material-symbols-outlined text-emerald-500 text-lg">folder_open</span>
                <span class="text-2xl font-black text-gray-900">{{ $setiapSaatCount }}</span>
            </div>
            <p class="text-[10px] text-gray-450 font-bold uppercase tracking-wider mt-2">Info Setiap Saat</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-150 p-4 shadow-xs cursor-pointer hover:border-amber-200 transition-colors"
            @click="sub = 'info_sertamerta'">
            <div class="flex justify-between items-start">
                <span class="material-symbols-outlined text-amber-500 text-lg">campaign</span>
                <span class="text-2xl font-black text-gray-900">{{ $sertaMertaCount }}</span>
            </div>
            <p class="text-[10px] text-gray-450 font-bold uppercase tracking-wider mt-2">Info Serta Merta</p>
        </div>
    </div>

    <!-- Sub-tab Switcher -->
    <div
        class="flex gap-1.5 bg-gray-100 p-1 rounded-xl border border-gray-200/50 w-fit max-w-full overflow-x-auto scrollbar-none mb-6">
        @foreach ([['key' => 'info_berkala', 'label' => 'Info Berkala', 'icon' => 'schedule'], ['key' => 'info_setiapsaat', 'label' => 'Info Setiap Saat', 'icon' => 'folder_open'], ['key' => 'info_sertamerta', 'label' => 'Info Serta Merta', 'icon' => 'campaign']] as $s)
            <button @click="sub = '{{ $s['key'] }}'"
                :class="sub === '{{ $s['key'] }}' ? 'bg-white text-desa-700 shadow-xs' : 'text-gray-600 hover:text-gray-900'"
                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition-all duration-150 active:scale-[0.98]">
                <span class="material-symbols-outlined text-base">{{ $s['icon'] }}</span> {{ $s['label'] }}
            </button>
        @endforeach
    </div>

    <!-- Search -->
    <div class="card p-4 mb-6">
        <div class="relative">
            <span
                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
            <input type="text" wire:model.live.debounce.300ms="infoSearch" class="form-input w-full pl-10"
                placeholder="Cari dokumen atau pengumuman...">
        </div>
    </div>

    <div class="space-y-6">
        {{-- Sub-tab: Info Berkala --}}
        <div x-show="sub === 'info_berkala'">
            <div class="space-y-3">
                @forelse ($berkalaItems as $item)
                    <div
                        class="card p-5 flex flex-col sm:flex-row sm:items-center gap-4 hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex-shrink-0">
                            @php $ext = $item->file_extension; @endphp
                            <div
                                class="h-12 w-12 rounded-xl flex items-center justify-center text-xs font-bold {{ $ext === 'PDF' ? 'bg-red-100 text-red-700' : ($ext === 'DOC' || $ext === 'DOCX' ? 'bg-blue-100 text-blue-700' : ($ext === 'XLS' || $ext === 'XLSX' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700')) }}">
                                {{ $ext }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 text-sm">{{ $item->title }}</h3>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-xs text-gray-400">
                                <span class="badge bg-blue-50 text-blue-700">{{ $item->category_label }}</span>
                                <span>Tahun {{ $item->year }}</span>
                                <span>{{ $item->file_size_formatted }}</span>
                                <span class="flex items-center gap-0.5"><span
                                        class="material-symbols-outlined text-xs">download</span>
                                    {{ number_format($item->download_count) }}×</span>
                            </div>
                            @if ($item->description)
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $item->description }}</p>
                            @endif
                        </div>
                        <button wire:click="downloadBerkala({{ $item->id }})"
                            class="btn-primary btn-sm whitespace-nowrap flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">download</span>
                            Download
                        </button>
                    </div>
                @empty
                    <div class="card p-12 text-center">
                        <span class="material-symbols-outlined text-4xl text-gray-300 mb-3">folder_off</span>
                        <p class="text-gray-400">Belum ada dokumen informasi berkala.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-6">{{ $berkalaItems->links() }}</div>
        </div>

        {{-- Sub-tab: Info Setiap Saat --}}
        <div x-show="sub === 'info_setiapsaat'">
            <div class="space-y-3">
                @forelse ($setiapSaatItems as $item)
                    <div
                        class="card p-5 flex flex-col sm:flex-row sm:items-center gap-4 hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex-shrink-0">
                            @php $ext = $item->file_extension; @endphp
                            <div
                                class="h-12 w-12 rounded-xl flex items-center justify-center text-xs font-bold {{ $ext === 'PDF' ? 'bg-red-100 text-red-700' : ($ext === 'DOC' || $ext === 'DOCX' ? 'bg-blue-100 text-blue-700' : ($ext === 'XLS' || $ext === 'XLSX' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700')) }}">
                                {{ $ext }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 text-sm">{{ $item->title }}</h3>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-xs text-gray-400">
                                <span class="badge bg-emerald-50 text-emerald-700">{{ $item->category_label }}</span>
                                <span>Tahun {{ $item->year }}</span>
                                <span>{{ $item->file_size_formatted }}</span>
                                <span class="flex items-center gap-0.5"><span
                                        class="material-symbols-outlined text-xs">download</span>
                                    {{ number_format($item->download_count) }}×</span>
                            </div>
                            @if ($item->description)
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $item->description }}</p>
                            @endif
                        </div>
                        <button wire:click="downloadSetiapSaat({{ $item->id }})"
                            class="btn-primary btn-sm whitespace-nowrap flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">download</span>
                            Download
                        </button>
                    </div>
                @empty
                    <div class="card p-12 text-center">
                        <span class="material-symbols-outlined text-4xl text-gray-300 mb-3">folder_off</span>
                        <p class="text-gray-400">Belum ada dokumen informasi setiap saat.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-6">{{ $setiapSaatItems->links() }}</div>
        </div>

        {{-- Sub-tab: Info Serta Merta --}}
        <div x-show="sub === 'info_sertamerta'">
            <div class="space-y-4">
                @forelse ($sertaMertaItems as $item)
                    <div
                        class="card p-5 border-l-4 {{ $item->urgency === 'kritis' ? 'border-l-red-500' : ($item->urgency === 'tinggi' ? 'border-l-orange-500' : ($item->urgency === 'sedang' ? 'border-l-amber-500' : 'border-l-blue-500')) }}">
                        <div class="flex items-start gap-3">
                            <span
                                class="material-symbols-outlined mt-0.5 {{ $item->urgency === 'kritis' ? 'text-red-500' : ($item->urgency === 'tinggi' ? 'text-orange-500' : ($item->urgency === 'sedang' ? 'text-amber-500' : 'text-blue-500')) }}">{{ $item->urgency_icon }}</span>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <span
                                        class="badge {{ $item->urgency_color }} text-xs">{{ $item->urgency_label }}</span>
                                    <span
                                        class="text-xs text-gray-400">{{ $item->published_at?->isoFormat('D MMMM Y, HH:mm') }}
                                        WIB</span>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-2">{{ $item->title }}</h3>
                                @if ($item->content)
                                    <div class="prose prose-sm max-w-none text-gray-600">{!! $item->content !!}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card p-12 text-center">
                        <span class="material-symbols-outlined text-4xl text-green-300 mb-3">verified_user</span>
                        <p class="text-gray-400 font-medium">Tidak ada pengumuman darurat saat ini.</p>
                        <p class="text-gray-400 text-sm mt-1">Situasi aman, tidak ada informasi serta merta yang perlu
                            disampaikan.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-6">{{ $sertaMertaItems->links() }}</div>
        </div>
    </div>
</div>

{{-- Tab 6: Pelayanan Publik --}}
<div x-show="tab === 'pelayanan'" x-transition>
    <div
        class="flex gap-1.5 bg-gray-100 p-1 rounded-xl border border-gray-200/50 w-fit max-w-full overflow-x-auto scrollbar-none mb-6">
        @foreach ([['key' => 'alur_info', 'label' => 'Alur Informasi', 'icon' => 'route'], ['key' => 'permohonan', 'label' => 'Permohonan Online', 'icon' => 'edit_note'], ['key' => 'alur_kbr', 'label' => 'Alur Keberatan', 'icon' => 'report'], ['key' => 'keberatan', 'label' => 'Keberatan Online', 'icon' => 'feedback'], ['key' => 'alur_skt', 'label' => 'Alur Sengketa', 'icon' => 'balance']] as $s)
            <button @click="sub = '{{ $s['key'] }}'"
                :class="sub === '{{ $s['key'] }}' ? 'bg-white text-desa-700 shadow-xs' :
                    'text-gray-600 hover:text-gray-900'"
                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition-all duration-150 active:scale-[0.98]">
                <span class="material-symbols-outlined text-base">{{ $s['icon'] }}</span> {{ $s['label'] }}
            </button>
        @endforeach
    </div>

    {{-- Alur Informasi --}}
    <div x-show="sub === 'alur_info'">
        <div class="card p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-500">route</span> {{ $alurInformasi->title }}
            </h2>
            @if ($alurInformasi->content)
                <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $alurInformasi->content }}</div>
            @endif
            @if ($alurInformasi->image)
                <div class="mt-4" x-data="{ showLightbox: false }">
                    <div class="rounded-xl overflow-hidden border border-gray-100 cursor-pointer group relative"
                        @click="showLightbox = true">
                        <img src="{{ Storage::url($alurInformasi->image) }}" alt="Alur Informasi"
                            class="w-full object-contain max-h-80" loading="lazy">
                        <div
                            class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-200 flex items-center justify-center">
                            <span
                                class="material-symbols-outlined text-white text-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 drop-shadow-lg">zoom_in</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 flex items-center gap-1"><span
                            class="material-symbols-outlined text-xs">touch_app</span> Klik gambar untuk memperbesar
                    </p>
                    {{-- Lightbox --}}
                    <div x-show="showLightbox" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" @click="showLightbox = false"
                        @keydown.escape.window="showLightbox = false"
                        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4 cursor-zoom-out"
                        style="display: none;">
                        <img src="{{ Storage::url($alurInformasi->image) }}" alt="Alur Informasi"
                            class="max-w-full max-h-[90vh] object-contain rounded-xl shadow-2xl" @click.stop>
                        <button @click="showLightbox = false"
                            class="absolute top-4 right-4 h-10 w-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                </div>
            @endif
            @if (!$alurInformasi->content && !$alurInformasi->image)
                <p class="text-gray-400">Belum ada data alur informasi.</p>
            @endif
        </div>
    </div>

    {{-- Permohonan Online (Inline Form) --}}
    <div x-show="sub === 'permohonan'">
        @if ($pmhSubmitted)
            <div class="card p-8 text-center">
                <span class="material-symbols-outlined text-5xl text-green-500 mb-3">check_circle</span>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Permohonan Berhasil Dikirim!</h2>
                <p class="text-gray-500 mb-4">Simpan nomor permohonan Anda:</p>
                <div
                    class="inline-flex items-center gap-2 px-6 py-3 bg-desa-50 rounded-xl border-2 border-desa-200 mb-6">
                    <span class="material-symbols-outlined text-desa-600">confirmation_number</span>
                    <span class="text-2xl font-bold text-desa-700 font-mono">{{ $pmhNomor }}</span>
                </div>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('ppid.cek-status') }}" wire:navigate class="btn-primary"><span
                            class="material-symbols-outlined text-base">search</span> Cek Status</a>
                    <button wire:click="resetPermohonanForm" class="btn-secondary">Ajukan Baru</button>
                </div>
            </div>
        @else
            <div class="card p-6 md:p-8">
                <div class="rounded-xl bg-blue-50 border border-blue-200 p-4 flex items-start gap-3 mb-6">
                    <span class="material-symbols-outlined text-blue-500 mt-0.5">info</span>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">Informasi Penting</p>
                        <p>Berdasarkan UU No. 14 Tahun 2008, setiap warga negara berhak memperoleh informasi publik.
                            Permohonan akan diproses dalam waktu <strong>10 hari kerja</strong>.</p>
                    </div>
                </div>
                <form wire:submit="submitPermohonan" class="space-y-5">
                    <p
                        class="text-sm font-semibold text-gray-700 flex items-center gap-2 pb-2 border-b border-gray-100">
                        <span class="material-symbols-outlined text-lg text-desa-500">person</span> Data Pemohon
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Nama Pemohon <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="pmhNama" class="form-input w-full"
                                placeholder="Nama lengkap">
                            @error('pmhNama')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">NIK (16 digit) <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="pmhNik" class="form-input w-full" maxlength="16"
                                placeholder="Nomor Induk Kependudukan">
                            @error('pmhNik')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Nomor Telepon <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="pmhTelepon" class="form-input w-full"
                                placeholder="08xxxxxxxxxx">
                            @error('pmhTelepon')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Email <span
                                    class="text-gray-400 text-xs">(opsional)</span></label>
                            <input type="email" wire:model="pmhEmail" class="form-input w-full"
                                placeholder="email@contoh.com">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Alamat <span class="text-red-500">*</span></label>
                        <textarea wire:model="pmhAlamat" class="form-input w-full" rows="2" placeholder="Alamat lengkap"></textarea>
                        @error('pmhAlamat')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <p
                        class="text-sm font-semibold text-gray-700 flex items-center gap-2 pb-2 border-b border-gray-100 pt-2">
                        <span class="material-symbols-outlined text-lg text-desa-500">description</span> Detail
                        Informasi
                    </p>
                    <div>
                        <label class="form-label">Informasi yang Diminta <span class="text-red-500">*</span></label>
                        <textarea wire:model="pmhInfoDiminta" class="form-input w-full" rows="3"
                            placeholder="Jelaskan informasi yang Anda butuhkan..."></textarea>
                        @error('pmhInfoDiminta')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Tujuan Penggunaan Informasi <span
                                class="text-red-500">*</span></label>
                        <textarea wire:model="pmhTujuan" class="form-input w-full" rows="2"
                            placeholder="Untuk apa informasi ini digunakan..."></textarea>
                        @error('pmhTujuan')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Format Informasi <span class="text-red-500">*</span></label>
                            <select wire:model="pmhFormat" class="form-input w-full">
                                @foreach ($formatOptions as $k => $v)
                                    <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Cara Mendapatkan <span class="text-red-500">*</span></label>
                            <select wire:model="pmhCara" class="form-input w-full">
                                @foreach ($caraOptions as $k => $v)
                                    <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div x-data="{ previewUrl: null }" class="space-y-2">
                        <label class="form-label">Lampiran KTP <span class="text-red-400">*</span></label>
                        <label class="block cursor-pointer">
                            <div
                                class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-dashed border-gray-200 hover:border-desa-400 bg-gray-50 hover:bg-desa-50/30 transition-all text-sm text-gray-500">
                                <span class="material-symbols-outlined text-xl text-gray-400">photo_camera</span>
                                <div><span class="font-medium text-gray-700"
                                        x-text="previewUrl ? 'Ganti foto' : 'Upload foto KTP'">Upload foto KTP</span>
                                    <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, WebP. Maks 2MB</p>
                                </div>
                            </div>
                            <input type="file" wire:model="pmhLampiran" accept="image/*" class="sr-only"
                                x-on:change="const f=$event.target.files[0]; if(f){const r=new FileReader(); r.onload=e=>previewUrl=e.target.result; r.readAsDataURL(f);}">
                        </label>
                        <template x-if="previewUrl"><img :src="previewUrl"
                                class="w-full max-h-40 object-contain rounded-lg border border-gray-200 bg-white p-1"
                                alt="Preview"></template>
                        <div wire:loading wire:target="pmhLampiran"
                            class="text-xs text-desa-600 flex items-center gap-1"><span
                                class="material-symbols-outlined text-sm animate-spin">progress_activity</span>
                            Mengunggah...</div>
                        @error('pmhLampiran')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="submitPermohonan" class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-base">send</span> Kirim Permohonan</span>
                        <span wire:loading wire:target="submitPermohonan" class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-base animate-spin">progress_activity</span>
                            Mengirim...</span>
                    </button>
                </form>
            </div>
        @endif
    </div>

    {{-- Alur Keberatan --}}
    <div x-show="sub === 'alur_kbr'">
        <div class="card p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-500">report</span> {{ $alurKeberatan->title }}
            </h2>
            @if ($alurKeberatan->content)
                <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $alurKeberatan->content }}</div>
            @endif
            @if ($alurKeberatan->image)
                <div class="mt-4" x-data="{ showLightbox: false }">
                    <div class="rounded-xl overflow-hidden border border-gray-100 cursor-pointer group relative"
                        @click="showLightbox = true">
                        <img src="{{ Storage::url($alurKeberatan->image) }}" alt="Alur Keberatan"
                            class="w-full object-contain max-h-80" loading="lazy">
                        <div
                            class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-200 flex items-center justify-center">
                            <span
                                class="material-symbols-outlined text-white text-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 drop-shadow-lg">zoom_in</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 flex items-center gap-1"><span
                            class="material-symbols-outlined text-xs">touch_app</span> Klik gambar untuk memperbesar
                    </p>
                    {{-- Lightbox --}}
                    <div x-show="showLightbox" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" @click="showLightbox = false"
                        @keydown.escape.window="showLightbox = false"
                        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4 cursor-zoom-out"
                        style="display: none;">
                        <img src="{{ Storage::url($alurKeberatan->image) }}" alt="Alur Keberatan"
                            class="max-w-full max-h-[90vh] object-contain rounded-xl shadow-2xl" @click.stop>
                        <button @click="showLightbox = false"
                            class="absolute top-4 right-4 h-10 w-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                </div>
            @endif
            @if (!$alurKeberatan->content && !$alurKeberatan->image)
                <p class="text-gray-400">Belum ada data alur keberatan.</p>
            @endif
        </div>
    </div>

    {{-- Form Keberatan Online --}}
    <div x-show="sub === 'keberatan'">
        @if ($kbrSubmitted)
            <div class="card p-8 text-center">
                <span class="material-symbols-outlined text-5xl text-green-500 mb-3">check_circle</span>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Keberatan Berhasil Diajukan!</h2>
                <p class="text-gray-500 mb-4">Kode registrasi keberatan Anda:</p>
                <div
                    class="inline-flex items-center gap-2 px-6 py-3 bg-desa-50 rounded-xl border-2 border-desa-200 mb-6">
                    <span class="material-symbols-outlined text-desa-600">confirmation_number</span>
                    <span class="text-2xl font-bold text-desa-700 font-mono">{{ $kbrKode }}</span>
                </div>
                <p class="text-sm text-gray-400 mb-4">Simpan kode ini untuk melacak status keberatan Anda.</p>
                <button wire:click="resetKeberatanForm" class="btn-secondary">Ajukan Keberatan Baru</button>
            </div>
        @else
            <div class="card p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-desa-500">feedback</span> Formulir Pengajuan Keberatan
                </h2>
                <form wire:submit="submitKeberatan" class="space-y-5">
                    <div>
                        <label class="form-label">No Registrasi Permohonan Informasi Sebelumnya</label>
                        <input type="text" wire:model="kbrNoReg" class="form-input w-full"
                            placeholder="cth: PMH-20260601-0001">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Nama Lengkap <span class="text-red-400">*</span></label>
                            <input type="text" wire:model="kbrNama" class="form-input w-full" required>
                            @error('kbrNama')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">No HP/WA <span class="text-red-400">*</span></label>
                            <input type="text" wire:model="kbrNoHp" class="form-input w-full" required>
                            @error('kbrNoHp')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" wire:model="kbrEmail" class="form-input w-full">
                        </div>
                        <div>
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" wire:model="kbrPekerjaan" class="form-input w-full">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Alamat <span class="text-red-400">*</span></label>
                        <textarea wire:model="kbrAlamat" class="form-input w-full" rows="2" required></textarea>
                        @error('kbrAlamat')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Informasi yang Dimohon Sebelumnya</label>
                        <textarea wire:model="kbrInfoDimohon" class="form-input w-full" rows="2"></textarea>
                    </div>
                    <div>
                        <label class="form-label">Alasan Pengajuan Keberatan <span
                                class="text-red-400">*</span></label>
                        <div class="space-y-2 mt-2">
                            @foreach (\App\Models\PpidKeberatan::ALASAN as $k => $l)
                                <label
                                    class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition-colors">
                                    <input type="radio" wire:model="kbrAlasan" value="{{ $k }}"
                                        class="mt-0.5 text-desa-600 focus:ring-desa-500">
                                    <span class="text-sm text-gray-700">{{ $l }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('kbrAlasan')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="submitKeberatan" class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-base">send</span> Kirim Keberatan</span>
                        <span wire:loading wire:target="submitKeberatan" class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-base animate-spin">progress_activity</span>
                            Mengirim...</span>
                    </button>
                </form>
            </div>
        @endif
    </div>

    {{-- Alur Sengketa --}}
    <div x-show="sub === 'alur_skt'">
        <div class="card p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-500">balance</span> {{ $alurSengketa->title }}
            </h2>
            @if ($alurSengketa->content)
                <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $alurSengketa->content }}</div>
            @endif
            @if ($alurSengketa->image)
                <div class="mt-4" x-data="{ showLightbox: false }">
                    <div class="rounded-xl overflow-hidden border border-gray-100 cursor-pointer group relative"
                        @click="showLightbox = true">
                        <img src="{{ Storage::url($alurSengketa->image) }}" alt="Alur Sengketa"
                            class="w-full object-contain max-h-80" loading="lazy">
                        <div
                            class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-200 flex items-center justify-center">
                            <span
                                class="material-symbols-outlined text-white text-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 drop-shadow-lg">zoom_in</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 flex items-center gap-1"><span
                            class="material-symbols-outlined text-xs">touch_app</span> Klik gambar untuk memperbesar
                    </p>
                    {{-- Lightbox --}}
                    <div x-show="showLightbox" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" @click="showLightbox = false"
                        @keydown.escape.window="showLightbox = false"
                        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4 cursor-zoom-out"
                        style="display: none;">
                        <img src="{{ Storage::url($alurSengketa->image) }}" alt="Alur Sengketa"
                            class="max-w-full max-h-[90vh] object-contain rounded-xl shadow-2xl" @click.stop>
                        <button @click="showLightbox = false"
                            class="absolute top-4 right-4 h-10 w-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                </div>
            @endif
            @if (!$alurSengketa->content && !$alurSengketa->image)
                <p class="text-gray-400">Belum ada data alur sengketa.</p>
            @endif
        </div>
    </div>
</div>

{{-- Tab 7: Maklumat Pelayanan --}}
<div x-show="tab === 'maklumat'" x-transition>
    <div class="card p-6 md:p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-desa-500">verified</span> {{ $maklumat->title }}
        </h2>
        @if ($maklumat->content)
            <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">{{ $maklumat->content }}
            </div>
        @endif
        @if ($maklumat->image)
            <div class="mt-6" x-data="{ showLightbox: false }">
                <div class="rounded-xl overflow-hidden border border-gray-100 cursor-pointer group relative"
                    @click="showLightbox = true">
                    <img src="{{ Storage::url($maklumat->image) }}" alt="Maklumat Pelayanan"
                        class="w-full object-contain max-h-80" loading="lazy">
                    <div
                        class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-200 flex items-center justify-center">
                        <span
                            class="material-symbols-outlined text-white text-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 drop-shadow-lg">zoom_in</span>
                    </div>
                </div>
                {{-- Lightbox --}}
                <div x-show="showLightbox" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" @click="showLightbox = false"
                    @keydown.escape.window="showLightbox = false"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4 cursor-zoom-out"
                    style="display: none;">
                    <img src="{{ Storage::url($maklumat->image) }}" alt="Maklumat Pelayanan"
                        class="max-w-full max-h-[90vh] object-contain rounded-xl shadow-2xl" @click.stop>
                    <button @click="showLightbox = false"
                        class="absolute top-4 right-4 h-10 w-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            </div>
        @endif
        @if (!$maklumat->content && !$maklumat->image)
            <p class="text-gray-400">Belum ada maklumat pelayanan.</p>
        @endif
    </div>
</div>

{{-- Tab 8: Jadwal & Biaya --}}
<div x-show="tab === 'jadwal'" x-transition>
    <div class="space-y-8">
        <div class="card p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-500">event_note</span> {{ $jadwalBiaya->title }}
            </h2>
            @if ($jadwalBiaya->content)
                <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $jadwalBiaya->content }}</div>
            @else
                <p class="text-gray-400">Belum ada data jadwal dan biaya.</p>
            @endif
        </div>
        @if ($jadwalBiaya->attachment)
            <div class="card overflow-hidden">
                <div
                    class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-gradient-to-r from-desa-50 to-amber-50">
                    <div class="flex items-center gap-3">
                        <div
                            class="h-10 w-10 rounded-lg bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-white">picture_as_pdf</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Lampiran Jadwal & Biaya</h3>
                        </div>
                    </div>
                    <a href="{{ Storage::url($jadwalBiaya->attachment) }}" target="_blank"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-desa-500 to-desa-600 hover:from-desa-600 hover:to-desa-700 text-white rounded-xl text-sm font-semibold shadow-md transition-all">
                        <span class="material-symbols-outlined text-base">download</span> Unduh PDF
                    </a>
                </div>
                <div class="bg-gray-100" style="height: 70vh; min-height: 400px;">
                    <iframe src="{{ Storage::url($jadwalBiaya->attachment) }}#toolbar=1&navpanes=0"
                        class="w-full h-full border-0" loading="lazy"></iframe>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Tab 9: Dikecualikan --}}
<div x-show="tab === 'dikecualikan'" x-transition>
    <div class="space-y-8">
        <div class="card p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-500">event_note</span> {{ $dikecualikan->title }}
            </h2>
            @if ($dikecualikan->content)
                <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $dikecualikan->content }}</div>
            @else
                <p class="text-gray-400">Belum ada data Dikecualikan.</p>
            @endif
        </div>
        @if ($dikecualikan->attachment)
            <div class="card overflow-hidden">
                <div
                    class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-gradient-to-r from-desa-50 to-amber-50">
                    <div class="flex items-center gap-3">
                        <div
                            class="h-10 w-10 rounded-lg bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-white">picture_as_pdf</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Lampiran Dikecualikan</h3>
                        </div>
                    </div>
                    <a href="{{ Storage::url($dikecualikan->attachment) }}" target="_blank"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-desa-500 to-desa-600 hover:from-desa-600 hover:to-desa-700 text-white rounded-xl text-sm font-semibold shadow-md transition-all">
                        <span class="material-symbols-outlined text-base">download</span> Unduh PDF
                    </a>
                </div>
                <div class="bg-gray-100" style="height: 70vh; min-height: 400px;">
                    <iframe src="{{ Storage::url($dikecualikan->attachment) }}#toolbar=1&navpanes=0"
                        class="w-full h-full border-0" loading="lazy"></iframe>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Tab 9: Regulasi --}}
<div x-show="tab === 'regulasi'" x-transition>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
        {{-- Dasar Hukum --}}
        <div
            class="card bg-gradient-to-br from-desa-50 to-white border-2 border-desa-100 flex flex-col h-full overflow-hidden">
            <div class="p-6 md:p-8 flex-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-desa-500 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-white text-2xl">gavel</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $dasarHukum->title }}</h2>
                </div>
                @if ($dasarHukum->content)
                    <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $dasarHukum->content }}</div>
                @else
                    <p class="text-gray-400">Belum ada data dasar hukum.</p>
                @endif
            </div>
            @if ($dasarHukum->attachment)
                <div class="border-t border-gray-100 flex items-center justify-between bg-desa-50/50 px-6 py-4">
                    <span class="text-sm font-semibold text-gray-900">Dokumen Dasar Hukum</span>
                    <a href="{{ Storage::url($dasarHukum->attachment) }}" target="_blank"
                        class="text-xs text-desa-600 hover:underline font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">download</span> Unduh
                    </a>
                </div>
                <div class="bg-gray-100 border-t border-gray-100" style="height: 50vh; min-height: 300px;">
                    <iframe src="{{ Storage::url($dasarHukum->attachment) }}#toolbar=1&navpanes=0"
                        class="w-full h-full border-0" loading="lazy"></iframe>
                </div>
            @endif
        </div>

        {{-- SOP --}}
        <div class="card flex flex-col h-full overflow-hidden">
            <div class="p-6 md:p-8 flex-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-desa-500 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-white text-2xl">description</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $sop->title }}</h2>
                </div>
                @if ($sop->content)
                    <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $sop->content }}</div>
                @else
                    <p class="text-gray-400">Belum ada data SOP.</p>
                @endif
            </div>
            @if ($sop->attachment)
                <div class="border-t border-gray-100 flex items-center justify-between bg-gray-50 px-6 py-4">
                    <span class="text-sm font-semibold text-gray-900">Dokumen SOP</span>
                    <a href="{{ Storage::url($sop->attachment) }}" target="_blank"
                        class="text-xs text-desa-600 hover:underline font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">download</span> Unduh
                    </a>
                </div>
                <div class="bg-gray-100 border-t border-gray-100" style="height: 50vh; min-height: 300px;">
                    <iframe src="{{ Storage::url($sop->attachment) }}#toolbar=1&navpanes=0"
                        class="w-full h-full border-0" loading="lazy"></iframe>
                </div>
            @endif
        </div>
    </div>
</div>
