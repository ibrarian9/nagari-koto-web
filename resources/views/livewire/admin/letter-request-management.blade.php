<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Permohonan Surat</h2><p class="text-sm text-gray-500 mt-0.5">Kelola permohonan surat dari warga</p></div>
    </div>
    <x-page-guide title="Panduan Permohonan Surat" description="Lihat dan kelola semua permohonan surat dari warga. Ubah status permohonan (Pending → Diproses → Siap Diambil / Ditolak) dan tambahkan catatan. Warga dapat memantau status surat mereka secara online. Filter berdasarkan status untuk memudahkan pengelolaan." />
    <div class="flex gap-4 mb-6"><select wire:model.live="statusFilter" class="form-input w-48"><option value="">Semua Status</option><option value="pending">Pending</option><option value="processing">Diproses</option><option value="ready">Siap</option><option value="rejected">Ditolak</option></select></div>
    @if($viewingId)
    @php $r = \App\Models\LetterRequest::with('user')->find($viewingId); @endphp
    @if($r)<div class="card p-6 mb-6"><h3 class="font-semibold mb-4">Detail Permohonan</h3>
        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
            <div><strong>Jenis:</strong> {{ $r->letter_type_label }}</div><div><strong>Nama:</strong> {{ $r->full_name }}</div>
            <div><strong>NIK:</strong> {{ Str::mask($r->nik, '*', 6, 6) }}</div><div><strong>Pemohon:</strong> {{ $r->user?->name }}</div>
            <div class="col-span-2"><strong>Alamat:</strong> {{ $r->address }}</div>
            <div class="col-span-2"><strong>Keperluan:</strong> {{ $r->purpose ?? '-' }}</div>
        </div>
        <div class="grid grid-cols-2 gap-4"><div><label class="form-label">Status</label><select wire:model="updateStatus" class="form-input w-full"><option value="pending">Pending</option><option value="processing">Diproses</option><option value="ready">Siap Diambil</option><option value="rejected">Ditolak</option></select></div><div><label class="form-label">Catatan</label><textarea wire:model="updateNotes" class="form-input w-full" rows="2"></textarea></div></div>
        <div class="flex gap-3 mt-4"><button wire:click="updateRequest" class="btn-primary">Update</button><button wire:click="$set('viewingId', null)" class="btn-secondary">Tutup</button></div>
    </div>@endif @endif
    <div class="table-container"><table class="data-table"><thead><tr><th>Tanggal</th><th>Jenis</th><th>Nama</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
        @forelse($requests as $r)<tr><td class="text-xs">{{ $r->created_at->format('d/m/Y') }}</td><td>{{ $r->letter_type_label }}</td><td>{{ $r->full_name }}</td><td><span class="badge {{ $r->status_color }}">{{ $r->status_label }}</span></td><td><button wire:click="view({{ $r->id }})" class="text-desa-600"><span class="material-symbols-outlined text-lg">visibility</span></button></td></tr>
        @empty<tr><td colspan="5" class="text-center text-gray-400 py-8">Belum ada permohonan.</td></tr>@endforelse
    </tbody></table></div>
    <div class="mt-4">{{ $requests->links() }}</div>
</div>
