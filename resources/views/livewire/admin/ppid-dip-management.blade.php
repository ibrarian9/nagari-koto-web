<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Daftar Informasi Publik</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola dokumen informasi publik (Berkala, Serta Merta, Setiap Saat)</p>
        </div>
        <button wire:click="create" class="btn-primary">
            <span class="material-symbols-outlined text-base">add</span> Tambah Dokumen
        </button>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        @foreach([['label' => 'Total', 'value' => $stats['total'], 'icon' => 'list_alt', 'color' => 'desa'], ['label' => 'Berkala', 'value' => $stats['berkala'], 'icon' => 'schedule', 'color' => 'blue'], ['label' => 'Serta Merta', 'value' => $stats['serta_merta'], 'icon' => 'campaign', 'color' => 'orange'], ['label' => 'Setiap Saat', 'value' => $stats['setiap_saat'], 'icon' => 'folder_open', 'color' => 'emerald']] as $s)
            <div class="card p-4 text-center">
                <span class="material-symbols-outlined text-{{ $s['color'] }}-500 text-2xl mb-1">{{ $s['icon'] }}</span>
                <p class="text-2xl font-bold text-gray-900">{{ $s['value'] }}</p>
                <p class="text-xs text-gray-400">{{ $s['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Filters --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" class="form-input flex-1" placeholder="Cari judul dokumen...">
        <select wire:model.live="filterKategori" class="form-input w-full sm:w-48">
            <option value="">Semua Kategori</option>
            @foreach(\App\Models\PpidDip::KATEGORI as $k => $l)
                <option value="{{ $k }}">{{ $l }}</option>
            @endforeach
        </select>
    </div>

    {{-- Form Modal --}}
    @if($showForm)
        <div class="card p-6 mb-6 border-2 border-desa-200 bg-desa-50/30">
            <h3 class="font-bold text-gray-900 mb-4">{{ $editId ? 'Edit' : 'Tambah' }} Dokumen</h3>
            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Judul Informasi <span class="text-red-400">*</span></label>
                        <input type="text" wire:model="judul" class="form-input w-full" placeholder="Judul dokumen">
                        @error('judul')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">Tahun</label>
                            <input type="number" wire:model="tahun_dokumen" class="form-input w-full" min="2000" max="2100">
                        </div>
                        <div>
                            <label class="form-label">Kategori <span class="text-red-400">*</span></label>
                            <select wire:model="kategori" class="form-input w-full">
                                @foreach(\App\Models\PpidDip::KATEGORI as $k => $l)
                                    <option value="{{ $k }}">{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="form-label">Deskripsi</label>
                    <textarea wire:model="deskripsi" class="form-input w-full" rows="3" placeholder="Deskripsi singkat"></textarea>
                </div>
                <div>
                    <label class="form-label">File Dokumen <span class="text-xs text-gray-400">(PDF/DOC/XLS, maks 20MB)</span></label>
                    @if($existingFile)
                        <div class="flex items-center gap-2 p-2 bg-blue-50 rounded-lg border border-blue-200 mb-2 text-sm">
                            <span class="material-symbols-outlined text-blue-500 text-base">description</span>
                            <span class="truncate flex-1">{{ basename($existingFile) }}</span>
                        </div>
                    @endif
                    <input type="file" wire:model="fileUpload" class="form-input w-full text-sm">
                    @error('fileUpload')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" wire:model="is_published" class="rounded border-gray-300 text-desa-600">
                    Publikasikan
                </label>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="btn-primary">Simpan</button>
                    <button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button>
                </div>
            </form>
        </div>
    @endif

    {{-- Table --}}
    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">No</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Judul</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Tahun</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Kategori</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-500">{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $item->judul }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $item->tahun_dokumen ?? '-' }}</td>
                        <td class="px-4 py-3"><span class="badge bg-desa-100 text-desa-700 text-xs">{{ $item->kategori_label }}</span></td>
                        <td class="px-4 py-3">
                            <button wire:click="togglePublish({{ $item->id }})" class="badge text-xs {{ $item->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $item->is_published ? 'Publik' : 'Draft' }}
                            </button>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-1">
                                @if($item->file_path)
                                    <a href="{{ Storage::url($item->file_path) }}" target="_blank" class="btn-icon" title="Lihat"><span class="material-symbols-outlined text-sm">visibility</span></a>
                                @endif
                                <button wire:click="edit({{ $item->id }})" class="btn-icon" title="Edit"><span class="material-symbols-outlined text-sm">edit</span></button>
                                <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus dokumen ini?" class="btn-icon text-red-500" title="Hapus"><span class="material-symbols-outlined text-sm">delete</span></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada dokumen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
