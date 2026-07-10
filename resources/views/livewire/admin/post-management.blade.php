<div>
    {{-- ─── HEADER ─────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Kelola Berita</h2>
            <p class="text-sm text-gray-500 mt-0.5">Tambah, edit, dan kelola berita nagari</p>
        </div>
        <button wire:click="create" class="btn-primary btn-sm">
            <span class="material-symbols-outlined text-base">add</span> Tambah Berita
        </button>
    </div>

    <x-page-guide title="Panduan Kelola Berita" description="Kelola berita dan pengumuman nagari. Tulis judul, ringkasan, dan konten berita dengan editor teks. Upload gambar sampul untuk setiap berita. Berita yang dipublish akan tampil di halaman Berita pada website publik dengan format yang menarik." />

    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' Berita'" subtitle="Isi formulir dengan lengkap" :icon="$editingId ? 'edit' : 'add'" iconBg="bg-desa-100" iconColor="text-desa-600" maxWidth="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Judul</strong> — Buat judul yang jelas dan informatif (maks 255 karakter)</li>
                    <li><strong>Kategori</strong> — Pilih kategori yang sesuai agar berita mudah ditemukan</li>
                    <li><strong>Ringkasan</strong> — Tulis ringkasan 1-2 kalimat untuk preview di halaman utama</li>
                    <li><strong>Isi Berita</strong> — Gunakan editor untuk format teks (bold, italic, heading, link)</li>
                    <li><strong>Thumbnail</strong> — Foto utama berita, rasio 16:9 disarankan, maks 2MB</li>
                    <li><strong>Status</strong> — Pilih <em>Draft</em> untuk simpan sementara, atau <em>Published</em> untuk langsung tampil</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="form-label">Judul <span class="text-red-400">*</span></label><input type="text" wire:model="title" class="form-input w-full" placeholder="Masukkan judul berita">@error('title')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Kategori <span class="text-red-400">*</span></label><select wire:model="category_id" class="form-input w-full"><option value="">— Pilih —</option>@foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select>@error('category_id')<p class="form-error">{{ $message }}</p>@enderror</div>
            </div>
            <div><label class="form-label">Ringkasan</label><textarea wire:model="excerpt" class="form-input w-full" rows="2" placeholder="Ringkasan singkat"></textarea></div>
            <x-trix-editor name="body" :value="$body" label="Isi Berita *" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-admin-image-upload wireModel="thumbnail" label="Thumbnail" :existingUrl="$existingThumbnail ? Storage::url($existingThumbnail) : null" icon="photo_camera" />
                <div><label class="form-label">Status</label><select wire:model="status" class="form-input w-full"><option value="draft">Draft</option><option value="published">Published</option></select></div>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save"><span wire:loading.remove wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base">save</span> Simpan</span><span wire:loading wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...</span></button>
                <button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button>
            </div>
        </form>
    </x-admin-modal>

    {{-- ─── SEARCH ─────────────────────────────────── --}}
    <div class="card p-4 mb-6">
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari judul berita..."
                class="form-input pl-10 w-full sm:w-80">
        </div>
    </div>

    {{-- ─── TABLE ─────────────────────────────────── --}}
    <div class="card overflow-hidden">
        <div class="table-container border-0 shadow-none">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Tanggal</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="font-medium max-w-xs truncate">{{ $post->title }}</td>
                            <td><span class="badge badge-desa">{{ $post->category?->name ?? '-' }}</span></td>
                            <td>
                                <button wire:click="toggleStatus({{ $post->id }})"
                                    class="badge cursor-pointer {{ $post->status === 'published' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $post->status }}
                                </button>
                            </td>
                            <td>{{ number_format($post->views) }}</td>
                            <td class="text-xs text-gray-400">{{ $post->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="flex justify-end gap-1">
                                    <button wire:click="edit({{ $post->id }})"
                                        class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600 transition-colors">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <button onclick="confirmAction({{ $post->id }}, 'deleteConfirmed', 'Yakin ingin menghapus berita ini?')"
                                        class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <span class="material-symbols-outlined text-4xl text-gray-200 mb-2">newspaper</span>
                                <p class="text-gray-400 text-sm">Belum ada berita.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $posts->links() }}</div>
</div>
