<?php

namespace App\Livewire\Admin;

use App\Models\PpidBerkala;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PpidBerkalaManagement extends Component
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
        $item = PpidBerkala::findOrFail($id);
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
        $rules = $this->editingId
            ? ['file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:2048']
            : ['file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:2048'];



        $this->validate(array_merge($this->rules(), $rules));

        $data = [
            'title' => $this->title,
            'category' => $this->category,
            'year' => $this->year,
            'description' => $this->description,
            'is_published' => $this->is_published,
            'published_at' => $this->is_published ? now() : null,
        ];

        $newFilePath = null;
        $oldFilePath = null;

        if ($this->file) {
            $extension = $this->file->getClientOriginalExtension();
            $fileName = $this->generateStandardFileName($this->title, $extension);
            $newFilePath = $this->file->storeAs('ppid/berkala', $fileName, 'public');
            $data['file_path'] = $newFilePath;
            $data['file_name'] = $fileName;
            $data['file_size'] = $this->file->getSize();

            // Get old file path for deletion after successful update
            if ($this->editingId) {
                $old = PpidBerkala::find($this->editingId);
                $oldFilePath = $old?->file_path;
            }
        } elseif ($this->editingId) {
            // Preserve existing file data when editing without new file
            $existing = PpidBerkala::findOrFail($this->editingId);
            $data['file_path'] = $existing->file_path;
            $data['file_name'] = $existing->file_name;
            $data['file_size'] = $existing->file_size;
        }

        try {
            \DB::beginTransaction();

            if ($this->editingId) {
                PpidBerkala::findOrFail($this->editingId)->update($data);
            } else {
                PpidBerkala::create($data);
            }

            \DB::commit();

            // Delete old file only after successful database update
            if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
                // Invalidate cache for old file path using model-specific prefix
                Cache::forget(PpidBerkala::CACHE_KEY_PREFIX . md5($oldFilePath));
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

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        $item = PpidBerkala::findOrFail($id);
        if ($item->file_path) {
            Storage::disk('public')->delete($item->file_path);
            // Invalidate cache for deleted file path using model-specific prefix
            Cache::forget(PpidBerkala::CACHE_KEY_PREFIX . md5($item->file_path));
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
            'category' => 'required|string|in:' . implode(',', array_keys(PpidBerkala::CATEGORIES)),
            'year' => 'required|integer|min:2000|max:2099',
            'description' => 'nullable|string|max:2000',
            'is_published' => 'required|boolean',
        ];
    }

    #[Layout('layouts.admin', ['title' => 'PPID — Informasi Berkala'])]
    public function render()
    {
        $items = PpidBerkala::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->filterCategory, fn($q) => $q->where('category', $this->filterCategory))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.ppid-berkala-management', [
            'items' => $items,
            'categories' => PpidBerkala::CATEGORIES,
        ]);
    }
}
