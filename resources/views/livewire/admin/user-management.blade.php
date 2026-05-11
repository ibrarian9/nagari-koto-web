<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Manajemen User</h2><p class="text-sm text-gray-500 mt-0.5">Kelola akun pengguna sistem</p></div>
        <button wire:click="create" class="btn-primary btn-sm"><span class="material-symbols-outlined text-base">add</span> Tambah User</button>
    </div>

    <x-page-guide title="Panduan Manajemen User" description="Kelola semua akun pengguna sistem. Super Admin memiliki akses penuh, Admin mengelola konten, Operator menginput data, dan Warga hanya bisa mengajukan surat. Warga yang baru mendaftar perlu diaktifkan di sini sebelum bisa login. Klik badge status untuk mengubah status aktivasi (dengan konfirmasi)." />

    {{-- Pending Warga Alert --}}
    @php $pendingCount = \App\Models\User::where('role', 'warga')->where('is_active', false)->count(); @endphp
    @if($pendingCount > 0)
        <div class="mb-4 flex items-center gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4">
            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-amber-100">
                <span class="material-symbols-outlined text-amber-600">person_alert</span>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-amber-800">{{ $pendingCount }} akun warga menunggu aktivasi</p>
                <p class="text-xs text-amber-600">Klik tombol status untuk mengaktifkan akun warga yang baru mendaftar.</p>
            </div>
        </div>
    @endif

    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' User'" subtitle="Isi data akun pengguna" :icon="$editingId ? 'edit' : 'person_add'" iconBg="bg-blue-100" iconColor="text-blue-600">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Nama</strong> — Nama lengkap pengguna</li>
                    <li><strong>Email</strong> — Alamat email aktif untuk login ke sistem</li>
                    <li><strong>Password</strong> — Minimal 8 karakter, saat edit kosongkan jika tidak ingin mengubah</li>
                    <li><strong>Role</strong> — <em>Super Admin</em> (akses penuh), <em>Admin</em> (kelola konten), <em>Operator</em> (input data), <em>Warga</em> (akses terbatas)</li>
                    <li><strong>Foto</strong> — Foto profil pengguna, maks 2MB</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="form-label">Nama <span class="text-red-400">*</span></label><input type="text" wire:model="name" class="form-input w-full" placeholder="Nama lengkap">@error('name')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Email <span class="text-red-400">*</span></label><input type="email" wire:model="email" class="form-input w-full" placeholder="email@domain.com">@error('email')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Password {{ $editingId ? '(kosongkan jika tidak diubah)' : '*' }}</label><input type="password" wire:model="password" class="form-input w-full" placeholder="Minimal 8 karakter">@error('password')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Role <span class="text-red-400">*</span></label><select wire:model="role" class="form-input w-full"><option value="warga">Warga</option><option value="operator">Operator</option><option value="admin">Admin</option><option value="super_admin">Super Admin</option></select></div>
            </div>
            <x-admin-image-upload wireModel="photo" label="Foto Profil" :existingUrl="$existingPhoto ? Storage::url($existingPhoto) : null" icon="person" />
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save"><span wire:loading.remove wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base">save</span> Simpan</span><span wire:loading wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...</span></button>
                <button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button>
            </div>
        </form>
    </x-admin-modal>

    <div class="flex flex-wrap gap-3 mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau email..." class="form-input w-full sm:w-80">
        <select wire:model.live="roleFilter" class="form-input w-40"><option value="">Semua Role</option><option value="super_admin">Super Admin</option><option value="admin">Admin</option><option value="operator">Operator</option><option value="warga">Warga</option></select>
    </div>
    <div class="card overflow-hidden"><div class="table-container border-0 shadow-none"><table class="data-table"><thead><tr><th>Nama</th><th>Email</th><th>NIK</th><th>Role</th><th>Status</th><th class="text-right">Aksi</th></tr></thead><tbody>
        @forelse($users as $u)<tr class="hover:bg-gray-50/50 transition-colors {{ !$u->is_active && $u->isWarga() ? 'bg-amber-50/50' : '' }}"><td class="font-medium">{{ $u->name }}</td><td class="text-gray-500">{{ $u->email }}</td><td class="text-gray-500 text-xs font-mono">{{ $u->nik ?? '-' }}</td><td><span class="badge badge-info">{{ $u->role }}</span></td><td>@if($u->isSuperAdmin())<span class="badge badge-success">Aktif</span>@else<button onclick="confirmAction({{ $u->id }}, 'toggleActiveConfirmed', '{{ $u->is_active ? 'Nonaktifkan akun '.$u->name.'?' : 'Aktifkan akun '.$u->name.'?' }}')" @class(['badge cursor-pointer transition-colors', 'badge-success' => $u->is_active, 'badge-warning' => !$u->is_active && $u->isWarga(), 'badge-danger' => !$u->is_active && !$u->isWarga()])>{{ $u->is_active ? 'Aktif' : ($u->isWarga() ? 'Menunggu Aktivasi' : 'Nonaktif') }}</button>@endif</td><td><div class="flex justify-end gap-1"><button wire:click="edit({{ $u->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600 transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button>@unless($u->isSuperAdmin())<button onclick="confirmAction({{ $u->id }}, 'deleteConfirmed', 'Yakin ingin menghapus data ini?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button>@endunless</div></td></tr>
        @empty<tr><td colspan="6" class="text-center py-12"><span class="material-symbols-outlined text-4xl text-gray-200 mb-2">group</span><p class="text-gray-400 text-sm">Belum ada user.</p></td></tr>@endforelse
    </tbody></table></div><div class="p-4 border-t border-gray-100">{{ $users->links() }}</div></div>
</div>
