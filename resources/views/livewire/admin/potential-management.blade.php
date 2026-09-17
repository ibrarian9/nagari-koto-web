<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Kelola Potensi Nagari</h2><p class="text-sm text-gray-500 mt-0.5">Tambah dan kelola potensi nagari</p></div>
        <div class="flex items-center gap-2">
            <button wire:click="openCategoryModal" class="btn-secondary btn-sm"><span class="material-symbols-outlined text-base">category</span> Kelola Kategori</button>
            <button wire:click="create" class="btn-primary btn-sm"><span class="material-symbols-outlined text-base">add</span> Tambah</button>
        </div>
    </div>
    <x-page-guide title="Panduan Potensi Nagari" description="Kelola data potensi dan kekayaan nagari. Tambahkan potensi dengan judul, kategori (pertanian, perikanan, pariwisata, dll), dan deskripsi. Potensi yang ditambahkan akan ditampilkan di halaman Potensi Nagari pada website publik." />

    {{-- Modal Kelola Kategori --}}
    <x-admin-category-modal
        :show="$showCategoryModal"
        title="Kelola Kategori Potensi"
        subtitle="Tambah, ubah, atau hapus kategori potensi"
        :categories="$categories"
        :editingCategoryId="$editingCategoryId"
        :editingCategoryName="$editingCategoryName"
        :newCategoryName="$newCategoryName"
        iconBg="bg-green-100"
        iconColor="text-green-600"
    />

    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' Potensi'" subtitle="Isi data potensi nagari" :icon="$editingId ? 'edit' : 'eco'" iconBg="bg-green-100" iconColor="text-green-600">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Judul</strong> — Nama potensi nagari yang akan ditampilkan (cth: Air Terjun Kacau)</li>
                    <li><strong>Kategori</strong> — Pilih jenis potensi (bisa ditambahkan via tombol Kelola Kategori)</li>
                    <li><strong>Deskripsi</strong> — Jelaskan potensi secara detail: lokasi, keunggulan, manfaat bagi masyarakat</li>
                    <li><strong>Thumbnail</strong> — Foto representatif dari potensi, maks 2MB</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="form-label">Judul <span class="text-red-400">*</span></label><input type="text" wire:model="title" class="form-input w-full" placeholder="Nama potensi nagari">@error('title')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div>
                    <div class="flex items-center justify-between mb-1"><label class="form-label mb-0">Kategori <span class="text-red-400">*</span></label><button type="button" wire:click="openCategoryModal" class="text-xs text-desa-600 hover:underline flex items-center gap-1"><span class="material-symbols-outlined text-xs">add</span> Kelola</button></div>
                    <select wire:model="category" class="form-input w-full">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
            <x-trix-editor name="description" :value="$description" label="Deskripsi" />
            <x-admin-image-upload wireModel="thumbnail" label="Thumbnail" :existingUrl="$existingThumbnail ? Storage::url($existingThumbnail) : null" icon="landscape" />
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save"><span wire:loading.remove wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base">save</span> Simpan</span><span wire:loading wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...</span></button>
                <button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button>
            </div>
        </form>
    </x-admin-modal>

    <div class="card overflow-hidden"><div class="table-container border-0 shadow-none"><table class="data-table"><thead><tr><th>Judul</th><th>Kategori</th><th class="text-right">Aksi</th></tr></thead><tbody>
        @forelse($potentials as $p)
            @php
                $catObj = $categories->firstWhere('slug', $p->category) ?? $categories->firstWhere('name', $p->category);
                $catLabel = $catObj?->name ?? ucfirst($p->category);
            @endphp
            <tr class="hover:bg-gray-50/50 transition-colors"><td class="font-medium">{{ $p->title }}</td><td><span class="badge badge-success">{{ $catLabel }}</span></td><td><div class="flex justify-end gap-1"><button wire:click="edit({{ $p->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600 transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button><button onclick="confirmAction({{ $p->id }}, 'deleteConfirmed', 'Yakin ingin menghapus data ini?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button></div></td></tr>
        @empty<tr><td colspan="3" class="text-center py-12"><span class="material-symbols-outlined text-4xl text-gray-200 mb-2">eco</span><p class="text-gray-400 text-sm">Belum ada data.</p></td></tr>@endforelse
    </tbody></table></div></div>
</div>
