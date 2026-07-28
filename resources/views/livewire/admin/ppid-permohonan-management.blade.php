<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">PPID — Permohonan Informasi</h2><p class="text-sm text-gray-500 mt-0.5">Kelola permohonan informasi publik dari masyarakat</p></div>
    </div>

    {{-- Overdue Warning --}}
    @if($overdueCount > 0)
        <div class="rounded-xl bg-red-50 border border-red-200 p-4 flex items-center gap-3 mb-6">
            <span class="material-symbols-outlined text-red-500">warning</span>
            <div class="text-sm text-red-800">
                <strong>{{ $overdueCount }} permohonan melebihi batas waktu 10 hari kerja!</strong>
                <span class="text-red-600">Segera proses untuk memenuhi ketentuan UU KIP.</span>
            </div>
        </div>
    @endif

    {{-- Detail --}}
    @if($viewingId)
    @php $r = \App\Models\PpidPermohonan::find($viewingId); @endphp
    @if($r)
    <div class="card p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold">Detail Permohonan</h3>
            @if($r->is_overdue)
                <span class="badge bg-red-100 text-red-700 text-xs animate-pulse">⚠ Overdue</span>
            @endif
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mb-4">
            <div><strong>Nomor:</strong> <span class="font-mono">{{ $r->nomor_permohonan }}</span></div>
            <div><strong>Nama:</strong> {{ $r->nama_pemohon }}</div>
            <div><strong>NIK:</strong> {{ Str::mask($r->nik, '*', 6, 6) }}</div>
            <div><strong>Telepon:</strong> {{ $r->no_telepon }}</div>
            <div><strong>Email:</strong> {{ $r->email ?? '-' }}</div>
            <div><strong>Tanggal:</strong> {{ $r->created_at->isoFormat('D MMM Y, HH:mm') }}</div>
            <div class="col-span-2"><strong>Alamat:</strong> {{ $r->alamat }}</div>
            <div class="col-span-2"><strong>Informasi Diminta:</strong><p class="mt-1 text-gray-600 bg-gray-50 rounded-lg p-3">{{ $r->informasi_diminta }}</p></div>
            <div class="col-span-2"><strong>Tujuan:</strong><p class="mt-1 text-gray-600 bg-gray-50 rounded-lg p-3">{{ $r->tujuan_penggunaan }}</p></div>
            <div><strong>Format:</strong> {{ \App\Models\PpidPermohonan::FORMAT_MAP[$r->format_informasi] ?? $r->format_informasi }}</div>
            <div><strong>Cara Mendapatkan:</strong> {{ \App\Models\PpidPermohonan::CARA_MAP[$r->cara_mendapatkan] ?? $r->cara_mendapatkan }}</div>
            @if($r->lampiran)
                <div class="col-span-2">
                    <strong>Lampiran KTP:</strong>
                    <a href="{{ Storage::url($r->lampiran) }}" target="_blank" class="block mt-2 group relative w-fit">
                        <img src="{{ Storage::url($r->lampiran) }}" alt="KTP" class="max-h-40 rounded-lg border shadow-sm group-hover:shadow-md transition" loading="lazy">
                    </a>
                </div>
            @endif
        </div>
        <div class="border-t border-gray-100 pt-4 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><label class="form-label">Update Status</label><select wire:model="updateStatus" class="form-input w-full"><option value="menunggu">Menunggu</option><option value="diproses">Diproses</option><option value="selesai">Selesai</option><option value="ditolak">Ditolak</option></select></div>
                <div><label class="form-label">Dokumen Balasan <span class="text-xs text-gray-400 font-normal">(PDF/DOC/XLS, maks 2MB)</span></label><input type="file" wire:model="dokumenBalasan" class="form-input w-full text-sm" accept=".pdf,.doc,.docx">@error('dokumenBalasan')<p class="form-error">{{ $message }}</p>@enderror</div>



            </div>
            <div><label class="form-label">Catatan Petugas</label><textarea wire:model="catatan" class="form-input w-full" rows="2" placeholder="Catatan untuk pemohon..."></textarea></div>
            <div class="flex gap-3"><button wire:click="updateRequest" class="btn-primary">Update</button><button wire:click="$set('viewingId', null)" class="btn-secondary">Tutup</button></div>
        </div>
    </div>
    @endif
    @endif

    {{-- Filter --}}
    <div class="flex gap-4 mb-6"><select wire:model.live="statusFilter" class="form-input w-48"><option value="">Semua Status</option><option value="menunggu">Menunggu</option><option value="diproses">Diproses</option><option value="selesai">Selesai</option><option value="ditolak">Ditolak</option></select></div>

    {{-- Table --}}
    <div class="table-container"><table class="data-table"><thead><tr><th>Nomor</th><th>Pemohon</th><th>Tanggal</th><th>Status</th><th class="text-center">Aksi</th></tr></thead><tbody>
        @forelse($requests as $r)
        <tr class="{{ $r->is_overdue ? 'bg-red-50/50' : '' }}">
            <td class="font-mono text-xs">{{ $r->nomor_permohonan }}</td>
            <td class="text-sm">{{ $r->nama_pemohon }}</td>
            <td class="text-xs text-gray-500">{{ $r->created_at->format('d/m/Y') }} @if($r->is_overdue)<span class="text-red-500 font-bold" title="Overdue">⚠</span>@endif</td>
            <td><span class="badge {{ $r->status_color }} text-xs">{{ $r->status_label }}</span></td>
            <td class="text-center"><button wire:click="view({{ $r->id }})" class="text-desa-600"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
        </tr>
        @empty<tr><td colspan="5" class="text-center text-gray-400 py-8">Belum ada permohonan.</td></tr>@endforelse
    </tbody></table></div>
    <div class="mt-4">{{ $requests->links() }}</div>
</div>
