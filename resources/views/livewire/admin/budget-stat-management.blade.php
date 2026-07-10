<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Data Anggaran Nagari</h2><p class="text-sm text-gray-500 mt-0.5">APBNag dan transparansi keuangan</p></div>
        <button wire:click="create" class="btn-primary btn-sm"><span class="material-symbols-outlined text-base">add</span> Tambah</button>
    </div>
    <x-page-guide title="Panduan Data Anggaran" description="Kelola data Anggaran Pendapatan dan Belanja Desa (APBNag) per tahun. Masukkan total pendapatan, belanja, dan persentase realisasi. Data ini ditampilkan di halaman Anggaran pada website publik sebagai bentuk transparansi keuangan nagari." />

    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' Anggaran'" subtitle="Data APBNag tahunan" icon="account_balance" iconBg="bg-emerald-100" iconColor="text-emerald-600" maxWidth="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Tahun</strong> — Tahun anggaran APBNag</li>
                    <li><strong>Total Pendapatan</strong> — Total seluruh pendapatan nagari dalam rupiah (tanpa titik/koma)</li>
                    <li><strong>Total Belanja</strong> — Total seluruh belanja nagari dalam rupiah</li>
                    <li><strong>Realisasi (%)</strong> — Persentase realisasi anggaran (cth: 95.50)</li>
                    <li><strong>Rincian APBNag</strong> — Tambahkan pos anggaran satu per satu (nama pos + nominal)</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div><label class="form-label">Tahun *</label><input type="number" wire:model="year" class="form-input w-full"></div>
                <div><label class="form-label">Total Pendapatan *</label><input type="number" wire:model="total_income" class="form-input w-full"></div>
                <div><label class="form-label">Total Belanja *</label><input type="number" wire:model="total_expenditure" class="form-input w-full"></div>
                <div><label class="form-label">Realisasi (%)</label><input type="number" step="0.01" wire:model="realization_pct" class="form-input w-full"></div>
            </div>
            <div><h4 class="font-medium text-gray-700 mb-2">Rincian APBNag</h4>
                @foreach($apbnag_rows as $i => $row)<div class="flex gap-3 mb-2"><input type="text" wire:model="apbnag_rows.{{ $i }}.label" class="form-input flex-1" placeholder="Nama pos"><input type="number" wire:model="apbnag_rows.{{ $i }}.value" class="form-input w-40" placeholder="Jumlah"><button type="button" wire:click="removeRow({{ $i }})" class="text-red-500"><span class="material-symbols-outlined">remove_circle</span></button></div>@endforeach
                <button type="button" wire:click="addRow" class="text-sm text-desa-600 flex items-center gap-1"><span class="material-symbols-outlined text-base">add</span> Tambah Pos</button>
            </div>
            <div class="flex gap-3 pt-4 border-t border-gray-100"><button type="submit" class="btn-primary">Simpan</button><button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button></div>
        </form>
    </x-admin-modal>

    <div class="card overflow-hidden"><div class="table-container border-0 shadow-none"><table class="data-table"><thead><tr><th>Tahun</th><th>Pendapatan</th><th>Belanja</th><th>Realisasi</th><th class="text-right">Aksi</th></tr></thead><tbody>
        @forelse($stats as $s)<tr><td class="font-medium">{{ $s->year }}</td><td>Rp {{ number_format($s->total_income,0,',','.') }}</td><td>Rp {{ number_format($s->total_expenditure,0,',','.') }}</td><td>{{ $s->realization_pct }}%</td><td><div class="flex justify-end gap-1"><button wire:click="edit({{ $s->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600"><span class="material-symbols-outlined text-lg">edit</span></button><button onclick="confirmAction({{ $s->id }}, 'deleteConfirmed', 'Yakin?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600"><span class="material-symbols-outlined text-lg">delete</span></button></div></td></tr>
        @empty<tr><td colspan="5" class="text-center text-gray-400 py-8">Belum ada data.</td></tr>@endforelse
    </tbody></table></div></div>
</div>
