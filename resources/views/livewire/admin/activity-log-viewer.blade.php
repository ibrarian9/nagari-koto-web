<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Log Aktivitas</h2>
            <p class="text-sm text-gray-500 mt-0.5">Riwayat semua perubahan data di sistem</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card p-4 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="form-label text-xs">Cari</label>
                <input type="text" wire:model.live.debounce.300ms="search" class="form-input w-full text-sm" placeholder="Cari deskripsi atau nama user...">
            </div>
            <div>
                <label class="form-label text-xs">Aksi</label>
                <select wire:model.live="actionFilter" class="form-input w-full text-sm">
                    <option value="">Semua Aksi</option>
                    <option value="created">Created</option>
                    <option value="updated">Updated</option>
                    <option value="deleted">Deleted</option>
                </select>
            </div>
            <div>
                <label class="form-label text-xs">Model</label>
                <select wire:model.live="modelFilter" class="form-input w-full text-sm">
                    <option value="">Semua Model</option>
                    @foreach($models as $m)
                        <option value="{{ $m['value'] }}">{{ $m['label'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="table-container border-0 shadow-none">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="w-44">Waktu</th>
                        <th class="w-32">User</th>
                        <th class="w-20">Aksi</th>
                        <th class="w-28">Model</th>
                        <th>Deskripsi</th>
                        <th class="w-28">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="text-xs text-gray-500 font-mono whitespace-nowrap">{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                            <td>
                                @if($log->user)
                                    <span class="text-sm font-medium text-gray-900">{{ $log->user->name }}</span>
                                @else
                                    <span class="text-xs text-gray-400 italic">System</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $actionStyles = match($log->action) {
                                        'created' => 'bg-green-100 text-green-700',
                                        'updated' => 'bg-blue-100 text-blue-700',
                                        'deleted' => 'bg-red-100 text-red-700',
                                        default   => 'bg-gray-100 text-gray-700',
                                    };
                                    $actionIcons = match($log->action) {
                                        'created' => 'add_circle',
                                        'updated' => 'edit',
                                        'deleted' => 'delete',
                                        default   => 'info',
                                    };
                                @endphp
                                <span class="badge {{ $actionStyles }} text-xs inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">{{ $actionIcons }}</span>
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-xs font-mono text-gray-600 bg-gray-100 px-2 py-0.5 rounded">{{ class_basename($log->model_type) }}</span>
                            </td>
                            <td class="text-sm text-gray-700">{{ Str::limit($log->description, 80) }}</td>
                            <td class="text-xs text-gray-400 font-mono">{{ $log->ip_address ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-400 py-8">Belum ada log aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
