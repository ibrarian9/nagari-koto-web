<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Program Kerja BUMNag</h2><p class="text-sm text-gray-500 mt-0.5">Kelola data program kerja dan kegiatan BUMNag</p></div>
        <button wire:click="create" class="btn-primary btn-sm"><span class="material-symbols-outlined text-base">add</span> Tambah</button>
    </div>

    <x-page-guide title="Panduan Program Kerja" description="Masukkan data program kerja BUMNag: nama kegiatan, kepala unit usaha yang bertanggung jawab, keterangan kegiatan, output/hasil program, kendala yang dihadapi, dan penerima manfaat." />

    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' Program Kerja'" subtitle="Data kegiatan BUMNag" icon="assignment" iconBg="bg-blue-100" iconColor="text-blue-600" maxWidth="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Nama Kegiatan</strong> — Judul program kerja yang dilaksanakan</li>
                    <li><strong>Kepala Unit Usaha</strong> — Penanggungjawab kegiatan</li>
                    <li><strong>Keterangan</strong> — Deskripsi detail kegiatan</li>
                    <li><strong>Output Program</strong> — Hasil/capaian yang diharapkan</li>
                    <li><strong>Kendala</strong> — Hambatan dalam pelaksanaan (jika ada)</li>
                    <li><strong>Penerima Manfaat</strong> — Siapa yang menikmati manfaat program</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2"><label class="form-label">Nama Kegiatan <span class="text-red-400">*</span></label><input type="text" wire:model="nama_kegiatan" class="form-input w-full" placeholder="Nama program kerja">@error('nama_kegiatan')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Kepala Unit Usaha</label><input type="text" wire:model="kepala_unit_usaha" class="form-input w-full" placeholder="Nama penanggung jawab"></div>
                <div><label class="form-label">Penerima Manfaat</label><input type="text" wire:model="penerima_manfaat" class="form-input w-full" placeholder="cth: Masyarakat Nagari"></div>
                <div class="md:col-span-2"><label class="form-label">Keterangan</label><textarea wire:model="keterangan" class="form-input w-full" rows="3" placeholder="Deskripsi detail kegiatan"></textarea></div>
                <div><label class="form-label">Output Program</label><textarea wire:model="output_program" class="form-input w-full" rows="3" placeholder="Hasil/capaian program"></textarea></div>
                <div><label class="form-label">Kendala</label><textarea wire:model="kendala" class="form-input w-full" rows="3" placeholder="Hambatan dalam pelaksanaan"></textarea></div>
                <div><label class="form-label">Tahun</label><input type="number" wire:model="tahun" class="form-input w-full" placeholder="2024"></div>
                <div><label class="form-label">Urutan</label><input type="number" wire:model="order" class="form-input w-full" placeholder="0"></div>
            </div>
            <label class="inline-flex items-center gap-2.5 cursor-pointer select-none group"><input type="checkbox" wire:model="is_active" class="form-checkbox"><span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">Aktif</span></label>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save"><span wire:loading.remove wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base">save</span> Simpan</span><span wire:loading wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...</span></button>
                <button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button>
            </div>
        </form>
    </x-admin-modal>

    <div class="card overflow-hidden">
        <div class="table-container border-0 shadow-none"><table class="data-table"><thead><tr><th>No</th><th>Kegiatan</th><th>Kepala Unit</th><th>Tahun</th><th>Penerima Manfaat</th><th>Status</th><th class="text-right">Aksi</th></tr></thead><tbody>
            @forelse($programs as $p)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td>{{ $p->order }}</td>
                    <td class="font-medium max-w-[200px]"><p class="truncate">{{ $p->nama_kegiatan }}</p></td>
                    <td class="text-sm text-gray-500">{{ $p->kepala_unit_usaha ?: '-' }}</td>
                    <td>{{ $p->tahun ?: '-' }}</td>
                    <td class="text-sm text-gray-500 max-w-[150px] truncate">{{ $p->penerima_manfaat ?: '-' }}</td>
                    <td><span class="badge {{ $p->is_active ? 'badge-success' : 'badge-danger' }}">{{ $p->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td><div class="flex justify-end gap-1"><button wire:click="edit({{ $p->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600 transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button><button onclick="confirmAction({{ $p->id }}, 'deleteConfirmed', 'Yakin ingin menghapus program ini?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button></div></td>
                </tr>
            @empty<tr><td colspan="7" class="text-center py-12"><span class="material-symbols-outlined text-4xl text-gray-200 mb-2">assignment</span><p class="text-gray-400 text-sm">Belum ada data.</p></td></tr>@endforelse
        </tbody></table></div>
    </div>
</div>
