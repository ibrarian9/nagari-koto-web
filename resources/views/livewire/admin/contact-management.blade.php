<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Kelola Kontak</h2><p class="text-sm text-gray-500 mt-0.5">Nomor penting dan kontak nagari</p></div>
        <button wire:click="create" class="btn-primary btn-sm"><span class="material-symbols-outlined text-base">add</span> Tambah</button>
    </div>
    <x-page-guide title="Panduan Kelola Kontak" description="Kelola daftar kontak penting nagari seperti nomor kantor nagari, puskesmas, kepolisian, dll. Atur urutan tampil dan kategori kontak. Kontak yang ditambahkan akan tampil di halaman Kontak pada website publik." />

    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' Kontak'" subtitle="Isi data kontak penting" icon="call" iconBg="bg-teal-100" iconColor="text-teal-600">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Label</strong> — Nama instansi atau layanan (cth: Kantor Wali Nagari, Puskesmas)</li>
                    <li><strong>Telepon</strong> — Nomor telepon yang bisa dihubungi (format: 0752-xxx atau 08xxx)</li>
                    <li><strong>Kategori</strong> — Darurat (polisi, ambulans), Pemerintahan, Kesehatan, atau Sosial</li>
                    <li><strong>Urutan</strong> — Angka untuk mengurutkan tampilan (0 = paling atas)</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="form-label">Label <span class="text-red-400">*</span></label><input type="text" wire:model="label" class="form-input w-full" placeholder="cth: Kantor Wali Nagari">@error('label')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Telepon <span class="text-red-400">*</span></label><input type="text" wire:model="phone" class="form-input w-full" placeholder="0752-123456">@error('phone')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Kategori <span class="text-red-400">*</span></label><select wire:model="category" class="form-input w-full"><option value="">— Pilih —</option><option value="emergency">Darurat</option><option value="government">Pemerintahan</option><option value="health">Kesehatan</option><option value="social">Sosial</option></select>@error('category')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Urutan</label><input type="number" wire:model="order" class="form-input w-full"></div>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save"><span wire:loading.remove wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base">save</span> Simpan</span><span wire:loading wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...</span></button>
                <button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button>
            </div>
        </form>
    </x-admin-modal>

    <div class="card overflow-hidden"><div class="table-container border-0 shadow-none"><table class="data-table"><thead><tr><th>Label</th><th>Telepon</th><th>Kategori</th><th>Urutan</th><th class="text-right">Aksi</th></tr></thead><tbody>
        @forelse($contacts as $c)<tr class="hover:bg-gray-50/50 transition-colors"><td class="font-medium">{{ $c->label }}</td><td>{{ $c->phone }}</td><td><span class="badge badge-info">{{ ucfirst($c->category) }}</span></td><td>{{ $c->order }}</td><td><div class="flex justify-end gap-1"><button wire:click="edit({{ $c->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600 transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button><button onclick="confirmAction({{ $c->id }}, 'deleteConfirmed', 'Yakin ingin menghapus data ini?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button></div></td></tr>
        @empty<tr><td colspan="5" class="text-center py-12"><span class="material-symbols-outlined text-4xl text-gray-200 mb-2">call</span><p class="text-gray-400 text-sm">Belum ada data.</p></td></tr>@endforelse
    </tbody></table></div></div>
</div>
