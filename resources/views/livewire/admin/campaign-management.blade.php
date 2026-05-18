<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Donasi & Campaign</h2><p class="text-sm text-gray-500 mt-0.5">Kelola program donasi dan pantau dana masuk</p></div>
        @if($canManage)
            <button wire:click="create" class="btn-primary btn-sm"><span class="material-symbols-outlined text-base">add</span> Buat Campaign</button>
        @endif
    </div>

    <x-page-guide title="Panduan Donasi" description="Kelola program donasi/crowdfunding nagari. Hanya Super Admin dan Operator yang dapat membuat, edit, atau hapus campaign. Semua admin bisa memantau donasi masuk. Pembayaran diproses melalui Midtrans (Sandbox untuk testing)." />

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="stat-card"><span class="text-2xl font-bold text-green-600">Rp {{ number_format($globalSummary['total_collected'], 0, ',', '.') }}</span><span class="text-xs text-gray-500">Total Terkumpul</span></div>
        <div class="stat-card"><span class="text-2xl font-bold text-gray-900">{{ $globalSummary['total_campaigns'] }}</span><span class="text-xs text-gray-500">Total Campaign</span></div>
        <div class="stat-card"><span class="text-2xl font-bold text-desa-600">{{ $globalSummary['active_campaigns'] }}</span><span class="text-xs text-gray-500">Campaign Aktif</span></div>
        <div class="stat-card"><span class="text-2xl font-bold text-amber-600">{{ $globalSummary['total_donors'] }}</span><span class="text-xs text-gray-500">Total Donatur</span></div>
    </div>

    {{-- Campaign Form Modal --}}
    @if($canManage)
    <x-admin-modal :show="$showForm" :title="($editingId ? 'Edit' : 'Buat') . ' Campaign'" subtitle="Program donasi nagari" :icon="$editingId ? 'edit' : 'favorite'" iconBg="bg-rose-100" iconColor="text-rose-600" maxWidth="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form-guide>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Judul</strong> — Nama program donasi yang jelas dan menarik</li>
                    <li><strong>Target Dana</strong> — Minimal Rp 100.000</li>
                    <li><strong>Periode</strong> — Tanggal mulai wajib, tanggal berakhir opsional</li>
                    <li><strong>Deskripsi</strong> — Jelaskan detail program, tujuan, dan manfaat</li>
                </ul>
            </x-form-guide>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2"><label class="form-label">Judul Campaign <span class="text-red-400">*</span></label><input type="text" wire:model="title" class="form-input w-full" placeholder="cth: Renovasi Mushalla Jorong">@error('title')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Target Dana (Rp) <span class="text-red-400">*</span></label><input type="number" wire:model="target_amount" class="form-input w-full" placeholder="1000000" min="100000">@error('target_amount')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Status <span class="text-red-400">*</span></label>
                    <select wire:model="status" class="form-input w-full">
                        <option value="active">Aktif</option>
                        <option value="completed">Selesai</option>
                        <option value="closed">Ditutup</option>
                    </select>
                </div>
                <div><label class="form-label">Tanggal Mulai <span class="text-red-400">*</span></label><input type="date" wire:model="start_date" class="form-input w-full">@error('start_date')<p class="form-error">{{ $message }}</p>@enderror</div>
                <div><label class="form-label">Tanggal Berakhir</label><input type="date" wire:model="end_date" class="form-input w-full">@error('end_date')<p class="form-error">{{ $message }}</p>@enderror</div>
            </div>
            <div><label class="form-label">Deskripsi</label><textarea wire:model="description" class="form-input w-full" rows="4" placeholder="Jelaskan tujuan dan manfaat program donasi..."></textarea></div>
            <x-admin-image-upload wireModel="thumbnail" label="Foto Campaign" :existingUrl="$existingThumbnail ? Storage::url($existingThumbnail) : null" icon="image" />
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save"><span wire:loading.remove wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base">save</span> Simpan</span><span wire:loading wire:target="save" class="flex items-center gap-2"><span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Menyimpan...</span></button>
                <button type="button" wire:click="$set('showForm', false)" class="btn-secondary">Batal</button>
            </div>
        </form>
    </x-admin-modal>
    @endif

    {{-- Donation Detail Modal --}}
    <x-admin-modal :show="$showDonations" title="Daftar Donasi" :subtitle="$viewingCampaign?->title ?? ''" icon="payments" iconBg="bg-green-100" iconColor="text-green-600" maxWidth="max-w-4xl">
        @if($viewingCampaign)
            <div class="flex items-center gap-4 p-3 bg-green-50 rounded-xl mb-4 text-sm">
                <div><span class="font-medium text-gray-700">Target:</span> <span class="font-bold text-gray-900">Rp {{ number_format($viewingCampaign->target_amount, 0, ',', '.') }}</span></div>
                <div><span class="font-medium text-gray-700">Terkumpul:</span> <span class="font-bold text-green-600">Rp {{ number_format($viewingCampaign->collected_amount, 0, ',', '.') }}</span></div>
                <div><span class="font-medium text-gray-700">Progress:</span> <span class="font-bold text-desa-600">{{ $viewingCampaign->progress_percent }}%</span></div>
            </div>
        @endif
        <div class="max-h-96 overflow-y-auto">
            <table class="data-table">
                <thead><tr><th>Donatur</th><th>Nominal</th><th>Metode</th><th>Status</th><th>Waktu</th></tr></thead>
                <tbody>
                    @forelse($viewingDonations ?? [] as $d)
                        <tr class="hover:bg-gray-50/50">
                            <td>
                                <div>
                                    <span class="font-medium">{{ $d->display_name }}</span>
                                    @if($d->is_anonymous)<span class="text-xs text-gray-400 ml-1">(anonim)</span>@endif
                                </div>
                                @if($d->message)<p class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $d->message }}</p>@endif
                            </td>
                            <td class="font-mono text-sm font-medium">Rp {{ number_format($d->amount, 0, ',', '.') }}</td>
                            <td class="text-sm text-gray-500">{{ $d->payment_type ?? '-' }}</td>
                            <td>
                                @php $sc = match($d->payment_status) { 'success' => 'badge-success', 'pending' => 'badge-warning', 'failed' => 'badge-danger', 'expired' => 'badge-secondary', default => 'badge-secondary' }; @endphp
                                <span class="badge {{ $sc }}">{{ ucfirst($d->payment_status) }}</span>
                            </td>
                            <td class="text-sm text-gray-500">{{ $d->paid_at?->format('d/m/Y H:i') ?? $d->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-8 text-gray-400">Belum ada donasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="flex justify-end pt-4 border-t border-gray-100 mt-4">
            <button type="button" wire:click="$set('showDonations', false)" class="btn-secondary">Tutup</button>
        </div>
    </x-admin-modal>

    {{-- Search --}}
    <div class="mb-4">
        <div class="relative sm:max-w-xs">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari campaign..." class="form-input w-full pl-10">
        </div>
    </div>

    {{-- Campaign Table --}}
    <div class="card overflow-hidden">
        <div class="table-container border-0 shadow-none"><table class="data-table"><thead><tr><th>Campaign</th><th>Target</th><th>Terkumpul</th><th>Progress</th><th>Donatur</th><th>Status</th><th class="text-right">Aksi</th></tr></thead><tbody>
            @forelse($campaigns as $c)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-rose-50 overflow-hidden">
                                @if($c->thumbnail)<img src="{{ Storage::url($c->thumbnail) }}" class="h-full w-full object-cover" loading="lazy">@else<div class="h-full w-full flex items-center justify-center"><span class="material-symbols-outlined text-rose-300">favorite</span></div>@endif
                            </div>
                            <div class="min-w-0"><p class="font-medium truncate">{{ $c->title }}</p><p class="text-xs text-gray-400">{{ $c->start_date->format('d M Y') }}{{ $c->end_date ? ' — '.$c->end_date->format('d M Y') : '' }}</p></div>
                        </div>
                    </td>
                    <td class="font-mono text-sm">Rp {{ number_format($c->target_amount, 0, ',', '.') }}</td>
                    <td class="font-mono text-sm text-green-600 font-medium">Rp {{ number_format($c->collected_amount, 0, ',', '.') }}</td>
                    <td>
                        <div class="w-24">
                            <div class="flex items-center justify-between text-xs mb-1"><span class="font-semibold text-gray-700">{{ $c->progress_percent }}%</span></div>
                            <div class="h-2 bg-gray-100 rounded-full overflow-hidden"><div class="h-full bg-gradient-to-r from-green-400 to-emerald-500 rounded-full transition-all" style="width: {{ min(100, $c->progress_percent) }}%"></div></div>
                        </div>
                    </td>
                    <td class="text-center"><span class="badge badge-success">{{ $c->donor_count ?? 0 }}</span></td>
                    <td>
                        @php $sc = match($c->status) { 'active' => 'badge-success', 'completed' => 'badge-warning', 'closed' => 'badge-danger', default => 'badge-secondary' }; @endphp
                        <span class="badge {{ $sc }}">{{ ucfirst($c->status) }}</span>
                    </td>
                    <td>
                        <div class="flex justify-end gap-1">
                            <button wire:click="viewDonations({{ $c->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-green-50 hover:text-green-600 transition-colors" title="Lihat donasi"><span class="material-symbols-outlined text-lg">payments</span></button>
                            @if($canManage)
                                <button wire:click="edit({{ $c->id }})" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-desa-50 hover:text-desa-600 transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button>
                                <button onclick="confirmAction({{ $c->id }}, 'deleteConfirmed', 'Yakin ingin menghapus campaign ini? Semua data donasi terkait juga akan dihapus.')" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty<tr><td colspan="7" class="text-center py-12"><span class="material-symbols-outlined text-4xl text-gray-200 mb-2">favorite</span><p class="text-gray-400 text-sm">Belum ada campaign.</p></td></tr>@endforelse
        </tbody></table></div>
        <div class="p-4 border-t border-gray-100">{{ $campaigns->links() }}</div>
    </div>
</div>
