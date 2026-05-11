<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Data IDM</h2><p class="text-sm text-gray-500 mt-0.5">Indeks Desa Membangun tahunan</p></div>
        <button wire:click="create" class="btn-primary btn-sm"><span class="material-symbols-outlined text-base">add</span> Tambah</button>
    </div>
    <x-page-guide title="Panduan Data IDM" description="Kelola data Indeks Desa Membangun (IDM) per tahun. Masukkan skor IDM, IKS (Sosial), IKE (Ekonomi), dan IKL (Lingkungan). Status desa (Mandiri/Maju/Berkembang/Tertinggal) ditentukan otomatis berdasarkan skor. Data ditampilkan di halaman IDM pada website publik." />

    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Tambah') . ' Data IDM'" subtitle="Indeks Desa Membangun" icon="trending_up" iconBg="bg-indigo-100" iconColor="text-indigo-600" maxWidth="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Tahun</strong> — Tahun data IDM (cth: 2024, 2025)</li>
                    <li><strong>Skor IDM</strong> — Skor total IDM dari Kemendes (format desimal, cth: 0.725)</li>
                    <li><strong>Status</strong> — Kategori desa berdasarkan skor: Sangat Tertinggal, Tertinggal, Berkembang, Maju, Mandiri</li>
                    <li><strong>Skor Dimensi</strong> — Skor per dimensi (Sosial, Ekonomi, Lingkungan) dari laporan IDM</li>
                    <li><strong>Catatan</strong> — Keterangan tambahan tentang pencapaian atau target yang perlu diperbaiki</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div><label class="form-label">Tahun *</label><input type="number" wire:model="year" class="form-input w-full">@error('year')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Skor IDM *</label><input type="number" step="0.001" wire:model="score" class="form-input w-full">@error('score')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Status *</label><select wire:model="status" class="form-input w-full"><option value="sangat_tertinggal">Sangat Tertinggal</option><option value="tertinggal">Tertinggal</option><option value="berkembang">Berkembang</option><option value="maju">Maju</option><option value="mandiri">Mandiri</option></select></div>
                <div><label class="form-label">Skor Sosial</label><input type="number" step="0.001" wire:model="social_score" class="form-input w-full"></div>
                <div><label class="form-label">Skor Ekonomi</label><input type="number" step="0.001" wire:model="economic_score" class="form-input w-full"></div>
                <div><label class="form-label">Skor Lingkungan</label><input type="number" step="0.001" wire:model="environment_score" class="form-input w-full"></div>
            </div>
            <div><label class="form-label">Catatan</label><textarea wire:model="notes" class="form-input w-full" rows="2"></textarea></div>
            <div class="flex gap-3 pt-4 border-t border-gray-100"><button type="submit" class="btn-primary">Simpan</button><button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button></div>
        </form>
    </x-admin-modal>

    <div class="card overflow-hidden"><div class="table-container border-0 shadow-none"><table class="data-table"><thead><tr><th>Tahun</th><th>Skor</th><th>Status</th><th>Sosial</th><th>Ekonomi</th><th>Lingkungan</th><th class="text-right">Aksi</th></tr></thead><tbody>
        @forelse($stats as $s)<tr><td class="font-medium">{{ $s->year }}</td><td>{{ number_format($s->score, 3) }}</td><td><span class="badge {{ $s->status_color }}">{{ $s->status_label }}</span></td><td>{{ number_format($s->social_score, 3) }}</td><td>{{ number_format($s->economic_score, 3) }}</td><td>{{ number_format($s->environment_score, 3) }}</td><td><div class="flex justify-end gap-1"><button wire:click="edit({{ $s->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600"><span class="material-symbols-outlined text-lg">edit</span></button><button onclick="confirmAction({{ $s->id }}, 'deleteConfirmed', 'Yakin?')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600"><span class="material-symbols-outlined text-lg">delete</span></button></div></td></tr>
        @empty<tr><td colspan="7" class="text-center text-gray-400 py-8">Belum ada data.</td></tr>@endforelse
    </tbody></table></div></div>
</div>
