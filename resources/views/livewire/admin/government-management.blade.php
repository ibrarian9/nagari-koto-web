<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Perangkat Desa</h2><p class="text-sm text-gray-500 mt-0.5">Kelola data perangkat dan aparatur nagari</p></div>
        <button wire:click="create" class="btn-primary btn-sm"><span class="material-symbols-outlined text-base">add</span> Tambah</button>
    </div>
    <x-page-guide title="Panduan Perangkat Desa" description="Kelola data perangkat dan aparatur nagari. Tambahkan nama, jabatan (Wali Nagari, Sekretaris, dll), NIP jika ada, dan foto profil. Atur urutan tampil untuk mengatur hierarki di halaman Pemerintahan pada website publik." />
    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' Perangkat'" subtitle="Isi data perangkat desa" :icon="$editingId ? 'edit' : 'person_add'" iconBg="bg-desa-100" iconColor="text-desa-600">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Nama</strong> — Isi dengan nama lengkap beserta gelar (cth: H. Syafrizal, S.Pd)</li>
                    <li><strong>Jabatan</strong> — Posisi resmi di pemerintahan nagari (cth: Wali Nagari, Sekretaris, Kaur Keuangan)</li>
                    <li><strong>Urutan</strong> — Angka untuk menentukan urutan tampil di halaman publik (0 = paling atas)</li>
                    <li><strong>Foto</strong> — Upload foto formal berukuran maks 2MB (format JPG/PNG/WebP)</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="form-label">Nama <span class="text-red-400">*</span></label><input type="text" wire:model="name" class="form-input w-full" placeholder="Nama lengkap">@error('name')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Jabatan <span class="text-red-400">*</span></label><input type="text" wire:model="position" class="form-input w-full" placeholder="cth: Wali Nagari">@error('position')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Urutan</label><input type="number" wire:model="order" class="form-input w-full" placeholder="0"></div>
                <div><x-admin-image-upload wireModel="photo" label="Foto" :existingUrl="$existingPhoto ? Storage::url($existingPhoto) : null" icon="person" /></div>
            </div>
            <label class="inline-flex items-center gap-2.5 cursor-pointer select-none group"><input type="checkbox" wire:model="is_active" class="form-checkbox"><span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">Aktif</span></label>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save"><span wire:loading.remove wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base">save</span> Simpan</span><span wire:loading wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...</span></button>
                <button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button>
            </div>
        </form>
    </x-admin-modal>

    <div class="card overflow-hidden">
        <div class="table-container border-0 shadow-none"><table class="data-table"><thead><tr><th>Urutan</th><th>Foto</th><th>Nama</th><th>Jabatan</th><th>Status</th><th class="text-right">Aksi</th></tr></thead><tbody>
            @forelse($members as $m)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td><div class="flex gap-1 items-center"><button wire:click="moveUp({{ $m->id }})" class="h-7 w-7 rounded-md flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors"><span class="material-symbols-outlined text-sm">arrow_upward</span></button><button wire:click="moveDown({{ $m->id }})" class="h-7 w-7 rounded-md flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors"><span class="material-symbols-outlined text-sm">arrow_downward</span></button><span class="text-gray-500 text-sm ml-1">{{ $m->order }}</span></div></td>
                    <td><div class="h-10 w-10 rounded-full bg-gray-100 overflow-hidden">@if($m->photo)<img src="{{ Storage::url($m->photo) }}" class="h-full w-full object-cover">@else<div class="h-full w-full flex items-center justify-center"><span class="material-symbols-outlined text-gray-300">person</span></div>@endif</div></td>
                    <td class="font-medium">{{ $m->name }}</td><td>{{ $m->position }}</td>
                    <td><span class="badge {{ $m->is_active ? 'badge-success' : 'badge-danger' }}">{{ $m->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td><div class="flex justify-end gap-1"><button wire:click="edit({{ $m->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600 transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button><button onclick="confirmAction({{ $m->id }}, 'deleteConfirmed', 'Yakin ingin menghapus data ini?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button></div></td>
                </tr>
            @empty<tr><td colspan="6" class="text-center py-12"><span class="material-symbols-outlined text-4xl text-gray-200 mb-2">groups</span><p class="text-gray-400 text-sm">Belum ada data.</p></td></tr>@endforelse
        </tbody></table></div>
    </div>
</div>
