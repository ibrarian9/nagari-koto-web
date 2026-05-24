<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Permohonan Surat</h2><p class="text-sm text-gray-500 mt-0.5">Kelola permohonan surat dari warga</p></div>
    </div>
    <x-page-guide title="Panduan Permohonan Surat" description="Lihat dan kelola semua permohonan surat dari warga. Ubah status permohonan (Pending → Diproses → Siap Diambil / Ditolak) dan tambahkan catatan. Warga dapat memantau status surat mereka secara online. Filter berdasarkan status untuk memudahkan pengelolaan." />

    {{-- Template Formulir Nikah --}}
    <div class="card p-5 mb-6">
        <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2 text-sm">
            <span class="material-symbols-outlined text-lg text-amber-500">description</span>
            Template Formulir Nikah (N1)
        </h3>
        @if($templateExists)
            <div class="flex items-center gap-4 mb-3">
                <div class="flex items-center gap-2 text-sm text-green-700 bg-green-50 px-3 py-1.5 rounded-lg">
                    <span class="material-symbols-outlined text-base">check_circle</span>
                    Template tersedia
                </div>
                <a href="{{ asset('storage/templates/formulir-nikah-n1.pdf') }}" target="_blank" class="text-sm text-desa-600 hover:text-desa-800 underline">Lihat file</a>
                <button wire:click="deleteTemplate" wire:confirm="Hapus template formulir nikah?" class="text-sm text-red-500 hover:text-red-700 underline">Hapus</button>
            </div>
        @else
            <p class="text-sm text-gray-400 mb-3">Belum ada template. Upload file PDF formulir nikah N1 agar warga dapat mendownloadnya.</p>
        @endif
        <form wire:submit="uploadTemplate" class="flex items-end gap-3">
            <div class="flex-1">
                <input type="file" wire:model="nikahTemplate" accept=".pdf" class="form-input w-full text-sm">
                @error('nikahTemplate')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="btn-primary text-sm whitespace-nowrap" wire:loading.attr="disabled" wire:target="nikahTemplate,uploadTemplate">
                <span wire:loading.remove wire:target="uploadTemplate">{{ $templateExists ? 'Ganti Template' : 'Upload Template' }}</span>
                <span wire:loading wire:target="nikahTemplate,uploadTemplate">Mengunggah...</span>
            </button>
        </form>
    </div>

    {{-- Filter --}}
    <div class="flex gap-4 mb-6"><select wire:model.live="statusFilter" class="form-input w-48"><option value="">Semua Status</option><option value="pending">Pending</option><option value="processing">Diproses</option><option value="ready">Siap</option><option value="rejected">Ditolak</option></select></div>

    {{-- Detail Permohonan --}}
    @if($viewingId)
    @php $r = \App\Models\LetterRequest::with('user')->find($viewingId); @endphp
    @if($r)<div class="card p-6 mb-6"><h3 class="font-semibold mb-4">Detail Permohonan</h3>
        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
            <div><strong>Jenis:</strong> {{ $r->letter_type_label }}</div><div><strong>Nama:</strong> {{ $r->full_name }}</div>
            <div><strong>NIK:</strong> {{ Str::mask($r->nik, '*', 6, 6) }}</div><div><strong>Pemohon:</strong> {{ $r->user?->name }}</div>
            <div class="col-span-2"><strong>Alamat:</strong> {{ $r->address }}</div>
            <div class="col-span-2"><strong>Keperluan:</strong> {{ $r->purpose ?? '-' }}</div>

            {{-- Dokumen yang diupload --}}
            @if($r->ktp_image)
                <div class="col-span-2">
                    <strong>{{ $r->letter_type === 'surat_pengantar_nikah' ? 'KTP Calon Mempelai Pria' : 'Foto KTP' }}:</strong>
                    <a href="{{ Storage::url($r->ktp_image) }}" target="_blank" class="block mt-2 group relative w-fit">
                        <img src="{{ Storage::url($r->ktp_image) }}" alt="KTP" class="max-h-40 rounded-lg border border-gray-200 shadow-sm group-hover:shadow-md transition-shadow" loading="lazy">
                        <div class="absolute inset-0 rounded-lg flex items-center justify-center bg-black/0 group-hover:bg-black/10 transition-all">
                            <span class="material-symbols-outlined text-white text-xl opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-lg">zoom_in</span>
                        </div>
                    </a>
                </div>
            @endif
            @if($r->ktp_image_2)
                <div class="col-span-2">
                    <strong>KTP Calon Mempelai Wanita:</strong>
                    <a href="{{ Storage::url($r->ktp_image_2) }}" target="_blank" class="block mt-2 group relative w-fit">
                        <img src="{{ Storage::url($r->ktp_image_2) }}" alt="KTP Wanita" class="max-h-40 rounded-lg border border-gray-200 shadow-sm group-hover:shadow-md transition-shadow" loading="lazy">
                        <div class="absolute inset-0 rounded-lg flex items-center justify-center bg-black/0 group-hover:bg-black/10 transition-all">
                            <span class="material-symbols-outlined text-white text-xl opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-lg">zoom_in</span>
                        </div>
                    </a>
                </div>
            @endif
            @if($r->nikah_form_image)
                <div class="col-span-2">
                    <strong>Formulir Nikah (N1):</strong>
                    <a href="{{ Storage::url($r->nikah_form_image) }}" target="_blank" class="block mt-2 group relative w-fit">
                        <img src="{{ Storage::url($r->nikah_form_image) }}" alt="Formulir Nikah" class="max-h-40 rounded-lg border border-gray-200 shadow-sm group-hover:shadow-md transition-shadow" loading="lazy">
                        <div class="absolute inset-0 rounded-lg flex items-center justify-center bg-black/0 group-hover:bg-black/10 transition-all">
                            <span class="material-symbols-outlined text-white text-xl opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-lg">zoom_in</span>
                        </div>
                    </a>
                </div>
            @endif
        </div>
        <div class="grid grid-cols-2 gap-4"><div><label class="form-label">Status</label><select wire:model="updateStatus" class="form-input w-full"><option value="pending">Pending</option><option value="processing">Diproses</option><option value="ready">Siap Diambil</option><option value="rejected">Ditolak</option></select></div><div><label class="form-label">Catatan</label><textarea wire:model="updateNotes" class="form-input w-full" rows="2"></textarea></div></div>
        <div class="flex gap-3 mt-4"><button wire:click="updateRequest" class="btn-primary">Update</button><button wire:click="$set('viewingId', null)" class="btn-secondary">Tutup</button></div>
    </div>@endif @endif

    {{-- Tabel --}}
    <div class="table-container"><table class="data-table"><thead><tr><th>Tanggal</th><th>Jenis</th><th>Nama</th><th>Dokumen</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
        @forelse($requests as $r)
        <tr>
            <td class="text-xs">{{ $r->created_at->format('d/m/Y') }}</td>
            <td>{{ $r->letter_type_label }}</td>
            <td>{{ $r->full_name }}</td>
            <td>
                <div class="flex items-center gap-1">
                    @if($r->ktp_image)<span class="material-symbols-outlined text-green-500 text-base" title="KTP">badge</span>@endif
                    @if($r->ktp_image_2)<span class="material-symbols-outlined text-pink-500 text-base" title="KTP Wanita">badge</span>@endif
                    @if($r->nikah_form_image)<span class="material-symbols-outlined text-amber-500 text-base" title="Formulir Nikah">description</span>@endif
                </div>
            </td>
            <td><span class="badge {{ $r->status_color }}">{{ $r->status_label }}</span></td>
            <td><button wire:click="view({{ $r->id }})" class="text-desa-600"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
        </tr>
        @empty<tr><td colspan="6" class="text-center text-gray-400 py-8">Belum ada permohonan.</td></tr>@endforelse
    </tbody></table></div>
    <div class="mt-4">{{ $requests->links() }}</div>
</div>
