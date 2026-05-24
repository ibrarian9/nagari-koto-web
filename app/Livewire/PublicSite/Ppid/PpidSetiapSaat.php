<?php

namespace App\Livewire\PublicSite\Ppid;

use App\Models\PpidSetiapSaat as PpidSetiapSaatModel;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PpidSetiapSaat extends Component
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
        $item = PpidSetiapSaatModel::published()->findOrFail($id);
        $item->increment('download_count');
        return Storage::disk('public')->download($item->file_path, $item->file_name);
    }

    #[Layout('layouts.app', ['title' => 'Informasi Setiap Saat — PPID'])]
    public function render()
    {
        $items = PpidSetiapSaatModel::published()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->category, fn($q) => $q->byCategory($this->category))
            ->when($this->year, fn($q) => $q->byYear($this->year))
            ->latest('published_at')
            ->paginate(15);

        $years = PpidSetiapSaatModel::published()
            ->selectRaw('DISTINCT year')
            ->orderByDesc('year')
            ->pluck('year');

        return view('livewire.public.ppid.setiap-saat', [
            'items' => $items,
            'categories' => PpidSetiapSaatModel::CATEGORIES,
            'years' => $years,
        ]);
    }
}
