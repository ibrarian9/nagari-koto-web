<?php

namespace App\Livewire\PublicSite;

use App\Models\LegalDocument;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class LegalDocuments extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'kategori')]
    public string $filterCategory = '';

    #[Url(as: 'tahun')]
    public ?string $filterYear = null;

    public function download(int $id)
    {
        $item = LegalDocument::published()->findOrFail($id);
        $item->increment('download_count');
        
        // Invalidate cache for this file path
        if ($item->file_path) {
            Cache::forget(LegalDocument::CACHE_KEY_PREFIX . md5($item->file_path));
        }
        
        return Storage::disk('public')->download($item->file_path, $item->file_name);
    }

    public function view(int $id)
    {
        $item = LegalDocument::published()->findOrFail($id);
        if (!$item->file_path) {
            $this->dispatch('swal', icon: 'error', title: 'File tidak tersedia', text: 'Dokumen ini belum memiliki file PDF');
            return;
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($item->file_path)) {
            $this->dispatch('swal', icon: 'error', title: 'File tidak ditemukan', text: 'File PDF tidak ditemukan di storage');
            return;
        }

        $url = Storage::disk('public')->url($item->file_path);
        $this->dispatch('open-pdf-modal', url: $url, title: $item->title);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterCategory(): void
    {
        $this->resetPage();
    }

    public function updatingFilterYear(): void
    {
        $this->resetPage();
    }

    #[Layout('layouts.app', ['title' => 'Produk Hukum'])]
    public function render()
    {
        $query = LegalDocument::published()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->filterCategory, fn($q) => $q->where('category', $this->filterCategory))
            ->when($this->filterYear, fn($q) => $q->where('year', $this->filterYear))
            ->latest('published_at');

        $items = $query->paginate(12);

        $availableYears = LegalDocument::published()
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        return view('livewire.public.legal-documents', [
            'items' => $items,
            'categories' => LegalDocument::CATEGORIES,
            'availableYears' => $availableYears,
        ]);
    }
}
