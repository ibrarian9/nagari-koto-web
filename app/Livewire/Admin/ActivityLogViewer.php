<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ActivityLogViewer extends Component
{
    use WithPagination;

    public string $activeTab = 'activity'; // 'activity' or 'error'

    // Activity Log filters
    public string $search = '';
    public string $actionFilter = '';
    public string $modelFilter = '';

    // Error Log filters
    public string $errorSearch = '';
    public string $levelFilter = '';

    public function updatingSearch(): void { $this->resetPage('activityPage'); }
    public function updatingActionFilter(): void { $this->resetPage('activityPage'); }
    public function updatingModelFilter(): void { $this->resetPage('activityPage'); }

    public function clearErrorLogs(): void
    {
        $logFile = storage_path('logs/laravel.log');
        if (File::exists($logFile)) {
            File::put($logFile, '');
        }
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Log error Laravel telah dibersihkan.');
    }

    public function downloadErrorLog()
    {
        $logFile = storage_path('logs/laravel.log');
        if (!File::exists($logFile)) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'File laravel.log tidak ditemukan.');
            return null;
        }

        return Response::download($logFile, 'laravel-error-' . date('Y-m-d') . '.log');
    }

    public function clearOldActivityLogs(): void
    {
        ActivityLog::where('created_at', '<', now()->subDays(30))->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Log aktivitas lebih dari 30 hari telah dibersihkan.');
    }

    private function getParsedErrorLogs(): array
    {
        $logFile = storage_path('logs/laravel.log');
        if (!File::exists($logFile)) {
            return [];
        }

        $content = File::get($logFile);
        if (empty(trim($content))) {
            return [];
        }

        // Split log entries by timestamp pattern
        $pattern = '/^\[(\d{4}-\d{2}-\d{2}[T ]\d{2}:\d{2}:\d{2}\.?\d*[\+\-]?\d*:?\d*)\]\s+(\w+)\.(\w+):\s+/m';
        $splits = preg_split($pattern, $content, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        $entries = [];
        $total = count($splits);

        for ($i = 0; $i < $total; $i += 4) {
            if (!isset($splits[$i + 3])) {
                break;
            }
            $timestamp = $splits[$i];
            $env = $splits[$i + 1];
            $level = strtoupper($splits[$i + 2]);
            $body = $splits[$i + 3];

            // Split body into message and stack trace if present
            $bodyLines = explode("\n", trim($body));
            $message = array_shift($bodyLines);
            $trace = implode("\n", $bodyLines);

            // Apply search filter
            if ($this->errorSearch) {
                $search = strtolower($this->errorSearch);
                if (!str_contains(strtolower($message), $search) && !str_contains(strtolower($trace), $search)) {
                    continue;
                }
            }

            // Apply level filter
            if ($this->levelFilter && $level !== strtoupper($this->levelFilter)) {
                continue;
            }

            $entries[] = [
                'id' => md5($timestamp . $message),
                'timestamp' => $timestamp,
                'env' => $env,
                'level' => $level,
                'message' => $message,
                'trace' => trim($trace),
            ];
        }

        return array_reverse($entries); // Show latest first
    }

    #[Layout('layouts.admin', ['title' => 'Log Error & Aktivitas'])]
    public function render()
    {
        // Query activity logs
        $query = ActivityLog::with('user')->orderByDesc('created_at')->orderByDesc('id');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', "%{$this->search}%")
                  ->orWhere('ip_address', 'like', "%{$this->search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$this->search}%"));
            });
        }

        if ($this->actionFilter) {
            $query->where('action', $this->actionFilter);
        }

        if ($this->modelFilter) {
            $query->where('model_type', $this->modelFilter);
        }

        $models = ActivityLog::select('model_type')->distinct()->whereNotNull('model_type')->orderBy('model_type')->pluck('model_type')
            ->map(fn($m) => ['value' => $m, 'label' => class_basename($m)])->values();

        $errorLogs = $this->getParsedErrorLogs();

        return view('livewire.admin.activity-log-viewer', [
            'activityLogs' => $query->paginate(20, ['*'], 'activityPage'),
            'errorLogs' => array_slice($errorLogs, 0, 100), // top 100 entries
            'errorCount' => count($errorLogs),
            'models' => $models,
        ]);
    }
}
