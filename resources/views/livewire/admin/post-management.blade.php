<div>
    {{-- ─── HEADER ─────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Kelola Berita</h2>
            <p class="text-sm text-gray-500 mt-0.5">Tambah, edit, dan kelola berita serta kategori berita nagari</p>
        </div>
        <div class="flex items-center gap-2">
            <button wire:click="openCategoryModal" class="btn-secondary btn-sm">
                <span class="material-symbols-outlined text-base">category</span> Kelola Kategori
            </button>
            <button wire:click="create" class="btn-primary btn-sm">
                <span class="material-symbols-outlined text-base">add</span> Tambah Berita
            </button>
        </div>
    </div>

    <x-page-guide title="Panduan Kelola Berita" description="Kelola berita dan pengumuman nagari. Tulis judul, ringkasan, dan konten berita dengan editor teks. Upload gambar sampul untuk setiap berita. Berita yang dipublish akan tampil di halaman Berita pada website publik dengan format yang menarik." />

    {{-- ─── FORM MODAL BERITA ────────────────────────── --}}
    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' Berita'" subtitle="Isi formulir dengan lengkap" :icon="$editingId ? 'edit' : 'add'" iconBg="bg-desa-100" iconColor="text-desa-600" maxWidth="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Judul</strong> — Buat judul yang jelas dan informatif (maks 255 karakter)</li>
                    <li><strong>Kategori</strong> — Pilih kategori yang sesuai atau tambah kategori baru</li>
                    <li><strong>Ringkasan</strong> — Tulis ringkasan 1-2 kalimat untuk preview di halaman utama</li>
                    <li><strong>Isi Berita</strong> — Gunakan editor untuk format teks (bold, italic, heading, link)</li>
                    <li><strong>Thumbnail</strong> — Foto utama berita, rasio 16:9 disarankan, maks 2MB</li>
                    <li><strong>Status</strong> — Pilih <em>Draft</em> untuk simpan sementara, atau <em>Published</em> untuk langsung tampil</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Judul <span class="text-red-400">*</span></label>
                    <input type="text" wire:model="title" class="form-input w-full" placeholder="Masukkan judul berita">
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="form-label mb-0">Kategori <span class="text-red-400">*</span></label>
                        <button type="button" wire:click="openCategoryModal" class="text-xs text-desa-600 hover:text-desa-700 font-bold flex items-center gap-1 transition-colors">
                            <span class="material-symbols-outlined text-sm">add_circle</span> Tambah / Kelola
                        </button>
                    </div>
                    <select wire:model="category_id" class="form-input w-full">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="form-label">Ringkasan</label>
                <textarea wire:model="excerpt" class="form-input w-full" rows="2" placeholder="Ringkasan singkat berita"></textarea>
            </div>
            <x-trix-editor name="body" :value="$body" label="Isi Berita *" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-admin-image-upload wireModel="thumbnail" label="Thumbnail" :existingUrl="$existingThumbnail ? Storage::url($existingThumbnail) : null" icon="photo_camera" />
                <div>
                    <label class="form-label">Status</label>
                    <select wire:model="status" class="form-input w-full">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base">save</span> Simpan</span>
                    <span wire:loading wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...</span>
                </button>
                <button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button>
            </div>
        </form>
    </x-admin-modal>

    {{-- ─── MODAL KELOLA KATEGORI ─────────────────────── --}}
    <x-admin-modal :show="$showCategoryModal" title="Kelola Kategori Berita" subtitle="Tambah atau edit daftar kategori berita" icon="category" iconBg="bg-amber-100" iconColor="text-amber-700" maxWidth="max-w-xl">
        <div class="space-y-6">
            {{-- Form Tambah Kategori Baru --}}
            <div class="bg-gray-50/80 p-4 rounded-xl border border-gray-200">
                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tambah Kategori Baru</h4>
                <form wire:submit="addCategory" class="flex gap-2">
                    <div class="flex-1">
                        <input type="text" wire:model="newCategoryName" class="form-input w-full text-sm" placeholder="Nama kategori baru (cth: Pengumuman, Pembangunan)">
                        @error('newCategoryName')<p class="form-error text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn-primary btn-sm flex-shrink-0" wire:loading.attr="disabled" wire:target="addCategory">
                        <span class="material-symbols-outlined text-base">add</span> Simpan
                    </button>
                </form>
            </div>

            {{-- List Kategori --}}
            <div>
                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Daftar Kategori Berita ({{ $categories->count() }})</h4>
                <div class="border border-gray-200 rounded-xl overflow-hidden divide-y divide-gray-100 max-h-60 overflow-y-auto">
                    @forelse($categories as $cat)
                        <div class="p-3 flex items-center justify-between bg-white hover:bg-gray-50/80 transition-colors">
                            @if($editingCategoryId === $cat->id)
                                {{-- Inline edit form --}}
                                <form wire:submit="updateCategory" class="flex items-center gap-2 flex-1 mr-2">
                                    <input type="text" wire:model="editingCategoryName" class="form-input py-1 px-2.5 text-xs flex-1">
                                    <button type="submit" class="btn-primary btn-sm px-2.5 py-1 text-xs">Simpan</button>
                                    <button type="button" wire:click="cancelEditCategory" class="btn-secondary btn-sm px-2.5 py-1 text-xs">Batal</button>
                                </form>
                            @else
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $cat->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $cat->posts()->count() }} Berita</p>
                                </div>
                                <div class="flex items-center gap-1">
                                    <button wire:click="editCategory({{ $cat->id }})" title="Edit Name" class="h-7 w-7 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600 transition-colors">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </button>
                                    <button wire:click="deleteCategory({{ $cat->id }})" title="Hapus Kategori" class="h-7 w-7 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-400 text-xs">Belum ada kategori.</div>
                    @endforelse
                </div>
            </div>

            <div class="pt-3 border-t border-gray-100 flex justify-end">
                <button type="button" wire:click="$set('showCategoryModal', false)" class="btn-secondary btn-sm">Tutup</button>
            </div>
        </div>
    </x-admin-modal>

    {{-- ─── SEARCH & FILTER ──────────────────────────── --}}
    <div class="card p-4 mb-6">
        <div class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari judul berita..."
                    class="form-input pl-10 w-full">
            </div>
            <div class="w-full sm:w-64">
                <select wire:model.live="categoryFilter" class="form-input w-full text-xs">
                    <option value="">— Semua Kategori —</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
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
                            <td><span class="badge badge-desa">{{ $post->category?->name ?? 'Tanpa Kategori' }}</span></td>
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
                                <p class="text-gray-400 text-sm">Belum ada berita yang ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $posts->links() }}</div>
</div>
