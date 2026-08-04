<div>
    {{-- ─── HEADER ─────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Kelola UMKM</h2>
            <p class="text-sm text-gray-500 mt-0.5">Tambah, edit, dan kelola data UMKM nagari</p>
        </div>
        <button wire:click="create" class="btn-primary btn-sm">
            <span class="material-symbols-outlined text-base">add</span> Tambah
        </button>
    </div>

    <x-page-guide title="Panduan Kelola UMKM" description="Kelola direktori UMKM dan usaha lokal nagari. Tambahkan nama usaha, pemilik, deskripsi, kontak, dan foto produk. UMKM yang aktif akan tampil di halaman UMKM pada website publik untuk mempromosikan usaha warga nagari." />
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

    {{-- Detail Modal --}}
    @if($detailProduct)
        <x-admin-modal :show="$showDetailModal" title="Detail UMKM" subtitle="{{ $detailProduct->business_name }}" icon="storefront" iconBg="bg-amber-100" iconColor="text-amber-600" maxWidth="max-w-2xl">
            <div class="space-y-6">
                {{-- Banner Photo --}}
                <div class="aspect-video rounded-xl bg-gray-100 overflow-hidden border border-gray-200">
                    @if($detailProduct->photo)
                        <img src="{{ Storage::url($detailProduct->photo) }}" alt="{{ $detailProduct->business_name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-amber-50 text-amber-300">
                            <span class="material-symbols-outlined text-6xl mb-1">storefront</span>
                            <span class="text-xs text-amber-500 font-medium">Foto Belum Diunggah</span>
                        </div>
                    @endif
                </div>

                {{-- Detail Table Info --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-0.5">Nama Usaha</span>
                        <span class="font-bold text-gray-900 text-base">{{ $detailProduct->business_name }}</span>
                    </div>
                    <div class="p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-0.5">Pemilik Usaha</span>
                        <span class="font-bold text-gray-900 text-base">{{ $detailProduct->owner_name }}</span>
                    </div>
                    <div class="p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-0.5">Kategori</span>
                        <span class="font-bold text-amber-700">{{ $detailProduct->category ?? '-' }}</span>
                    </div>
                    <div class="p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-0.5">Status Tampil</span>
                        <span class="badge {{ $detailProduct->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $detailProduct->is_active ? 'Aktif (Tampil Publik)' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>

                @if($detailProduct->whatsapp)
                    <div class="p-3.5 bg-emerald-50/60 rounded-xl border border-emerald-100 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-semibold text-emerald-700 uppercase tracking-wider block mb-0.5">Kontak WhatsApp</span>
                            <span class="font-bold text-emerald-900 text-sm">{{ $detailProduct->whatsapp }}</span>
                        </div>
                        @php
                            $waNum = preg_replace('/[^0-9]/', '', $detailProduct->whatsapp);
                            if (str_starts_with($waNum, '0')) {
                                $waNum = '62' . substr($waNum, 1);
                            }
                        @endphp
                        <a href="https://wa.me/{{ $waNum }}" target="_blank" rel="noopener" class="btn-primary btn-sm bg-emerald-600 hover:bg-emerald-700 text-xs">
                            <span class="material-symbols-outlined text-sm">chat</span> Buka WA
                        </a>
                    </div>
                @endif

                @if($detailProduct->address)
                    <div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Alamat Usaha</span>
                        <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-xl border border-gray-100">{{ $detailProduct->address }}</p>
                    </div>
                @endif

                @if($detailProduct->description)
                    <div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Deskripsi & Produk</span>
                        <div class="text-sm text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-100 leading-relaxed whitespace-pre-line">
                            {{ $detailProduct->description }}
                        </div>
                    </div>
                @endif

                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                    <a href="{{ route('umkm.show', $detailProduct->id) }}" target="_blank" class="text-xs font-semibold text-amber-600 hover:text-amber-700 inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">open_in_new</span> Lihat Tampilan Publik
                    </a>
                    <button type="button" wire:click="$set('showDetailModal', false)" class="btn-secondary btn-sm">Tutup</button>
                </div>
            </div>
        </x-admin-modal>
    @endif



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
                                    <button wire:click="viewDetail({{ $p->id }})"
                                        class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-amber-50 hover:text-amber-600 transition-colors" title="Lihat Detail">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </button>
                                    <button wire:click="edit({{ $p->id }})"
                                        class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600 transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <button onclick="confirmAction({{ $p->id }}, 'deleteConfirmed', 'Yakin ingin menghapus data ini?')"
                                        class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors" title="Hapus">
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
