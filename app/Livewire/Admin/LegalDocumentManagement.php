<?php

namespace App\Livewire\Admin;

use App\Models\LegalDocument;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class LegalDocumentManagement extends Component
{
    use WithFileUploads, WithPagination;

    public bool $showForm = false;
    public ?int $editingId = null;
    public string $search = '';
    public string $filterCategory = '';

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string')]
    public string $category = '';

    #[Validate('required|integer|min:2000|max:2099')]
    public int $year;

    #[Validate('nullable|string|max:100')]
    public string $number = '';

    #[Validate('nullable|string|max:2000')]
    public string $description = '';

    public $file = null;

    #[Validate('required|boolean')]
    public bool $is_published = true;

    public function mount(): void
    {
        $this->year = (int) date('Y');
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $item = LegalDocument::findOrFail($id);
        $this->editingId = $id;
        $this->title = $item->title;
        $this->category = $item->category;
        $this->year = $item->year;
        $this->number = $item->number ?? '';
        $this->description = $item->description ?? '';
        $this->is_published = $item->is_published;
        $this->showForm = true;
    }

    public function save(): void
    {
        $rules = $this->editingId
            ? ['file' => 'nullable|file|mimes:pdf|max:10240']
            : ['file' => 'required|file|mimes:pdf|max:10240'];
        $this->validate(array_merge($this->rules(), $rules));

        $data = [
            'title' => $this->title,
            'category' => $this->category,
            'year' => $this->year,
            'number' => $this->number ?: null,
            'description' => $this->description,
            'is_published' => $this->is_published,
            'published_at' => $this->is_published ? now() : null,
        ];

        $newFilePath = null;
        $oldFilePath = null;

        if ($this->file) {
            $extension = $this->file->getClientOriginalExtension();
            $fileName = $this->generateStandardFileName($this->title, $extension);
            $newFilePath = $this->file->storeAs('legal-documents', $fileName, 'public');
            $data['file_path'] = $newFilePath;
            $data['file_name'] = $fileName;
            $data['file_size'] = $this->file->getSize();

            // Get old file path for deletion after successful update
            if ($this->editingId) {
                $old = LegalDocument::find($this->editingId);
                $oldFilePath = $old?->file_path;
            }
        }

        try {
            \DB::beginTransaction();

            if ($this->editingId) {
                LegalDocument::findOrFail($this->editingId)->update($data);
            } else {
                LegalDocument::create($data);
            }

            \DB::commit();

            // Delete old file only after successful database update
            if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
                // Invalidate cache for old file path using model-specific prefix
                Cache::forget(LegalDocument::CACHE_KEY_PREFIX . md5($oldFilePath));
            }

            // Invalidate cache for new file path using model-specific prefix
            if ($newFilePath) {
                Cache::forget(LegalDocument::CACHE_KEY_PREFIX . md5($newFilePath));
            }

            $this->showForm = false;
            $this->resetForm();
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: $this->editingId ? 'Data diperbarui.' : 'Data ditambahkan.');
        } catch (\Exception $e) {
            \DB::rollBack();

            // Delete newly uploaded file if database update failed
            if ($newFilePath && Storage::disk('public')->exists($newFilePath)) {
                Storage::disk('public')->delete($newFilePath);
            }

            throw $e;
        }
    }

    public function delete(int $id): void
    {
        $item = LegalDocument::findOrFail($id);
        if ($item->file_path) {
            Storage::disk('public')->delete($item->file_path);
            // Invalidate cache for deleted file path using model-specific prefix
            Cache::forget(LegalDocument::CACHE_KEY_PREFIX . md5($item->file_path));
        }
        $item->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data dihapus.');
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->title = '';
        $this->category = '';
        $this->year = (int) date('Y');
        $this->number = '';
        $this->description = '';
        $this->file = null;
        $this->is_published = true;
    }

    private function generateStandardFileName(string $title, string $extension): string
    {
        $cleanTitle = str()->slug($title);
        return "{$cleanTitle}-" . uniqid() . ".{$extension}";
    }

    private function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:' . implode(',', array_keys(LegalDocument::CATEGORIES)),
            'year' => 'required|integer|min:2000|max:2099',
            'number' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:2000',
            'is_published' => 'required|boolean',
        ];
    }

    #[Layout('layouts.admin', ['title' => 'Produk Hukum'])]
    public function render()
    {
        $items = LegalDocument::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->filterCategory, fn($q) => $q->where('category', $this->filterCategory))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.legal-document-management', [
            'items' => $items,
            'categories' => LegalDocument::CATEGORIES,
        ]);
    }
}
