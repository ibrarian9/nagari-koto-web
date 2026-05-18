<?php

namespace App\Livewire\Admin;

use App\Models\ForestryRecord;
use App\Services\ImageOptimizer;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ForestryManagement extends Component
{
    use WithFileUploads, WithPagination;

    public bool $showForm = false;
    public ?int $editingId = null;
    public string $search = '';
    public string $categoryFilter = '';
    public string $yearFilter = '';

    #[Validate('required|string|max:255')]
    public string $title = '';
    #[Validate('required|in:hutan_lindung,hutan_produksi,hutan_rakyat,lahan_kritis,rehabilitasi')]
    public string $category = '';
    #[Validate('required|numeric|min:0')]
    public $area_ha = '';
    #[Validate('nullable|string|max:255')]
    public ?string $location = '';
    #[Validate('nullable|string')]
    public ?string $description = '';
    #[Validate('required|in:aktif,dalam_pemulihan,kritis')]
    public string $status = 'aktif';
    #[Validate('nullable|integer|min:2000|max:2100')]
    public $year = null;
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $thumbnail = null;
    public ?string $existingThumbnail = null;

    public function create(): void
    {
        $this->resetForm();
        $this->year = date('Y');
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $record = ForestryRecord::findOrFail($id);
        $this->editingId = $record->id;
        $this->fill($record->only(['title', 'category', 'area_ha', 'location', 'description', 'status', 'year']));
        $this->existingThumbnail = $record->thumbnail;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title'       => $this->title,
            'category'    => $this->category,
            'area_ha'     => $this->area_ha,
            'location'    => $this->location,
            'description' => $this->description,
            'status'      => $this->status,
            'year'        => $this->year,
        ];

        if ($this->thumbnail) {
            $data['thumbnail'] = (new ImageOptimizer())->optimize($this->thumbnail, 'forestry', 'thumbnail');
        }

        if ($this->editingId) {
            ForestryRecord::findOrFail($this->editingId)->update($data);
        } else {
            ForestryRecord::create($data);
        }

        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data kehutanan berhasil disimpan.');
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        ForestryRecord::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil dihapus.');
    }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'title', 'category', 'area_ha', 'location', 'description', 'status', 'year', 'thumbnail', 'existingThumbnail']);
        $this->status = 'aktif';
    }

    public function render()
    {
        $records = ForestryRecord::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%")->orWhere('location', 'like', "%{$this->search}%"))
            ->when($this->categoryFilter, fn($q) => $q->byCategory($this->categoryFilter))
            ->when($this->yearFilter, fn($q) => $q->byYear($this->yearFilter))
            ->latest()
            ->paginate(15);

        $summary = [
            'total'      => ForestryRecord::count(),
            'total_area' => ForestryRecord::sum('area_ha'),
            'aktif'      => ForestryRecord::where('status', 'aktif')->count(),
            'kritis'     => ForestryRecord::where('status', 'kritis')->count(),
        ];

        return view('livewire.admin.forestry-management', compact('records', 'summary'))
            ->layout('layouts.admin', ['title' => 'Data Kehutanan']);
    }
}
