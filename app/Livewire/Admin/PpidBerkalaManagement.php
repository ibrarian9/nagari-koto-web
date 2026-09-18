<?php

namespace App\Livewire\Admin;

use App\Models\Category;
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

    // Modal Kelola Kategori
    public bool $showCategoryModal = false;
    public string $newCategoryName = '';
    public ?int $editingCategoryId = null;
    public string $editingCategoryName = '';

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string|max:100')]
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
        $this->ensureDefaultCategoriesExist();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->ensureDefaultCategoriesExist();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $this->ensureDefaultCategoriesExist();
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

            if ($this->editingId) {
                $old = PpidBerkala::find($this->editingId);
                $oldFilePath = $old?->file_path;
            }
        } elseif ($this->editingId) {
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

            if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
                Cache::forget(PpidBerkala::CACHE_KEY_PREFIX . md5($oldFilePath));
            }

            $this->showForm = false;
            $this->resetForm();
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: $this->editingId ? 'Data diperbarui.' : 'Data ditambahkan.');
        } catch (\Exception $e) {
            \DB::rollBack();

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
            Cache::forget(PpidBerkala::CACHE_KEY_PREFIX . md5($item->file_path));
        }
        $item->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data dihapus.');
    }

    public function openCategoryModal(): void
    {
        $this->ensureDefaultCategoriesExist();
        $this->resetCategoryForm();
        $this->showCategoryModal = true;
    }

    public function addCategory(): void
    {
        $this->validate([
            'newCategoryName' => 'required|string|max:100|unique:categories,name,NULL,id,type,ppid_berkala',
        ], [
            'newCategoryName.required' => 'Nama kategori wajib diisi.',
            'newCategoryName.unique' => 'Nama kategori sudah ada.',
        ]);

        $cat = Category::create([
            'name' => trim($this->newCategoryName),
            'slug' => Category::generateUniqueSlug($this->newCategoryName, 'ppid_berkala'),
            'type' => 'ppid_berkala',
        ]);

        $this->category = $cat->slug;
        $this->newCategoryName = '';
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Kategori baru berhasil ditambahkan.');
    }

    public function editCategory(int $id): void
    {
        $cat = Category::findOrFail($id);
        $this->editingCategoryId = $cat->id;
        $this->editingCategoryName = $cat->name;
    }

    public function updateCategory(): void
    {
        $this->validate([
            'editingCategoryName' => 'required|string|max:100|unique:categories,name,' . $this->editingCategoryId . ',id,type,ppid_berkala',
        ]);

        $cat = Category::findOrFail($this->editingCategoryId);
        $oldSlug = $cat->slug;
        $newSlug = Category::generateUniqueSlug($this->editingCategoryName, 'ppid_berkala', $cat->id);

        $cat->update([
            'name' => trim($this->editingCategoryName),
            'slug' => $newSlug,
        ]);

        PpidBerkala::where('category', $oldSlug)->update(['category' => $newSlug]);

        $this->editingCategoryId = null;
        $this->editingCategoryName = '';
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Kategori berhasil diperbarui.');
    }

    public function cancelEditCategory(): void
    {
        $this->editingCategoryId = null;
        $this->editingCategoryName = '';
    }

    #[On('deleteCategoryConfirmed')]
    public function deleteCategory(int $id): void
    {
        $cat = Category::findOrFail($id);
        if (PpidBerkala::where('category', $cat->slug)->orWhere('category', $cat->name)->count() > 0) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal Hapus Kategori', text: 'Kategori tidak dapat dihapus karena masih terikat dengan data yang ada.');
            return;
        }
        $cat->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Kategori berhasil dihapus.');
    }

    private function resetCategoryForm(): void
    {
        $this->newCategoryName = '';
        $this->editingCategoryId = null;
        $this->editingCategoryName = '';
    }

    public function ensureDefaultCategoriesExist(): void
    {
        if (Category::where('type', 'ppid_berkala')->count() === 0) {
            $defaults = PpidBerkala::CATEGORIES;
            foreach ($defaults as $name) {
                Category::firstOrCreate([
                    'type' => 'ppid_berkala',
                    'name' => $name,
                ], [
                    'slug' => Category::generateUniqueSlug($name, 'ppid_berkala'),
                ]);
            }
        }
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
            'category' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:2099',
            'description' => 'nullable|string|max:2000',
            'is_published' => 'required|boolean',
        ];
    }

    #[Layout('layouts.admin', ['title' => 'PPID — Informasi Berkala'])]
    public function render()
    {
        $this->ensureDefaultCategoriesExist();
        $dynamicCategories = Category::where('type', 'ppid_berkala')->orderByDesc('id')->get();

        $items = PpidBerkala::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->filterCategory, fn($q) => $q->where('category', $this->filterCategory))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.ppid-berkala-management', [
            'items' => $items,
            'categories' => PpidBerkala::CATEGORIES,
            'dynamicCategories' => $dynamicCategories,
        ]);
    }
}
