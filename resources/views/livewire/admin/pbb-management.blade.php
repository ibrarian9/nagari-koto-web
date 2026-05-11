<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">PBB-P2</h2><p class="text-sm text-gray-500 mt-0.5">Pajak Bumi dan Bangunan Perdesaan</p></div>
    </div>
    <x-page-guide title="Panduan PBB-P2" description="Kelola data Pajak Bumi dan Bangunan Perdesaan dan Perkotaan (PBB-P2). Masukkan NOP, nama wajib pajak, tahun pajak, dan jumlah. Gunakan fitur tandai lunas untuk update status pembayaran. Warga dapat mengecek status PBB mereka melalui website publik." />
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="stat-card"><span class="text-2xl font-bold">{{ $summary['total'] }}</span><span class="text-xs text-gray-500">Total</span></div>
        <div class="stat-card"><span class="text-2xl font-bold text-green-600">{{ $summary['paid'] }}</span><span class="text-xs text-gray-500">Lunas</span></div>
        <div class="stat-card"><span class="text-2xl font-bold text-red-600">{{ $summary['unpaid'] }}</span><span class="text-xs text-gray-500">Belum Lunas</span></div>
        <div class="stat-card"><span class="text-lg font-bold">Rp {{ number_format($summary['total_amount'],0,',','.') }}</span><span class="text-xs text-gray-500">Total Pajak</span></div>
    </div>
    <div class="flex flex-wrap gap-4 mb-6">
        <button wire:click="create" class="btn-primary btn-sm"><span class="material-symbols-outlined text-base">add</span> Tambah</button>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari NOP/nama..." class="form-input w-60">
        <select wire:model.live="yearFilter" class="form-input w-32"><option value="">Semua Tahun</option>@for($y=date('Y');$y>=2020;$y--)<option value="{{ $y }}">{{ $y }}</option>@endfor</select>
        <select wire:model.live="statusFilter" class="form-input w-36"><option value="">Semua Status</option><option value="paid">Lunas</option><option value="unpaid">Belum</option></select>
    </div>

    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' PBB'" subtitle="Data Pajak Bumi dan Bangunan" icon="receipt_long" iconBg="bg-orange-100" iconColor="text-orange-600" maxWidth="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>NOP</strong> — Nomor Objek Pajak sesuai SPPT PBB (18 digit)</li>
                    <li><strong>Nama WP</strong> — Nama Wajib Pajak sesuai SPPT</li>
                    <li><strong>Tahun</strong> — Tahun pajak terutang</li>
                    <li><strong>Luas Tanah/Bangunan</strong> — Luas dalam meter persegi sesuai SPPT</li>
                    <li><strong>NJOP</strong> — Nilai Jual Objek Pajak dalam rupiah</li>
                    <li><strong>Jumlah Pajak</strong> — Nominal PBB yang harus dibayar dalam rupiah</li>
                    <li><strong>Status</strong> — Lunas atau Belum Lunas, bisa diubah setelah data disimpan</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div><label class="form-label">NOP *</label><input type="text" wire:model="nop" class="form-input w-full">@error('nop')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Nama WP *</label><input type="text" wire:model="taxpayer_name" class="form-input w-full"></div>
                <div><label class="form-label">Tahun *</label><input type="number" wire:model="tax_year" class="form-input w-full"></div>
                <div><label class="form-label">Luas Tanah (m²)</label><input type="number" step="0.01" wire:model="land_area" class="form-input w-full"></div>
                <div><label class="form-label">Luas Bangunan (m²)</label><input type="number" step="0.01" wire:model="building_area" class="form-input w-full"></div>
                <div><label class="form-label">NJOP (Rp)</label><input type="number" wire:model="njop" class="form-input w-full"></div>
                <div><label class="form-label">Jumlah Pajak (Rp) *</label><input type="number" wire:model="tax_amount" class="form-input w-full"></div>
                <div><label class="form-label">Status</label><select wire:model="status" class="form-input w-full"><option value="unpaid">Belum Lunas</option><option value="paid">Lunas</option></select></div>
            </div>
            <div><label class="form-label">Alamat</label><textarea wire:model="address" class="form-input w-full" rows="2"></textarea></div>
            <div class="flex gap-3 pt-4 border-t border-gray-100"><button type="submit" class="btn-primary">Simpan</button><button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button></div>
        </form>
    </x-admin-modal>

    <div class="card overflow-hidden"><div class="table-container border-0 shadow-none"><table class="data-table"><thead><tr><th>NOP</th><th>Nama WP</th><th>Tahun</th><th>Pajak</th><th>Status</th><th class="text-right">Aksi</th></tr></thead><tbody>
        @forelse($records as $r)<tr><td class="font-mono text-xs">{{ $r->nop }}</td><td>{{ $r->taxpayer_name }}</td><td>{{ $r->tax_year }}</td><td>Rp {{ number_format($r->tax_amount,0,',','.') }}</td><td><span class="badge {{ $r->status === 'paid' ? 'badge-success' : 'badge-danger' }}">{{ $r->status === 'paid' ? 'Lunas' : 'Belum' }}</span></td><td><div class="flex justify-end gap-1">@if($r->status==='unpaid')<button onclick="confirmAction({{ $r->id }}, 'markPaidConfirmed', 'Tandai lunas?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-green-50 hover:text-green-600"><span class="material-symbols-outlined text-lg">check_circle</span></button>@endif<button wire:click="edit({{ $r->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600"><span class="material-symbols-outlined text-lg">edit</span></button><button onclick="confirmAction({{ $r->id }}, 'deleteConfirmed', 'Yakin?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600"><span class="material-symbols-outlined text-lg">delete</span></button></div></td></tr>
        @empty<tr><td colspan="6" class="text-center text-gray-400 py-8">Belum ada data.</td></tr>@endforelse
    </tbody></table></div><div class="p-4 border-t border-gray-100">{{ $records->links() }}</div></div>
</div>
