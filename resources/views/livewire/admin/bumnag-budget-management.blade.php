<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Anggaran BUMNag</h2><p class="text-sm text-gray-500 mt-0.5">Kelola data keuangan BUMNag per tahun</p></div>
        <button wire:click="create" class="btn-primary btn-sm"><span class="material-symbols-outlined text-base">add</span> Tambah</button>
    </div>

    <x-page-guide title="Panduan Anggaran BUMNag" description="Masukkan data anggaran BUMNag per tahun: total pendapatan, belanja, realisasi, rincian komponen, dan keterangan/narasi penggunaan anggaran. Data ditampilkan di halaman Anggaran BUMNag publik." />

    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' Anggaran BUMNag'" subtitle="Data keuangan BUMNag tahunan" icon="account_balance" iconBg="bg-blue-100" iconColor="text-blue-600" maxWidth="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Tahun</strong> — Tahun anggaran</li>
                    <li><strong>Total Pendapatan & Belanja</strong> — Dalam rupiah, tanpa titik/koma</li>
                    <li><strong>Realisasi (%)</strong> — Persentase realisasi anggaran (cth: 95.50)</li>
                    <li><strong>Rincian</strong> — Tambahkan komponen anggaran satu per satu</li>
                    <li><strong>Keterangan</strong> — Narasi penggunaan anggaran BUMNag</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div><label class="form-label">Tahun *</label><input type="number" wire:model="year" class="form-input w-full"></div>
                <div><label class="form-label">Total Pendapatan *</label><input type="number" wire:model="total_income" class="form-input w-full"></div>
                <div><label class="form-label">Total Belanja *</label><input type="number" wire:model="total_expenditure" class="form-input w-full"></div>
                <div><label class="form-label">Realisasi (%)</label><input type="number" step="0.01" wire:model="realization_pct" class="form-input w-full"></div>
            </div>
            <div><h4 class="font-medium text-gray-700 mb-2">Rincian Komponen</h4>
                @foreach($apbdes_rows as $i => $row)<div class="flex gap-3 mb-2"><input type="text" wire:model="apbdes_rows.{{ $i }}.label" class="form-input flex-1" placeholder="Nama komponen"><input type="number" wire:model="apbdes_rows.{{ $i }}.value" class="form-input w-40" placeholder="Jumlah"><button type="button" wire:click="removeRow({{ $i }})" class="text-red-500"><span class="material-symbols-outlined">remove_circle</span></button></div>@endforeach
                <button type="button" wire:click="addRow" class="text-sm text-desa-600 flex items-center gap-1"><span class="material-symbols-outlined text-base">add</span> Tambah Komponen</button>
            </div>
            <div>
                <label class="form-label">Keterangan / Narasi Penggunaan Anggaran</label>
                <textarea wire:model="keterangan" class="form-input w-full" rows="4" placeholder="Jelaskan penggunaan anggaran BUMNag untuk tahun ini..."></textarea>
            </div>
            <div class="flex gap-3 pt-4 border-t border-gray-100"><button type="submit" class="btn-primary">Simpan</button><button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button></div>
        </form>
    </x-admin-modal>

    <div class="card overflow-hidden"><div class="table-container border-0 shadow-none"><table class="data-table"><thead><tr><th>Tahun</th><th>Pendapatan</th><th>Belanja</th><th>Realisasi</th><th>Keterangan</th><th class="text-right">Aksi</th></tr></thead><tbody>
        @forelse($stats as $s)<tr><td class="font-medium">{{ $s->year }}</td><td>Rp {{ number_format($s->total_income,0,',','.') }}</td><td>Rp {{ number_format($s->total_expenditure,0,',','.') }}</td><td>{{ $s->realization_pct }}%</td><td class="text-sm text-gray-500 max-w-[200px] truncate">{{ Str::limit($s->keterangan, 40) ?: '-' }}</td><td><div class="flex justify-end gap-1"><button wire:click="edit({{ $s->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600"><span class="material-symbols-outlined text-lg">edit</span></button><button onclick="confirmAction({{ $s->id }}, 'deleteConfirmed', 'Yakin?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600"><span class="material-symbols-outlined text-lg">delete</span></button></div></td></tr>
        @empty<tr><td colspan="6" class="text-center text-gray-400 py-8">Belum ada data.</td></tr>@endforelse
    </tbody></table></div></div>
</div>
