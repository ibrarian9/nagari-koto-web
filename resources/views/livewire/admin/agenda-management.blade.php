<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Kelola Agenda</h2><p class="text-sm text-gray-500 mt-0.5">Jadwal kegiatan dan acara desa</p></div>
        <button wire:click="create" class="btn-primary btn-sm"><span class="material-symbols-outlined text-base">add</span> Tambah</button>
    </div>
    <x-page-guide title="Panduan Kelola Agenda" description="Kelola jadwal kegiatan dan acara desa. Tambahkan agenda dengan tanggal, waktu, lokasi, dan deskripsi. Centang 'Publik' agar agenda tampil di halaman website publik. Agenda yang sudah lewat tetap tersimpan sebagai arsip." />

    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' Agenda'" subtitle="Isi data kegiatan" icon="event" iconBg="bg-amber-100" iconColor="text-amber-600">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Judul</strong> — Nama kegiatan (cth: Musyawarah Nagari, Gotong Royong)</li>
                    <li><strong>Lokasi</strong> — Tempat kegiatan dilaksanakan (cth: Balai Adat Jorong Koto Tinggi)</li>
                    <li><strong>Mulai/Selesai</strong> — Tanggal dan waktu pelaksanaan kegiatan</li>
                    <li><strong>Deskripsi</strong> — Penjelasan singkat tentang tujuan dan peserta kegiatan</li>
                    <li><strong>Publik</strong> — Centang jika kegiatan ini ingin ditampilkan di website publik</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="form-label">Judul <span class="text-red-400">*</span></label><input type="text" wire:model="title" class="form-input w-full">@error('title')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Lokasi</label><input type="text" wire:model="location" class="form-input w-full"></div>
                <div><label class="form-label">Mulai <span class="text-red-400">*</span></label><input type="datetime-local" wire:model="start_date" class="form-input w-full">@error('start_date')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Selesai</label><input type="datetime-local" wire:model="end_date" class="form-input w-full"></div>
            </div>
            <div><label class="form-label">Deskripsi</label><textarea wire:model="description" class="form-input w-full" rows="3"></textarea></div>
            <label class="inline-flex items-center gap-2.5 cursor-pointer select-none group"><input type="checkbox" wire:model="is_public" class="form-checkbox"><span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">Publik</span></label>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save"><span wire:loading.remove wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base">save</span> Simpan</span><span wire:loading wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...</span></button>
                <button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button>
            </div>
        </form>
    </x-admin-modal>

    <div class="card overflow-hidden"><div class="table-container border-0 shadow-none"><table class="data-table"><thead><tr><th>Judul</th><th>Tanggal</th><th>Lokasi</th><th>Publik</th><th class="text-right">Aksi</th></tr></thead><tbody>
        @forelse($agendas as $a)<tr class="hover:bg-gray-50/50 transition-colors"><td class="font-medium">{{ $a->title }}</td><td class="text-xs">{{ $a->start_date->format('d/m/Y H:i') }}</td><td>{{ $a->location ?? '-' }}</td><td><span class="badge {{ $a->is_public ? 'badge-success' : 'badge-warning' }}">{{ $a->is_public ? 'Ya' : 'Tidak' }}</span></td><td><div class="flex justify-end gap-1"><button wire:click="edit({{ $a->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600 transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button><button onclick="confirmAction({{ $a->id }}, 'deleteConfirmed', 'Yakin ingin menghapus data ini?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button></div></td></tr>
        @empty<tr><td colspan="5" class="text-center py-12"><span class="material-symbols-outlined text-4xl text-gray-200 mb-2">event</span><p class="text-gray-400 text-sm">Belum ada data.</p></td></tr>@endforelse
    </tbody></table></div></div>
</div>
