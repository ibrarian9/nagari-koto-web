<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Pengajuan Keberatan PPID</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola pengajuan keberatan informasi publik dari masyarakat</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" class="form-input flex-1" placeholder="Cari nama atau kode registrasi...">
        <select wire:model.live="filterStatus" class="form-input w-full sm:w-48">
            <option value="">Semua Status</option>
            @foreach(\App\Models\PpidKeberatan::STATUS as $k => $l)
                <option value="{{ $k }}">{{ $l }}</option>
            @endforeach
        </select>
    </div>

    {{-- Detail Modal --}}
    @if($detailId)
        @php $detail = \App\Models\PpidKeberatan::find($detailId); @endphp
        @if($detail)
            <div class="card p-6 mb-6 border-2 border-desa-200 bg-desa-50/30">
                <h3 class="font-bold text-gray-900 mb-4">Detail Keberatan — {{ $detail->kode_registrasi }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
                    <div><span class="text-gray-400">Nama:</span> <span class="font-medium">{{ $detail->nama }}</span></div>
                    <div><span class="text-gray-400">No HP:</span> <span class="font-medium">{{ $detail->no_hp }}</span></div>
                    <div><span class="text-gray-400">Email:</span> <span class="font-medium">{{ $detail->email ?? '-' }}</span></div>
                    <div><span class="text-gray-400">Pekerjaan:</span> <span class="font-medium">{{ $detail->pekerjaan ?? '-' }}</span></div>
                    <div class="md:col-span-2"><span class="text-gray-400">Alamat:</span> <span class="font-medium">{{ $detail->alamat }}</span></div>
                    <div class="md:col-span-2"><span class="text-gray-400">No Reg. Permohonan:</span> <span class="font-medium">{{ $detail->no_registrasi_permohonan ?? '-' }}</span></div>
                    <div class="md:col-span-2"><span class="text-gray-400">Info Dimohon:</span> <span class="font-medium">{{ $detail->informasi_dimohon ?? '-' }}</span></div>
                    <div class="md:col-span-2"><span class="text-gray-400">Alasan:</span> <span class="font-medium">{{ $detail->alasan_label }}</span></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="form-label">Status</label>
                        <select wire:model="newStatus" class="form-input w-full">
                            @foreach(\App\Models\PpidKeberatan::STATUS as $k => $l)
                                <option value="{{ $k }}">{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Catatan Admin</label>
                        <textarea wire:model="catatan" class="form-input w-full" rows="2"></textarea>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button wire:click="updateStatus" class="btn-primary">Simpan</button>
                    <button wire:click="$set('detailId', null)" class="btn-secondary">Tutup</button>
                </div>
            </div>
        @endif
    @endif

    {{-- Table --}}
    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Kode</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Alasan</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-mono text-xs text-desa-600">{{ $item->kode_registrasi }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $item->nama }}</td>
                        <td class="px-4 py-3 text-gray-500 text-xs max-w-xs truncate">{{ $item->alasan_label }}</td>
                        <td class="px-4 py-3"><span class="badge text-xs {{ $item->status_color }}">{{ $item->status_label }}</span></td>
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-1">
                                <button wire:click="showDetail({{ $item->id }})" class="btn-icon" title="Detail"><span class="material-symbols-outlined text-sm">visibility</span></button>
                                <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus data keberatan ini?" class="btn-icon text-red-500" title="Hapus"><span class="material-symbols-outlined text-sm">delete</span></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada pengajuan keberatan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
