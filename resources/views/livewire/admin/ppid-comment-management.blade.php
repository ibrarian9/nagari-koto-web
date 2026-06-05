<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Komentar PPID</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola komentar dari masyarakat pada halaman PPID</p>
        </div>
        @if($pendingCount > 0)
            <span class="badge bg-amber-100 text-amber-700 text-sm">{{ $pendingCount }} menunggu persetujuan</span>
        @endif
    </div>

    <div class="flex flex-col sm:flex-row gap-3 mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" class="form-input flex-1" placeholder="Cari nama...">
        <select wire:model.live="filterStatus" class="form-input w-full sm:w-48">
            <option value="">Semua</option>
            <option value="pending">Menunggu</option>
            <option value="approved">Disetujui</option>
        </select>
    </div>

    <div class="space-y-3">
        @forelse($items as $item)
            <div class="card p-5 {{ !$item->is_approved ? 'border-l-4 border-l-amber-400' : '' }}">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="font-bold text-gray-900 text-sm">{{ $item->nama }}</span>
                            <span class="badge text-xs {{ $item->is_approved ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $item->is_approved ? 'Disetujui' : 'Menunggu' }}
                            </span>
                            <span class="text-xs text-gray-400">{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-1">{{ $item->komentar }}</p>
                        <div class="flex gap-4 text-xs text-gray-400">
                            @if($item->email)<span>{{ $item->email }}</span>@endif
                            <span>{{ $item->no_hp }}</span>
                        </div>
                    </div>
                    <div class="flex gap-1 flex-shrink-0">
                        @if(!$item->is_approved)
                            <button wire:click="approve({{ $item->id }})" class="btn-icon text-green-500" title="Setujui">
                                <span class="material-symbols-outlined text-sm">check</span>
                            </button>
                        @else
                            <button wire:click="reject({{ $item->id }})" class="btn-icon text-amber-500" title="Tarik Persetujuan">
                                <span class="material-symbols-outlined text-sm">undo</span>
                            </button>
                        @endif
                        <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus komentar ini?" class="btn-icon text-red-500" title="Hapus">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-8 text-center text-gray-400">Belum ada komentar.</div>
        @endforelse
    </div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
