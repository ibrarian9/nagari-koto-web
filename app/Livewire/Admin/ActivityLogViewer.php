<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class ActivityLogViewer extends Component
{
    use WithPagination;

    public string $search = '';
    public string $actionFilter = '';
    public string $modelFilter = '';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingActionFilter(): void { $this->resetPage(); }
    public function updatingModelFilter(): void { $this->resetPage(); }

    public function render()
    {
        $query = ActivityLog::with('user')->latest();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', "%{$this->search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$this->search}%"));
            });
        }

        if ($this->actionFilter) {
            $query->where('action', $this->actionFilter);
        }

        if ($this->modelFilter) {
            $query->where('model_type', $this->modelFilter);
        }

        $models = ActivityLog::select('model_type')->distinct()->orderBy('model_type')->pluck('model_type')
            ->map(fn($m) => ['value' => $m, 'label' => class_basename($m)])->values();

        return view('livewire.admin.activity-log-viewer', [
            'logs' => $query->paginate(25),
            'models' => $models,
        ])->layout('layouts.admin', ['title' => 'Log Aktivitas']);
    }
}
