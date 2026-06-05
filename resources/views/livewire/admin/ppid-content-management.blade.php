<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Konten PPID</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola semua konten halaman PPID publik</p>
        </div>
    </div>

    <x-page-guide title="Panduan Konten PPID" description="Pilih menu di sebelah kiri untuk mengedit konten setiap halaman PPID. Anda dapat menambahkan teks, gambar, atau lampiran PDF sesuai kebutuhan masing-masing halaman." />

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {{-- Sidebar Navigation --}}
        <div class="lg:col-span-1">
            <div class="card p-2 space-y-1 sticky top-6">
                @php
                    $groups = [
                        'Profil PPID' => [
                            ['key' => 'profil', 'icon' => 'badge', 'label' => 'Profil Singkat'],
                            ['key' => 'visi_misi', 'icon' => 'visibility', 'label' => 'Visi & Misi'],
                            ['key' => 'tugas_fungsi', 'icon' => 'assignment', 'label' => 'Tugas & Fungsi'],
                            ['key' => 'struktur', 'icon' => 'account_tree', 'label' => 'Struktur Organisasi'],
                        ],
                        'Pelayanan' => [
                            ['key' => 'dikecualikan', 'icon' => 'lock', 'label' => 'Info Dikecualikan'],
                            ['key' => 'alur_informasi', 'icon' => 'route', 'label' => 'Alur Informasi'],
                            ['key' => 'alur_keberatan', 'icon' => 'report', 'label' => 'Alur Keberatan'],
                            ['key' => 'alur_sengketa', 'icon' => 'balance', 'label' => 'Alur Sengketa'],
                            ['key' => 'maklumat', 'icon' => 'verified', 'label' => 'Maklumat Pelayanan'],
                        ],
                        'Regulasi' => [
                            ['key' => 'jadwal_biaya', 'icon' => 'event_note', 'label' => 'Jadwal & Biaya'],
                            ['key' => 'dasar_hukum', 'icon' => 'gavel', 'label' => 'Dasar Hukum'],
                            ['key' => 'sop', 'icon' => 'description', 'label' => 'SOP PPID'],
                        ],
                    ];
                @endphp

                @foreach ($groups as $groupName => $items)
                    <p class="px-3 pt-3 pb-1 text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $groupName }}</p>
                    @foreach ($items as $item)
                        <button wire:click="switchTab('{{ $item['key'] }}')"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium transition-all text-left
                                {{ $activeTab === $item['key']
                                    ? 'bg-desa-50 text-desa-700 border border-desa-200'
                                    : 'text-gray-600 hover:bg-gray-50 border border-transparent' }}">
                            <span class="material-symbols-outlined text-lg {{ $activeTab === $item['key'] ? 'text-desa-500' : 'text-gray-400' }}">{{ $item['icon'] }}</span>
                            <span class="truncate">{{ $item['label'] }}</span>
                            @if ($activeTab === $item['key'])
                                <span class="material-symbols-outlined text-desa-400 text-sm ml-auto">chevron_right</span>
                            @endif
                        </button>
                    @endforeach
                @endforeach
            </div>
        </div>

        {{-- Content Form --}}
        <div class="lg:col-span-3">
            {{-- Active Tab Indicator --}}
            <div class="flex items-center gap-3 mb-4">
                <div class="h-10 w-10 rounded-xl bg-desa-500 flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-xl">
                        @switch($activeTab)
                            @case('profil') badge @break
                            @case('visi_misi') visibility @break
                            @case('tugas_fungsi') assignment @break
                            @case('struktur') account_tree @break
                            @case('dikecualikan') lock @break
                            @case('alur_informasi') route @break
                            @case('alur_keberatan') report @break
                            @case('alur_sengketa') balance @break
                            @case('maklumat') verified @break
                            @case('jadwal_biaya') event_note @break
                            @case('dasar_hukum') gavel @break
                            @case('sop') description @break
                            @default edit @break
                        @endswitch
                    </span>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">{{ \App\Models\PpidContent::TYPES[$activeTab] ?? $activeTab }}</h3>
                    <p class="text-xs text-gray-400">
                        @if (in_array($activeTab, ['tugas_fungsi', 'dikecualikan', 'jadwal_biaya', 'dasar_hukum', 'sop']))
                            Teks + Lampiran PDF
                        @elseif (in_array($activeTab, ['alur_informasi', 'alur_keberatan', 'alur_sengketa', 'maklumat']))
                            Teks + Gambar
                        @elseif ($activeTab === 'struktur')
                            Teks + Gambar + Susunan Pejabat
                        @else
                            Teks
                        @endif
                    </p>
                </div>
            </div>

            <div class="card p-6">
                <form wire:submit="save" class="space-y-5">
                    <div>
                        <label class="form-label">Judul <span class="text-red-400">*</span></label>
                        <input type="text" wire:model="title" class="form-input w-full" placeholder="Judul halaman">
                    </div>

                    @if ($activeTab === 'visi_misi')
                        {{-- Separated Visi & Misi --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="form-label flex items-center gap-2">
                                    <span class="material-symbols-outlined text-desa-500 text-base">flag</span>
                                    Visi
                                </label>
                                <textarea wire:model="content" class="form-input w-full" rows="6" placeholder="Tuliskan visi PPID..."></textarea>
                            </div>
                            <div>
                                <label class="form-label flex items-center gap-2">
                                    <span class="material-symbols-outlined text-desa-500 text-base">checklist</span>
                                    Misi
                                </label>
                                <textarea wire:model="contentExtra" class="form-input w-full" rows="6" placeholder="Tuliskan misi PPID..."></textarea>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Mendukung teks biasa. Gunakan baris baru untuk paragraf.</p>
                    @elseif ($activeTab === 'tugas_fungsi')
                        {{-- Separated Tugas & Fungsi --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="form-label flex items-center gap-2">
                                    <span class="material-symbols-outlined text-desa-500 text-base">assignment</span>
                                    Tugas PPID
                                </label>
                                <textarea wire:model="content" class="form-input w-full" rows="8" placeholder="Tuliskan tugas PPID..."></textarea>
                            </div>
                            <div>
                                <label class="form-label flex items-center gap-2">
                                    <span class="material-symbols-outlined text-desa-500 text-base">settings_suggest</span>
                                    Fungsi PPID
                                </label>
                                <textarea wire:model="contentExtra" class="form-input w-full" rows="8" placeholder="Tuliskan fungsi PPID..."></textarea>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Mendukung teks biasa. Gunakan baris baru untuk paragraf.</p>
                    @else
                        <div>
                            <label class="form-label">Konten</label>
                            <textarea wire:model="content" class="form-input w-full" rows="10" placeholder="Tulis konten di sini..."></textarea>
                            <p class="text-xs text-gray-400 mt-1">Mendukung teks biasa. Gunakan baris baru untuk paragraf.</p>
                        </div>
                    @endif

                    {{-- PDF Upload --}}
                    @if(in_array($activeTab, ['tugas_fungsi', 'dikecualikan', 'jadwal_biaya', 'dasar_hukum', 'sop']))
                        <div class="p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                            <label class="form-label flex items-center gap-2">
                                <span class="material-symbols-outlined text-blue-500 text-base">picture_as_pdf</span>
                                Lampiran PDF <span class="text-xs text-gray-400 font-normal">(maks 10MB)</span>
                            </label>
                            @if($existingAttachment)
                                <div class="flex items-center gap-3 p-3 bg-white rounded-lg border border-blue-200 mb-3">
                                    <span class="material-symbols-outlined text-blue-500">picture_as_pdf</span>
                                    <a href="{{ Storage::url($existingAttachment) }}" target="_blank" class="text-sm text-blue-700 font-medium hover:underline flex-1 truncate">{{ basename($existingAttachment) }}</a>
                                    <button type="button" wire:click="removeAttachment" class="text-xs text-red-500 hover:text-red-700 font-medium px-2 py-1 rounded-md hover:bg-red-50 transition-colors">Hapus</button>
                                </div>
                            @endif
                            <input type="file" wire:model="attachmentUpload" accept=".pdf" class="form-input w-full text-sm">
                            @error('attachmentUpload')<p class="form-error">{{ $message }}</p>@enderror
                            <div wire:loading wire:target="attachmentUpload" class="mt-1 text-xs text-gray-400 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs animate-spin">progress_activity</span> Mengupload...
                            </div>
                        </div>
                    @endif

                    {{-- Image Upload --}}
                    @if(in_array($activeTab, ['struktur', 'alur_informasi', 'alur_keberatan', 'alur_sengketa', 'maklumat']))
                        <div class="p-4 bg-emerald-50/50 rounded-xl border border-emerald-100">
                            <label class="form-label flex items-center gap-2">
                                <span class="material-symbols-outlined text-emerald-500 text-base">image</span>
                                Gambar
                                @if ($activeTab === 'struktur') Bagan Struktur @else Ilustrasi @endif
                                <span class="text-xs text-gray-400 font-normal">(opsional, maks 5MB)</span>
                            </label>
                            @if($existingImage)
                                <div class="mb-3 relative inline-block">
                                    <img src="{{ Storage::url($existingImage) }}" alt="Preview" class="max-w-full max-h-48 rounded-lg border border-gray-200 shadow-sm">
                                    <button type="button" wire:click="removeImage" class="absolute top-2 right-2 h-7 w-7 rounded-full bg-red-500/90 text-white flex items-center justify-center hover:bg-red-600 transition-colors shadow-md" title="Hapus gambar">
                                        <span class="material-symbols-outlined text-sm">close</span>
                                    </button>
                                </div>
                            @endif
                            <input type="file" wire:model="imageUpload" accept="image/*" class="form-input w-full text-sm">
                            @error('imageUpload')<p class="form-error">{{ $message }}</p>@enderror
                            <div wire:loading wire:target="imageUpload" class="mt-1 text-xs text-gray-400 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs animate-spin">progress_activity</span> Mengupload...
                            </div>
                        </div>

                        {{-- Members Repeater (struktur only) --}}
                        @if ($activeTab === 'struktur')
                            <div class="p-4 bg-amber-50/50 rounded-xl border border-amber-100">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="form-label mb-0 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-amber-500 text-base">group</span>
                                        Susunan Pejabat PPID
                                    </label>
                                    <button type="button" wire:click="addMember"
                                        class="inline-flex items-center gap-1 text-xs text-desa-600 hover:text-desa-700 font-semibold bg-white px-3 py-1.5 rounded-lg border border-gray-200 hover:border-desa-300 transition-colors">
                                        <span class="material-symbols-outlined text-sm">add_circle</span> Tambah
                                    </button>
                                </div>

                                @forelse($members as $i => $member)
                                    <div class="relative bg-white rounded-xl p-4 mb-3 border border-gray-200 shadow-sm" wire:key="member-{{ $i }}">
                                        <button type="button" wire:click="removeMember({{ $i }})"
                                            class="absolute top-2 right-2 h-6 w-6 rounded-full bg-red-100 hover:bg-red-200 text-red-500 flex items-center justify-center transition-colors" title="Hapus">
                                            <span class="material-symbols-outlined text-sm">close</span>
                                        </button>
                                        <div class="flex gap-4">
                                            {{-- Photo Upload (Optional) --}}
                                            <div class="flex-shrink-0">
                                                <label class="text-xs text-gray-500 font-medium block mb-1">Foto</label>
                                                <div class="relative h-20 w-20 rounded-xl bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden cursor-pointer hover:border-desa-400 transition-colors group">
                                                    @if (!empty($member['photo']))
                                                        <img src="{{ Storage::url($member['photo']) }}" alt="{{ $member['name'] }}" class="h-full w-full object-cover">
                                                        <button type="button" wire:click="removeMemberPhoto({{ $i }})"
                                                            class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <span class="material-symbols-outlined text-white text-lg">delete</span>
                                                        </button>
                                                    @else
                                                        <label class="cursor-pointer flex flex-col items-center justify-center w-full h-full">
                                                            <span class="material-symbols-outlined text-2xl text-gray-300 group-hover:text-desa-400 transition-colors">add_a_photo</span>
                                                            <span class="text-[10px] text-gray-400 mt-0.5">Opsional</span>
                                                            <input type="file" wire:model="memberPhotoUploads.{{ $i }}" accept="image/*" class="hidden">
                                                        </label>
                                                    @endif
                                                    <div wire:loading wire:target="memberPhotoUploads.{{ $i }}" class="absolute inset-0 bg-white/80 flex items-center justify-center">
                                                        <span class="material-symbols-outlined text-desa-500 animate-spin">progress_activity</span>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Fields --}}
                                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
                                                <div>
                                                    <label class="text-xs text-gray-500 font-medium">Nama <span class="text-red-400">*</span></label>
                                                    <input type="text" wire:model="members.{{ $i }}.name" class="form-input w-full text-sm" placeholder="Nama pejabat">
                                                </div>
                                                <div>
                                                    <label class="text-xs text-gray-500 font-medium">Jabatan PPID</label>
                                                    <input type="text" wire:model="members.{{ $i }}.position" class="form-input w-full text-sm" placeholder="cth: Atasan PPID, PPID Utama">
                                                </div>
                                                <div>
                                                    <label class="text-xs text-gray-500 font-medium">Jabatan Struktural</label>
                                                    <input type="text" wire:model="members.{{ $i }}.role" class="form-input w-full text-sm" placeholder="cth: Wali Nagari, Sekretaris Nagari">
                                                </div>
                                                <div>
                                                    <label class="text-xs text-gray-500 font-medium">Keterangan Tugas</label>
                                                    <input type="text" wire:model="members.{{ $i }}.desc" class="form-input w-full text-sm" placeholder="Tugas singkat">
                                                </div>
                                            </div>
                                        </div>
                                        <label class="flex items-center gap-2 mt-3 text-xs text-gray-500 cursor-pointer">
                                            <input type="checkbox" wire:model="members.{{ $i }}.is_leader" class="rounded border-gray-300 text-desa-600 focus:ring-desa-500">
                                            Pimpinan / Atasan PPID (ditampilkan lebih besar)
                                        </label>
                                    </div>
                                @empty
                                    <div class="text-center py-6 bg-white rounded-xl border border-dashed border-gray-300">
                                        <span class="material-symbols-outlined text-3xl text-gray-300 mb-2">group_add</span>
                                        <p class="text-sm text-gray-400">Belum ada pejabat. Klik "Tambah" untuk menambahkan.</p>
                                    </div>
                                @endforelse
                            </div>
                        @endif
                    @endif

                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save">
                            <span wire:loading.remove wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base">save</span> Simpan</span>
                            <span wire:loading wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
