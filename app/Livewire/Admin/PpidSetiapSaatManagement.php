<?php

namespace App\Livewire\Admin;

use App\Models\PpidSetiapSaat;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PpidSetiapSaatManagement extends Component
{
    use WithFileUploads, WithPagination;

    public bool $showForm = false;
    public ?int $editingId = null;
    public string $search = '';
    public string $filterCategory = '';

    public string $title = '';
    public string $category = '';
    public int $year;
    public string $description = '';
    public $file = null;
    public bool $is_published = true;

    public function mount(): void { $this->year = (int) date('Y'); }

    public function create(): void { $this->resetForm(); $this->showForm = true; }

    public function edit(int $id): void
    {
        $item = PpidSetiapSaat::findOrFail($id);
        $this->editingId = $id;
        $this->title = $item->title;
        $this->category = $item->category;
        $this->year = $item->year;
        $this->description = $item->description ?? '';
        $this->is_published = $item->is_published;
        $this->showForm = true;
    }

    public function save(): void
    {
        $fileRule = $this->editingId
            ? ['file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240']
            : ['file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240'];

        $this->validate(array_merge([
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:' . implode(',', array_keys(PpidSetiapSaat::CATEGORIES)),
            'year' => 'required|integer|min:2000|max:2099',
            'description' => 'nullable|string|max:2000',
            'is_published' => 'required|boolean',
        ], $fileRule));

        $data = [
            'title' => $this->title,
            'category' => $this->category,
            'year' => $this->year,
            'description' => $this->description,
            'is_published' => $this->is_published,
            'published_at' => $this->is_published ? now() : null,
        ];

        if ($this->file) {
            $fileName = str()->slug($this->title) . '-' . time() . '.' . $this->file->getClientOriginalExtension();
            $path = $this->file->storeAs('ppid/setiap-saat', $fileName, 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $this->file->getClientOriginalName();
            $data['file_size'] = $this->file->getSize();
            if ($this->editingId) {
                $old = PpidSetiapSaat::find($this->editingId);
                if ($old?->file_path) Storage::disk('public')->delete($old->file_path);
            }
        }

        $this->editingId ? PpidSetiapSaat::findOrFail($this->editingId)->update($data) : PpidSetiapSaat::create($data);
        $this->showForm = false;
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data disimpan.');
    }

    public function delete(int $id): void
    {
        $item = PpidSetiapSaat::findOrFail($id);
        if ($item->file_path) Storage::disk('public')->delete($item->file_path);
        $item->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data dihapus.');
    }

    private function resetForm(): void
    {
        $this->editingId = null; $this->title = ''; $this->category = '';
        $this->year = (int) date('Y'); $this->description = '';
        $this->file = null; $this->is_published = true;
    }

    #[Layout('layouts.admin', ['title' => 'PPID — Informasi Setiap Saat'])]
    public function render()
    {
        $items = PpidSetiapSaat::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->filterCategory, fn($q) => $q->where('category', $this->filterCategory))
            ->latest()->paginate(15);

        return view('livewire.admin.ppid-setiap-saat-management', [
            'items' => $items, 'categories' => PpidSetiapSaat::CATEGORIES,
        ]);
    }
}
