<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Penerima Bansos</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola data penerima bantuan sosial desa</p>
        </div>
        <button wire:click="create" class="btn-primary btn-sm"><span class="material-symbols-outlined text-base">add</span> Tambah</button>
    </div>

    <x-page-guide title="Panduan Halaman Bansos" description="Halaman ini mengelola data penerima bantuan sosial (Bansos). Anda dapat menambah, mengedit, mengubah status aktif/nonaktif, dan menghapus data penerima. Gunakan fitur pencarian untuk menemukan penerima berdasarkan nama atau NIK. Status penerima bisa diubah langsung dari tabel dengan konfirmasi terlebih dahulu." />

    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' Penerima'" subtitle="Data penerima bantuan sosial" icon="volunteer_activism" iconBg="bg-pink-100" iconColor="text-pink-600" maxWidth="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>NIK</strong> — Nomor Induk Kependudukan (16 digit) sesuai KTP penerima</li>
                    <li><strong>Nama Lengkap</strong> — Nama sesuai KTP penerima bantuan</li>
                    <li><strong>Program</strong> — Pilih dari dropdown atau ketik nama program baru</li>
                    <li><strong>Tipe Program</strong> — Klasifikasi program (cth: Reguler, Tambahan)</li>
                    <li><strong>Periode</strong> — Tanggal mulai dan selesai penerimaan bantuan</li>
                    <li><strong>Alamat</strong> — Alamat lengkap termasuk jorong tempat tinggal penerima</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="form-label">NIK <span class="text-red-400">*</span></label><input type="text" wire:model="nik" class="form-input w-full" maxlength="16" placeholder="16 digit NIK">@error('nik')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Nama Lengkap <span class="text-red-400">*</span></label><input type="text" wire:model="full_name" class="form-input w-full" placeholder="Sesuai KTP">@error('full_name')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div class="col-span-1 md:col-span-2">
                    <label class="form-label">Program <span class="text-red-400">*</span></label>
                    <select wire:model="program_name" class="form-input w-full">
                        <option value="">— Pilih Program —</option>
                        @foreach($programNames as $pn)
                            <option value="{{ $pn }}">{{ $pn }}</option>
                        @endforeach
                    </select>
                    @error('program_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div><label class="form-label">Tipe Program</label><input type="text" wire:model="program_type" class="form-input w-full" placeholder="cth: Reguler, Tambahan"></div>
                <div></div>
                <div><label class="form-label">Periode Mulai</label><input type="date" wire:model="start_period" class="form-input w-full"></div>
                <div><label class="form-label">Periode Selesai</label><input type="date" wire:model="end_period" class="form-input w-full"></div>
            </div>
            <div><label class="form-label">Alamat</label><textarea wire:model="address" class="form-input w-full" rows="2" placeholder="Alamat lengkap penerima"></textarea></div>
            <label class="inline-flex items-center gap-2.5 cursor-pointer select-none group"><input type="checkbox" wire:model="is_active" class="form-checkbox"><span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">Aktif</span></label>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save"><span wire:loading.remove wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base">save</span> Simpan</span><span wire:loading wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...</span></button>
                <button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button>
            </div>
        </form>
    </x-admin-modal>

    {{-- Kelola Program Bansos --}}
    <div class="mb-4 card p-4">
        <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-base text-desa-600">category</span> Kelola Program Bansos
        </h3>
        <div class="flex flex-col sm:flex-row sm:items-end gap-3">
            <div class="flex-1">
                <label class="form-label text-xs">Tambah Program Baru</label>
                <input type="text" wire:model="newProgramName" class="form-input w-full text-sm" placeholder="Ketik nama program baru, cth: PKH, BLT, BPNT...">
            </div>
            <button type="button" wire:click="addProgram" class="btn-primary btn-sm flex-shrink-0">
                <span class="material-symbols-outlined text-base">add</span> Tambah Program
            </button>
        </div>
        @if($programs->count())
            <div class="mt-4 space-y-2">
                <span class="text-xs text-gray-400">Program tersedia:</span>
                <div class="flex flex-wrap gap-2">
                    @foreach($programs as $prog)
                        @if($editingProgramId === $prog->id)
                            <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded-lg border border-desa-200 bg-desa-50">
                                <input type="text" wire:model="editingProgramName" class="form-input text-xs py-0.5 px-2 w-32" wire:keydown.enter="updateProgram">
                                <button wire:click="updateProgram" class="text-green-600 hover:text-green-800" title="Simpan">
                                    <span class="material-symbols-outlined text-sm">check</span>
                                </button>
                                <button wire:click="cancelEditProgram" class="text-gray-400 hover:text-gray-600" title="Batal">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                            </div>
                        @else
                            <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-desa-50 text-desa-700 group">
                                <span>{{ $prog->name }}</span>
                                <button wire:click="editProgram({{ $prog->id }})" class="opacity-0 group-hover:opacity-100 text-desa-500 hover:text-desa-700 transition-opacity" title="Edit">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </button>
                                <button onclick="confirmAction({{ $prog->id }}, 'deleteProgramConfirmed', 'Hapus program {{ $prog->name }}?')" class="opacity-0 group-hover:opacity-100 text-red-400 hover:text-red-600 transition-opacity" title="Hapus">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="mb-4"><input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama/NIK..." class="form-input w-full sm:w-80"></div>
    <div class="card overflow-hidden"><div class="table-container border-0 shadow-none"><table class="data-table"><thead><tr><th>NIK</th><th>Nama</th><th>Program</th><th>Periode</th><th>Status</th><th class="text-right">Aksi</th></tr></thead><tbody>
        @forelse($recipients as $r)<tr class="hover:bg-gray-50/50 transition-colors">
            <td class="font-mono text-xs">{{ Str::mask($r->nik, '*', 6, 6) }}</td>
            <td>{{ $r->full_name }}</td><td>{{ $r->program_name }}</td>
            <td class="text-xs">{{ $r->start_period?->format('M Y') ?? '-' }} — {{ $r->end_period?->format('M Y') ?? 'now' }}</td><td>
                <button onclick="confirmAction({{ $r->id }}, 'toggleActiveConfirmed', '{{ $r->is_active ? 'Nonaktifkan penerima ini?' : 'Aktifkan penerima ini?' }}')" class="badge cursor-pointer {{ $r->is_active ? 'badge-success' : 'badge-danger' }}">{{ $r->is_active ? 'Aktif' : 'Nonaktif' }}</button></td><td><div class="flex justify-end gap-1"><button wire:click="edit({{ $r->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600"><span class="material-symbols-outlined text-lg">edit</span></button><button onclick="confirmAction({{ $r->id }}, 'deleteConfirmed', 'Yakin ingin menghapus data ini?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600"><span class="material-symbols-outlined text-lg">delete</span></button></div></td></tr>
        @empty<tr><td colspan="6" class="text-center text-gray-400 py-8">Belum ada data.</td></tr>@endforelse
    </tbody></table></div><div class="p-4 border-t border-gray-100">{{ $recipients->links() }}</div></div>
</div>
