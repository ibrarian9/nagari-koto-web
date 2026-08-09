<div>
    {{-- ─── HEADER ─────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-600">bar_chart</span>
                Data Infografis Penduduk
            </h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola statistik demografi kependudukan per tahun (urut dari tahun terbaru)</p>
        </div>
        <button wire:click="openNewYearModal" class="btn-primary btn-sm flex items-center gap-1.5 self-start sm:self-auto">
            <span class="material-symbols-outlined text-base">add_circle</span> Tambah Data Tahun Baru
        </button>
    </div>

    <x-page-guide title="Panduan Infografis Penduduk" description="Pilih atau tambahkan tahun data infografis. Isi jumlah total penduduk, KK, serta rincian kelompok usia, tingkat pendidikan, dan jenis pekerjaan. Data diurutkan otomatis dari tahun terbaru dan langsung tampil interaktif pada website publik." />

    {{-- ─── YEAR SELECTOR BAR ──────────────────────── --}}
    <div class="card p-4 mb-6 bg-gradient-to-r from-desa-50/40 via-white to-gray-50/50 border border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <label class="text-sm font-semibold text-gray-700 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-desa-600 text-lg">calendar_month</span>
                    Pilih Tahun Data:
                </label>
                <select wire:model.live="year" wire:change="loadYear($event.target.value)"
                    class="form-input text-sm font-bold text-gray-900 w-36 bg-white shadow-sm border-gray-300">
                    @foreach($years as $y)
                        <option value="{{ $y }}">Tahun {{ $y }}</option>
                    @endforeach
                </select>

                @if($editingId)
                    <span class="badge bg-emerald-100 text-emerald-800 border-emerald-200 font-semibold text-xs inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">check_circle</span> Data Terdaftar (Edit)
                    </span>
                @else
                    <span class="badge bg-amber-100 text-amber-800 border-amber-200 font-semibold text-xs inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">edit_note</span> Tahun Baru (Draf)
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('infografis') }}" target="_blank" class="btn-secondary btn-sm text-xs flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">open_in_new</span> Tampilan Publik
                </a>
                @if($editingId)
                    <button type="button" onclick="confirmAction({{ $year }}, 'deleteYearConfirmed', 'Yakin ingin menghapus seluruh data infografis tahun {{ $year }}?')"
                        class="btn-secondary btn-sm text-red-600 hover:bg-red-50 hover:text-red-700 text-xs flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">delete</span> Hapus Data {{ $year }}
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- ─── NEW YEAR MODAL ──────────────────────────── --}}
    <x-admin-modal :show="$showNewYearModal" closeProperty="showNewYearModal" title="Tambah Data Infografis Tahun Baru" subtitle="Masukkan tahun baru yang ingin dikelola" icon="edit_calendar" iconBg="bg-desa-100" iconColor="text-desa-600" maxWidth="max-w-md">

        <form wire:submit="createNewYear" class="space-y-4">
            <div>
                <label class="form-label">Tahun Anggaran / Data <span class="text-red-400">*</span></label>
                <input type="number" wire:model="newYearInput" min="2000" max="2100" class="form-input w-full font-bold text-lg text-gray-900" placeholder="cth: 2026">
                @error('newYearInput')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-2 pt-2">
                <button type="button" wire:click="$set('newYearInput', {{ (int)date('Y') + 1 }})" class="btn-secondary btn-sm text-xs">+1 Tahun ({{ (int)date('Y') + 1 }})</button>
                <button type="button" wire:click="$set('newYearInput', {{ (int)date('Y') }})" class="btn-secondary btn-sm text-xs">Tahun Ini ({{ (int)date('Y') }})</button>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary flex-1 justify-center">
                    <span class="material-symbols-outlined text-base">add</span> Buat Form {{ $newYearInput }}
                </button>
                <button type="button" wire:click="$set('showNewYearModal', false)" class="btn-secondary">Batal</button>
            </div>
        </form>
    </x-admin-modal>

    {{-- ─── DATA FORM ──────────────────────────────── --}}
    <form wire:submit="save" class="space-y-6">
        {{-- Data Umum --}}
        <div class="card p-6 border border-gray-200">
            <h3 class="font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-600">groups</span>
                Data Utama Kependudukan (Tahun {{ $year }})
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="form-label">Total Penduduk <span class="text-red-400">*</span></label>
                    <input type="number" wire:model="total_population" class="form-input w-full font-semibold">
                    @error('total_population')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Laki-laki <span class="text-red-400">*</span></label>
                    <input type="number" wire:model="male" class="form-input w-full font-semibold">
                    @error('male')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Perempuan <span class="text-red-400">*</span></label>
                    <input type="number" wire:model="female" class="form-input w-full font-semibold">
                    @error('female')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Jumlah KK (Keluarga) <span class="text-red-400">*</span></label>
                    <input type="number" wire:model="total_families" class="form-input w-full font-semibold">
                    @error('total_families')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Dynamic Sections: Usia, Pendidikan, Pekerjaan --}}
        @foreach([
            ['key' => 'age_groups', 'title' => 'Kelompok Usia', 'icon' => 'family_restroom', 'desc' => 'Rincian jumlah warga berdasarkan rentang umur'],
            ['key' => 'education', 'title' => 'Tingkat Pendidikan', 'icon' => 'school', 'desc' => 'Rincian jumlah warga berdasarkan pendidikan terakhir'],
            ['key' => 'occupation', 'title' => 'Mata Pencaharian / Pekerjaan', 'icon' => 'work', 'desc' => 'Rincian jumlah warga berdasarkan sektor pekerjaan']
        ] as $section)
            <div class="card p-6 border border-gray-200">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-600">{{ $section['icon'] }}</span>
                        {{ $section['title'] }}
                    </h3>
                    <button type="button" wire:click="addRow('{{ $section['key'] }}')" class="btn-secondary btn-sm text-xs flex items-center gap-1 text-desa-600 hover:text-desa-800">
                        <span class="material-symbols-outlined text-sm">add</span> Tambah Kategori
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach($this->{$section['key']} as $i => $row)
                        <div class="flex items-center gap-3">
                            <input type="text" wire:model="{{ $section['key'] }}.{{ $i }}.label" class="form-input flex-1 text-sm" placeholder="Nama Kategori / Label (cth: SMA)">
                            <input type="number" wire:model="{{ $section['key'] }}.{{ $i }}.value" class="form-input w-36 text-sm font-semibold" placeholder="Jumlah">
                            <button type="button" wire:click="removeRow('{{ $section['key'] }}', {{ $i }})" class="h-9 w-9 rounded-lg flex items-center justify-center text-red-500 hover:bg-red-50 hover:text-red-700 transition-colors" title="Hapus Baris">
                                <span class="material-symbols-outlined text-lg">delete</span>
                            </button>
                        </div>
                    @endforeach

                    @if(empty($this->{$section['key']}))
                        <p class="text-xs text-gray-400 italic py-2 text-center">Belum ada rincian {{ strtolower($section['title']) }}. Klik 'Tambah Kategori' di atas.</p>
                    @endif
                </div>
            </div>
        @endforeach

        {{-- Submit Button --}}
        <div class="flex items-center justify-between card p-4 bg-gray-50/80 border border-gray-200">
            <span class="text-xs text-gray-500 font-medium">Menyimpan data infografis kependudukan tahun <strong class="text-gray-900">{{ $year }}</strong></span>
            <button type="submit" class="btn-primary flex items-center gap-2">
                <span class="material-symbols-outlined text-base">save</span> Simpan Data Tahun {{ $year }}
            </button>
        </div>
    </form>
</div>
