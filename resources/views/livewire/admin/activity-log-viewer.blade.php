<div>
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-600">receipt_long</span>
                Log Error & Aktivitas Sistem
            </h1>
            <p class="text-sm text-gray-500 mt-1">Pantau audit trail aktivitas pengguna serta catatan error/warning sistem Laravel secara real-time</p>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="flex items-center gap-2 border-b border-gray-200 mb-6">
        <button wire:click="$set('activeTab', 'activity')"
            class="flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 transition-colors relative {{ $activeTab === 'activity' ? 'border-desa-600 text-desa-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            <span class="material-symbols-outlined text-base">history</span>
            Log Aktivitas User
            <span class="px-2 py-0.5 text-xs rounded-full bg-desa-100 text-desa-700 font-bold">{{ $activityLogs->total() }}</span>
        </button>

        <button wire:click="$set('activeTab', 'error')"
            class="flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 transition-colors relative {{ $activeTab === 'error' ? 'border-red-600 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            <span class="material-symbols-outlined text-base">bug_report</span>
            Log Error Laravel
            @if($errorCount > 0)
                <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700 font-bold">{{ $errorCount }}</span>
            @endif
        </button>
    </div>

    {{-- ─── TAB 1: LOG AKTIVITAS USER ────────────────────────────────── --}}
    @if($activeTab === 'activity')
        {{-- Filters & Action --}}
        <div class="card p-4 mb-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 flex-1">
                    <div>
                        <label class="form-label text-xs">Cari Log</label>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-input w-full text-sm" placeholder="Cari deskripsi, user, IP...">
                    </div>
                    <div>
                        <label class="form-label text-xs">Aksi</label>
                        <select wire:model.live="actionFilter" class="form-input w-full text-sm">
                            <option value="">Semua Aksi</option>
                            <option value="created">Created (Tambah)</option>
                            <option value="updated">Updated (Ubah)</option>
                            <option value="deleted">Deleted (Hapus)</option>
                            <option value="logged_in">Logged In (Masuk)</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label text-xs">Model / Entitas</label>
                        <select wire:model.live="modelFilter" class="form-input w-full text-sm">
                            <option value="">Semua Entitas</option>
                            @foreach($models as $m)
                                <option value="{{ $m['value'] }}">{{ $m['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button onclick="confirmAction(null, 'clearOldActivityLogsConfirmed', 'Hapus semua log aktivitas yang berusia lebih dari 30 hari?')"
                    wire:click="clearOldActivityLogs"
                    class="btn-secondary btn-sm text-red-600 hover:bg-red-50 hover:text-red-700 flex items-center gap-1.5 self-start md:self-auto">
                    <span class="material-symbols-outlined text-base">auto_delete</span> Bersihkan Log >30 Hari
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="card overflow-hidden">
            <div class="table-container border-0 shadow-none">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="w-44">Waktu</th>
                            <th class="w-44">Pengguna</th>
                            <th class="w-28">Aksi</th>
                            <th class="w-36">Model / Entitas</th>
                            <th>Deskripsi Aktivitas</th>
                            <th class="w-32">IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activityLogs as $log)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="text-xs text-gray-500 font-mono whitespace-nowrap">
                                    {{ $log->created_at->format('d M Y, H:i:s') }}
                                </td>
                                <td>
                                    @if($log->user)
                                        <div class="flex items-center gap-2">
                                            <div class="h-6 w-6 rounded-full bg-desa-100 text-desa-700 font-bold text-[10px] flex items-center justify-center">
                                                {{ strtoupper(substr($log->user->name, 0, 1)) }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-900 truncate max-w-[130px]">{{ $log->user->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic flex items-center gap-1">
                                            <span class="material-symbols-outlined text-xs">memory</span> System
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $actionStyles = match($log->action) {
                                            'created' => 'bg-green-50 text-green-700 border-green-200',
                                            'updated' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'deleted' => 'bg-red-50 text-red-700 border-red-200',
                                            'logged_in' => 'bg-purple-50 text-purple-700 border-purple-200',
                                            default   => 'bg-gray-50 text-gray-700 border-gray-200',
                                        };
                                        $actionIcons = match($log->action) {
                                            'created' => 'add_circle',
                                            'updated' => 'edit',
                                            'deleted' => 'delete',
                                            'logged_in' => 'login',
                                            default   => 'info',
                                        };
                                    @endphp
                                    <span class="badge {{ $actionStyles }} text-xs inline-flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs">{{ $actionIcons }}</span>
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td>
                                    @if($log->model_type)
                                        <span class="text-xs font-mono text-gray-700 bg-gray-100 px-2 py-0.5 rounded border border-gray-200">
                                            {{ class_basename($log->model_type) }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="text-sm text-gray-700">
                                    {{ $log->description }}
                                </td>
                                <td class="text-xs text-gray-500 font-mono">
                                    {{ $log->ip_address ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-400 py-12">
                                    <span class="material-symbols-outlined text-4xl text-gray-200 mb-2">manage_search</span>
                                    <p>Belum ada log aktivitas yang tercatat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($activityLogs->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $activityLogs->links() }}
                </div>
            @endif
        </div>
    @endif

    {{-- ─── TAB 2: LOG ERROR LARAVEL ─────────────────────────────────── --}}
    @if($activeTab === 'error')
        {{-- Controls & Actions --}}
        <div class="card p-4 mb-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl">terminal</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm">System Log Stream (`storage/logs/laravel.log`)</h3>
                        <p class="text-xs text-gray-500">Menampilkan 100 baris log error/warning terbaru dari file server</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button wire:click="downloadErrorLog" class="btn-secondary btn-sm flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base">download</span> Download File Log
                    </button>
                    <button wire:click="clearErrorLogs" onclick="return confirm('Kosongkan seluruh log error Laravel?')" class="btn-secondary btn-sm text-red-600 hover:bg-red-50 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base">delete_sweep</span> Bersihkan Log Error
                    </button>
                </div>
            </div>

            {{-- Filter Bar --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3 border-t border-gray-100">
                <div>
                    <label class="form-label text-xs">Cari Kata Kunci Error</label>
                    <input type="text" wire:model.live.debounce.300ms="errorSearch" class="form-input w-full text-sm" placeholder="Cari pesan error, file, atau exception...">
                </div>
                <div>
                    <label class="form-label text-xs">Tingkat Keparahan (Severity Level)</label>
                    <select wire:model.live="levelFilter" class="form-input w-full text-sm">
                        <option value="">Semua Level</option>
                        <option value="ERROR">ERROR</option>
                        <option value="WARNING">WARNING</option>
                        <option value="CRITICAL">CRITICAL</option>
                        <option value="INFO">INFO</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Error Log List --}}
        <div class="space-y-4">
            @forelse($errorLogs as $log)
                <div x-data="{ showTrace: false }" class="card overflow-hidden border border-gray-200/90 shadow-sm hover:shadow transition-shadow" wire:key="error-log-{{ $log['id'] }}">
                    {{-- Header Row --}}
                    <div class="p-4 bg-white flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                        <div class="space-y-1.5 flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                @php
                                    $levelBadge = match($log['level']) {
                                        'ERROR', 'CRITICAL', 'EMERGENCY' => 'bg-red-100 text-red-700 border-red-200',
                                        'WARNING', 'ALERT' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        default => 'bg-blue-100 text-blue-700 border-blue-200',
                                    };
                                @endphp
                                <span class="badge {{ $levelBadge }} font-mono font-bold text-xs">
                                    {{ $log['level'] }}
                                </span>
                                <span class="text-xs font-mono text-gray-500 bg-gray-100 px-2 py-0.5 rounded">
                                    {{ $log['timestamp'] }}
                                </span>
                                <span class="text-[11px] font-mono text-gray-400">
                                    env: {{ $log['env'] }}
                                </span>
                            </div>

                            <p class="text-sm font-mono text-gray-900 font-semibold break-words leading-relaxed">
                                {{ $log['message'] }}
                            </p>
                        </div>

                        @if(!empty($log['trace']))
                            <button @click="showTrace = !showTrace" type="button" class="btn-secondary btn-sm text-xs self-start shrink-0 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm" x-text="showTrace ? 'unfold_less' : 'unfold_more'">unfold_more</span>
                                <span x-text="showTrace ? 'Sembunyikan Stack Trace' : 'Lihat Stack Trace'">Lihat Stack Trace</span>
                            </button>
                        @endif
                    </div>

                    {{-- Collapsible Stack Trace --}}
                    @if(!empty($log['trace']))
                        <div x-show="showTrace" x-collapse style="display: none;" class="bg-gray-900 p-4 border-t border-gray-800 text-xs font-mono text-gray-300 overflow-x-auto max-h-96">
                            <pre class="whitespace-pre-wrap break-words text-[12px] leading-relaxed">{{ $log['trace'] }}</pre>
                        </div>
                    @endif
                </div>
            @empty
                <div class="card p-12 text-center">
                    <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">check_circle</span>
                    <h3 class="text-base font-bold text-gray-800">Tidak Ada Log Error</h3>
                    <p class="text-sm text-gray-500 mt-1">Sistem berjalan dengan bersih dan tidak ada catatan error yang tersimpan.</p>
                </div>
            @endforelse
        </div>
    @endif
</div>
