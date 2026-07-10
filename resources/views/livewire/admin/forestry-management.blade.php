<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Data Kehutanan</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola data kawasan hutan dan lahan nagari</p>
        </div>
        <button wire:click="create" class="btn-primary btn-sm">
            <span class="material-symbols-outlined text-base">add</span> Tambah
        </button>
    </div>

    <x-page-guide title="Panduan Data Kehutanan" description="Kelola data kawasan hutan dan lahan nagari. Masukkan nama kawasan, kategori (Hutan Lindung, Hutan Produksi, dll), luas area, lokasi, dan status kondisi. Data ini akan ditampilkan di halaman Kehutanan pada website publik sebagai informasi transparansi pengelolaan hutan nagari." />

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="stat-card">
            <span class="text-2xl font-bold text-gray-900">{{ $summary['total'] }}</span>
            <span class="text-xs text-gray-500">Total Kawasan</span>
        </div>
        <div class="stat-card">
            <span class="text-2xl font-bold text-green-600">{{ number_format($summary['total_area'], 1, ',', '.') }} Ha</span>
            <span class="text-xs text-gray-500">Total Luas</span>
        </div>
        <div class="stat-card">
            <span class="text-2xl font-bold text-desa-600">{{ $summary['aktif'] }}</span>
            <span class="text-xs text-gray-500">Kawasan Aktif</span>
        </div>
        <div class="stat-card">
            <span class="text-2xl font-bold text-red-600">{{ $summary['kritis'] }}</span>
            <span class="text-xs text-gray-500">Kawasan Kritis</span>
        </div>
    </div>

    {{-- Modal Form --}}
    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' Data Kehutanan'" subtitle="Informasi kawasan hutan / lahan" :icon="$editingId ? 'edit' : 'forest'" iconBg="bg-green-100" iconColor="text-green-600" maxWidth="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Nama Kawasan</strong> — Nama resmi atau populer kawasan hutan (cth: Hutan Rimba Panti)</li>
                    <li><strong>Kategori</strong> — Jenis kawasan: Hutan Lindung, Produksi, Rakyat, Lahan Kritis, atau Rehabilitasi</li>
                    <li><strong>Luas</strong> — Luas area dalam satuan hektar (Ha)</li>
                    <li><strong>Lokasi</strong> — Nama jorong, nagari, atau titik lokasi kawasan</li>
                    <li><strong>Tahun Data</strong> — Tahun pencatatan atau pendataan terakhir</li>
                    <li><strong>Status</strong> — Kondisi saat ini: Aktif, Dalam Pemulihan, atau Kritis</li>
                    <li><strong>Foto</strong> — Foto kawasan, maksimal 2MB (JPG/PNG/WebP)</li>
                </ul>
            </x-form-guide>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Nama Kawasan <span class="text-red-400">*</span></label>
                    <input type="text" wire:model="title" class="form-input w-full" placeholder="Nama kawasan hutan">
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Kategori <span class="text-red-400">*</span></label>
                    <select wire:model="category" class="form-input w-full">
                        <option value="">— Pilih Kategori —</option>
                        @foreach(\App\Models\ForestryRecord::CATEGORIES as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                    @error('category')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Luas Area (Ha) <span class="text-red-400">*</span></label>
                    <input type="number" step="0.01" wire:model="area_ha" class="form-input w-full" placeholder="0.00">
                    @error('area_ha')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Lokasi</label>
                    <input type="text" wire:model="location" class="form-input w-full" placeholder="cth: Jorong Koto Tinggi">
                </div>
                <div>
                    <label class="form-label">Tahun Data</label>
                    <input type="number" wire:model="year" class="form-input w-full" placeholder="{{ date('Y') }}" min="2000" max="2100">
                    @error('year')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Status <span class="text-red-400">*</span></label>
                    <select wire:model="status" class="form-input w-full">
                        @foreach(\App\Models\ForestryRecord::STATUSES as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="form-label">Deskripsi</label>
                <textarea wire:model="description" class="form-input w-full" rows="3" placeholder="Keterangan tambahan tentang kawasan..."></textarea>
            </div>

            <x-admin-image-upload wireModel="thumbnail" label="Foto Kawasan" :existingUrl="$existingThumbnail ? Storage::url($existingThumbnail) : null" icon="forest" />

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">save</span> Simpan
                    </span>
                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...
                    </span>
                </button>
                <button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button>
            </div>
        </form>
    </x-admin-modal>

    {{-- Filters --}}
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-4">
        <div class="relative flex-1 sm:max-w-xs">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama/lokasi..." class="form-input w-full pl-10">
        </div>
        <select wire:model.live="categoryFilter" class="form-input w-full sm:w-44 flex-shrink-0">
            <option value="">Semua Kategori</option>
            @foreach(\App\Models\ForestryRecord::CATEGORIES as $k => $v)
                <option value="{{ $k }}">{{ $v }}</option>
            @endforeach
        </select>
        <select wire:model.live="yearFilter" class="form-input w-full sm:w-32 flex-shrink-0">
            <option value="">Semua Tahun</option>
            @for($y = date('Y'); $y >= 2020; $y--)
                <option value="{{ $y }}">{{ $y }}</option>
            @endfor
        </select>
    </div>

    {{-- Data Table --}}
    <div class="card overflow-hidden">
        <div class="table-container border-0 shadow-none">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kawasan</th>
                        <th>Kategori</th>
                        <th>Luas (Ha)</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Tahun</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $r)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-green-50 overflow-hidden">
                                        @if($r->thumbnail)
                                            <img src="{{ Storage::url($r->thumbnail) }}" class="h-full w-full object-cover" loading="lazy">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center">
                                                <span class="material-symbols-outlined text-green-300">forest</span>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="font-medium">{{ $r->title }}</span>
                                </div>
                            </td>
                            <td><span class="badge badge-success">{{ $r->category_label }}</span></td>
                            <td class="font-mono text-sm">{{ number_format($r->area_ha, 1, ',', '.') }}</td>
                            <td class="text-sm text-gray-500">{{ $r->location ?? '-' }}</td>
                            <td>
                                @php
                                    $statusClass = match($r->status) {
                                        'aktif' => 'badge-success',
                                        'dalam_pemulihan' => 'badge-warning',
                                        'kritis' => 'badge-danger',
                                        default => 'badge-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $r->status_label }}</span>
                            </td>
                            <td class="text-sm">{{ $r->year ?? '-' }}</td>
                            <td>
                                <div class="flex justify-end gap-1">
                                    <button wire:click="edit({{ $r->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600 transition-colors">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <button onclick="confirmAction({{ $r->id }}, 'deleteConfirmed', 'Yakin ingin menghapus data ini?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <span class="material-symbols-outlined text-4xl text-gray-200 mb-2">forest</span>
                                <p class="text-gray-400 text-sm">Belum ada data kehutanan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">{{ $records->links() }}</div>
    </div>
</div>
