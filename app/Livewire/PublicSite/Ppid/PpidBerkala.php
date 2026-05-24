<?php

namespace App\Livewire\PublicSite\Ppid;

use App\Models\PpidBerkala as PpidBerkalaModel;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PpidBerkala extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $category = '';

    #[Url]
    public string $year = '';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingCategory(): void { $this->resetPage(); }
    public function updatingYear(): void { $this->resetPage(); }

    public function download(int $id)
    {
        $item = PpidBerkalaModel::published()->findOrFail($id);
        $item->increment('download_count');
        return Storage::disk('public')->download($item->file_path, $item->file_name);
    }

    #[Layout('layouts.app', ['title' => 'Informasi Berkala — PPID'])]
    public function render()
    {
        $items = PpidBerkalaModel::published()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->category, fn($q) => $q->byCategory($this->category))
            ->when($this->year, fn($q) => $q->byYear($this->year))
            ->latest('published_at')
            ->paginate(15);

        $years = PpidBerkalaModel::published()
            ->selectRaw('DISTINCT year')
            ->orderByDesc('year')
            ->pluck('year');

        return view('livewire.public.ppid.berkala', [
            'items' => $items,
            'categories' => PpidBerkalaModel::CATEGORIES,
            'years' => $years,
        ]);
    }
}
