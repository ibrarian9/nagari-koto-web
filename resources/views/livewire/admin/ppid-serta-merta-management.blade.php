<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">PPID — Informasi Serta Merta</h2><p class="text-sm text-gray-500 mt-0.5">Kelola pengumuman darurat / serta merta</p></div>
        <button wire:click="create" class="btn-primary"><span class="material-symbols-outlined text-sm">add</span> Tambah Pengumuman</button>
    </div>

    @if($showForm)
    <div class="card p-6 mb-6">
        <h3 class="font-semibold mb-4">{{ $editingId ? 'Edit' : 'Tambah' }} Pengumuman</h3>
        <form wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><label class="form-label">Judul</label><input type="text" wire:model="title" class="form-input w-full">@error('title')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Tingkat Urgensi</label>
                    <select wire:model="urgency" class="form-input w-full">
                        <option value="rendah">🔵 Rendah</option>
                        <option value="sedang">🟡 Sedang</option>
                        <option value="tinggi">🟠 Tinggi</option>
                        <option value="kritis">🔴 Kritis</option>
                    </select>
                    @error('urgency')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="form-label">Konten</label>
                <div wire:ignore>
                    <input id="serta-merta-content" type="hidden" value="{{ $content }}">
                    <trix-editor input="serta-merta-content" class="trix-content form-input min-h-[120px]"
                        x-on:trix-change="$wire.set('content', $event.target.value)"></trix-editor>
                </div>
                @error('content')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center gap-2"><input type="checkbox" wire:model="is_active" id="act" class="rounded border-gray-300 text-desa-600"><label for="act" class="text-sm text-gray-700">Aktif (tampil di publik)</label></div>
            <div class="flex gap-3"><button type="submit" class="btn-primary">Simpan</button><button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button></div>
        </form>
    </div>
    @endif

    <div class="mb-6"><input type="text" wire:model.live.debounce.300ms="search" class="form-input w-60" placeholder="Cari..."></div>

    <div class="table-container"><table class="data-table"><thead><tr><th>Judul</th><th>Urgensi</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead><tbody>
        @forelse($items as $item)
        <tr>
            <td class="font-medium text-sm">{{ Str::limit($item->title, 50) }}</td>
            <td><span class="badge {{ $item->urgency_color }} text-xs">{{ $item->urgency_label }}</span></td>
            <td><span class="badge {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }} text-xs">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
            <td class="text-xs text-gray-500">{{ $item->published_at?->format('d/m/Y H:i') }}</td>
            <td class="flex gap-1">
                <button wire:click="edit({{ $item->id }})" class="text-desa-600"><span class="material-symbols-outlined text-lg">edit</span></button>
                <button onclick="confirmAction({{ $item->id }}, 'delete', 'Hapus pengumuman ini?')" class="text-red-500"><span class="material-symbols-outlined text-lg">delete</span></button>
            </td>
        </tr>
        @empty<tr><td colspan="5" class="text-center text-gray-400 py-8">Belum ada data.</td></tr>@endforelse
    </tbody></table></div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
