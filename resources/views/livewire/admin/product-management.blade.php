<div>
    {{-- ─── HEADER ─────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Kelola UMKM</h2>
            <p class="text-sm text-gray-500 mt-0.5">Tambah, edit, dan kelola data UMKM desa</p>
        </div>
        <button wire:click="create" class="btn-primary btn-sm">
            <span class="material-symbols-outlined text-base">add</span> Tambah
        </button>
    </div>

    <x-page-guide title="Panduan Kelola UMKM" description="Kelola direktori UMKM dan usaha lokal desa. Tambahkan nama usaha, pemilik, deskripsi, kontak, dan foto produk. UMKM yang aktif akan tampil di halaman UMKM pada website publik untuk mempromosikan usaha warga desa." />
    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' UMKM'" subtitle="Isi data usaha dengan lengkap" :icon="$editingId ? 'edit' : 'add_business'" iconBg="bg-amber-100" iconColor="text-amber-600" maxWidth="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Nama Pemilik</strong> — Nama lengkap pemilik usaha</li>
                    <li><strong>Nama Usaha</strong> — Nama brand/toko yang dikenal masyarakat</li>
                    <li><strong>Kategori</strong> — Jenis usaha (cth: Kuliner, Kerajinan, Minuman, Pertanian)</li>
                    <li><strong>WhatsApp</strong> — Nomor WA aktif untuk pemesanan (format: 08xxx)</li>
                    <li><strong>Deskripsi</strong> — Ceritakan produk unggulan, harga kisaran, dan jam buka</li>
                    <li><strong>Foto</strong> — Foto produk atau tampak depan usaha, maks 2MB</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="form-label">Nama Pemilik <span class="text-red-400">*</span></label><input type="text" wire:model="owner_name" class="form-input w-full" placeholder="Nama lengkap pemilik">@error('owner_name')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Nama Usaha <span class="text-red-400">*</span></label><input type="text" wire:model="business_name" class="form-input w-full" placeholder="Nama usaha / toko">@error('business_name')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Kategori</label><input type="text" wire:model="category" class="form-input w-full" placeholder="cth: Makanan, Kerajinan"></div>
                <div><label class="form-label">WhatsApp</label><input type="text" wire:model="whatsapp" class="form-input w-full" placeholder="08xxxxxxxxxx"></div>
            </div>
            <div><label class="form-label">Deskripsi</label><textarea wire:model="description" class="form-input w-full" rows="3" placeholder="Deskripsikan usaha dan produk"></textarea></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="form-label">Alamat</label><textarea wire:model="address" class="form-input w-full" rows="2" placeholder="Alamat lengkap usaha"></textarea></div>
                <x-admin-image-upload wireModel="photo" label="Foto Produk" :existingUrl="$existingPhoto ? Storage::url($existingPhoto) : null" icon="storefront" />
            </div>
            <label class="inline-flex items-center gap-2.5 cursor-pointer select-none group"><input type="checkbox" wire:model="is_active" class="form-checkbox"><span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">Aktif</span></label>
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
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama usaha..."
                class="form-input pl-10 w-full sm:w-80">
        </div>
    </div>

    {{-- ─── TABLE ─────────────────────────────────── --}}
    <div class="card overflow-hidden">
        <div class="table-container border-0 shadow-none">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Usaha</th>
                        <th>Pemilik</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="font-medium">{{ $p->business_name }}</td>
                            <td>{{ $p->owner_name }}</td>
                            <td>{{ $p->category ?? '-' }}</td>
                            <td>
                                <button wire:click="toggleActive({{ $p->id }})"
                                    class="badge cursor-pointer {{ $p->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td>
                                <div class="flex justify-end gap-1">
                                    <button wire:click="edit({{ $p->id }})"
                                        class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600 transition-colors">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <button onclick="confirmAction({{ $p->id }}, 'deleteConfirmed', 'Yakin ingin menghapus data ini?')"
                                        class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12">
                                <span class="material-symbols-outlined text-4xl text-gray-200 mb-2">storefront</span>
                                <p class="text-gray-400 text-sm">Belum ada data UMKM.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
