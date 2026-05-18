<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Lembaga Nagari</h2><p class="text-sm text-gray-500 mt-0.5">Kelola daftar lembaga dan organisasi di nagari</p></div>
        <button wire:click="create" class="btn-primary btn-sm"><span class="material-symbols-outlined text-base">add</span> Tambah</button>
    </div>

    <x-page-guide title="Panduan Lembaga Nagari" description="Kelola data lembaga dan organisasi yang ada di nagari, seperti KAN, PKK, Karang Taruna, LPMN, dan lainnya. Isi nama lembaga, kategori, ketua, deskripsi singkat, dan logo. Data akan ditampilkan di halaman Lembaga Nagari pada website publik." />

    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' Lembaga'" subtitle="Informasi lembaga nagari" :icon="$editingId ? 'edit' : 'domain_add'" iconBg="bg-purple-100" iconColor="text-purple-600" maxWidth="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Nama Lembaga</strong> — Nama resmi lembaga (cth: Kerapatan Adat Nagari, PKK, Karang Taruna)</li>
                    <li><strong>Kategori</strong> — Jenis lembaga: Adat, Kepemudaan, Perempuan, Keagamaan, Sosial, Pendidikan</li>
                    <li><strong>Ketua</strong> — Nama pimpinan/ketua lembaga saat ini</li>
                    <li><strong>Deskripsi</strong> — Penjelasan singkat tentang lembaga, tugas, dan fungsinya</li>
                    <li><strong>Kontak</strong> — Nomor HP atau email lembaga (opsional)</li>
                    <li><strong>Tahun Berdiri</strong> — Tahun didirikannya lembaga (opsional)</li>
                    <li><strong>Logo</strong> — Logo/gambar lembaga, maks 2MB</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="form-label">Nama Lembaga <span class="text-red-400">*</span></label><input type="text" wire:model="name" class="form-input w-full" placeholder="Nama lembaga">@error('name')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Kategori <span class="text-red-400">*</span></label>
                    <select wire:model="type" class="form-input w-full">
                        @foreach(\App\Models\VillageInstitution::TYPES as $k => $v)<option value="{{ $k }}">{{ $v }}</option>@endforeach
                    </select>@error('type')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div><label class="form-label">Ketua / Pimpinan</label><input type="text" wire:model="head_name" class="form-input w-full" placeholder="Nama ketua lembaga"></div>
                <div><label class="form-label">Kontak</label><input type="text" wire:model="contact" class="form-input w-full" placeholder="No HP / Email"></div>
                <div><label class="form-label">Tahun Berdiri</label><input type="number" wire:model="established_year" class="form-input w-full" placeholder="cth: 2010" min="1900" max="2100"></div>
                <div><label class="form-label">Urutan</label><input type="number" wire:model="order" class="form-input w-full" placeholder="0"></div>
            </div>
            <div><label class="form-label">Deskripsi</label><textarea wire:model="description" class="form-input w-full" rows="3" placeholder="Penjelasan singkat tentang lembaga..."></textarea></div>
            <x-admin-image-upload wireModel="logo" label="Logo Lembaga" :existingUrl="$existingLogo ? Storage::url($existingLogo) : null" icon="image" />
            <label class="inline-flex items-center gap-2.5 cursor-pointer select-none group"><input type="checkbox" wire:model="is_active" class="form-checkbox"><span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">Aktif</span></label>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save"><span wire:loading.remove wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base">save</span> Simpan</span><span wire:loading wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...</span></button>
                <button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button>
            </div>
        </form>
    </x-admin-modal>

    <div class="card overflow-hidden">
        <div class="table-container border-0 shadow-none"><table class="data-table"><thead><tr><th>Logo</th><th>Lembaga</th><th>Kategori</th><th>Ketua</th><th>Status</th><th class="text-right">Aksi</th></tr></thead><tbody>
            @forelse($institutions as $inst)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td><div class="h-10 w-10 rounded-lg bg-purple-50 overflow-hidden flex items-center justify-center">@if($inst->logo)<img src="{{ Storage::url($inst->logo) }}" class="h-full w-full object-cover">@else<span class="material-symbols-outlined text-purple-300">domain</span>@endif</div></td>
                    <td>
                        <div><span class="font-medium">{{ $inst->name }}</span></div>
                        @if($inst->established_year)<span class="text-xs text-gray-400">Berdiri {{ $inst->established_year }}</span>@endif
                    </td>
                    <td><span class="badge badge-success">{{ $inst->type_label }}</span></td>
                    <td class="text-sm">{{ $inst->head_name ?? '-' }}</td>
                    <td><span class="badge {{ $inst->is_active ? 'badge-success' : 'badge-danger' }}">{{ $inst->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td><div class="flex justify-end gap-1"><button wire:click="edit({{ $inst->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600 transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button><button onclick="confirmAction({{ $inst->id }}, 'deleteConfirmed', 'Yakin ingin menghapus data ini?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button></div></td>
                </tr>
            @empty<tr><td colspan="6" class="text-center py-12"><span class="material-symbols-outlined text-4xl text-gray-200 mb-2">domain</span><p class="text-gray-400 text-sm">Belum ada data.</p></td></tr>@endforelse
        </tbody></table></div>
    </div>
</div>
