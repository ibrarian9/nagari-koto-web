<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">PPID — Informasi Setiap Saat</h2><p class="text-sm text-gray-500 mt-0.5">Kelola dokumen informasi yang tersedia kapan saja</p></div>
        <button wire:click="create" class="btn-primary"><span class="material-symbols-outlined text-sm">add</span> Tambah Dokumen</button>
    </div>

    @if($showForm)
    <div class="card p-6 mb-6">
        <h3 class="font-semibold mb-4">{{ $editingId ? 'Edit' : 'Tambah' }} Dokumen</h3>
        <form wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><label class="form-label">Judul</label><input type="text" wire:model="title" class="form-input w-full">@error('title')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Kategori</label><select wire:model="category" class="form-input w-full"><option value="">Pilih</option>@foreach($categories as $k => $v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select>@error('category')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Tahun</label><input type="number" wire:model="year" class="form-input w-full" min="2000" max="2099">@error('year')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">File Dokumen <span class="text-xs text-gray-400 font-normal">(PDF/DOC/XLS, maks 2MB)</span> {{ $editingId ? '(opsional)' : '' }}</label><input type="file" wire:model="file" class="form-input w-full text-sm" accept=".pdf,.doc,.docx,.xls,.xlsx">@error('file')<p class="form-error">{{ $message }}</p>@enderror</div>



            </div>
            <div><label class="form-label">Deskripsi</label><textarea wire:model="description" class="form-input w-full" rows="2"></textarea></div>
            <div class="flex items-center gap-2"><input type="checkbox" wire:model="is_published" id="pub2" class="rounded border-gray-300 text-desa-600"><label for="pub2" class="text-sm text-gray-700">Publikasikan</label></div>
            <div class="flex gap-3"><button type="submit" class="btn-primary" wire:loading.attr="disabled">Simpan</button><button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button></div>
        </form>
    </div>
    @endif

    <div class="flex flex-wrap gap-3 mb-6">
        <input type="text" wire:model.live.debounce.300ms="search" class="form-input w-60" placeholder="Cari...">
        <select wire:model.live="filterCategory" class="form-input w-48"><option value="">Semua Kategori</option>@foreach($categories as $k => $v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select>
    </div>

    <div class="table-container"><table class="data-table"><thead><tr><th>Judul</th><th>Kategori</th><th>Tahun</th><th>File</th><th>Download</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
        @forelse($items as $item)
        <tr>
            <td class="font-medium text-sm">{{ Str::limit($item->title, 40) }}</td>
            <td><span class="badge bg-emerald-50 text-emerald-700 text-xs">{{ $item->category_label }}</span></td>
            <td class="text-sm">{{ $item->year }}</td>
            <td><span class="badge {{ $item->file_extension === 'PDF' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }} text-xs">{{ $item->file_extension }}</span> <span class="text-xs text-gray-400">{{ $item->file_size_formatted }}</span></td>
            <td class="text-sm">{{ number_format($item->download_count) }}×</td>
            <td><span class="badge {{ $item->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }} text-xs">{{ $item->is_published ? 'Publik' : 'Draft' }}</span></td>
            <td class="flex gap-1">
                <button wire:click="edit({{ $item->id }})" class="text-desa-600"><span class="material-symbols-outlined text-lg">edit</span></button>
                <button onclick="confirmAction({{ $item->id }}, 'deleteConfirmed', 'Hapus dokumen ini?')" class="text-red-500"><span class="material-symbols-outlined text-lg">delete</span></button>
            </td>
        </tr>
        @empty<tr><td colspan="7" class="text-center text-gray-400 py-8">Belum ada data.</td></tr>@endforelse
    </tbody></table></div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
