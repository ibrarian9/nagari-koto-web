<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\LegalDocument;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
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

    // Modal Kelola Kategori
    public bool $showCategoryModal = false;
    public string $newCategoryName = '';
    public ?int $editingCategoryId = null;
    public string $editingCategoryName = '';

    #[Validate('nullable|exists:categories,id')]
    public $category_id = null;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string')]
    public string $category = 'perdes';

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
        $item = LegalDocument::findOrFail($id);
        $this->editingId = $id;
        $this->category_id = $item->category_id;
        $this->title = $item->title;
        $this->category = $item->category ?? 'perdes';
        $this->year = $item->year;
        $this->number = $item->number ?? '';
        $this->description = $item->description ?? '';
        $this->is_published = $item->is_published;
        $this->showForm = true;
    }

    public function save(): void
    {
        $rules = $this->editingId
            ? ['file' => 'nullable|file|mimes:pdf|max:2048']
            : ['file' => 'required|file|mimes:pdf|max:2048'];

        $this->validate(array_merge($this->rules(), $rules));

        $data = [
            'category_id' => $this->category_id ?: null,
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

            if ($this->editingId) {
                $old = LegalDocument::find($this->editingId);
                $oldFilePath = $old?->file_path;
            }
        }

        try {
            DB::beginTransaction();

            if ($this->editingId) {
                LegalDocument::findOrFail($this->editingId)->update($data);
            } else {
                LegalDocument::create($data);
            }

            DB::commit();

            if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
                Cache::forget(LegalDocument::CACHE_KEY_PREFIX . md5($oldFilePath));
            }

            if ($newFilePath) {
                Cache::forget(LegalDocument::CACHE_KEY_PREFIX . md5($newFilePath));
            }

            $this->showForm = false;
            $this->resetForm();
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: $this->editingId ? 'Data diperbarui.' : 'Data ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($newFilePath && Storage::disk('public')->exists($newFilePath)) {
                Storage::disk('public')->delete($newFilePath);
            }

            throw $e;
        }
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        $item = LegalDocument::findOrFail($id);
        if ($item->file_path) {
            Storage::disk('public')->delete($item->file_path);
            Cache::forget(LegalDocument::CACHE_KEY_PREFIX . md5($item->file_path));
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
            'newCategoryName' => 'required|string|max:100|unique:categories,name,NULL,id,type,produk_hukum',
        ], [
            'newCategoryName.required' => 'Nama kategori wajib diisi.',
            'newCategoryName.unique' => 'Nama kategori sudah ada.',
        ]);

        $cat = Category::create([
            'name' => trim($this->newCategoryName),
            'slug' => Category::generateUniqueSlug($this->newCategoryName, 'produk_hukum'),
            'type' => 'produk_hukum',
        ]);

        $this->category_id = $cat->id;
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
            'editingCategoryName' => 'required|string|max:100|unique:categories,name,' . $this->editingCategoryId . ',id,type,produk_hukum',
        ]);

        $cat = Category::findOrFail($this->editingCategoryId);
        $cat->update([
            'name' => trim($this->editingCategoryName),
            'slug' => Category::generateUniqueSlug($this->editingCategoryName, 'produk_hukum', $cat->id),
        ]);

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
        if (LegalDocument::where('category_id', $cat->id)->count() > 0) {
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
        if (Category::where('type', 'produk_hukum')->count() === 0) {
            $defaults = [
                'Peraturan Desa', 'SK Wali Nagari', 'Peraturan Bupati',
                'Peraturan Daerah', 'Undang-Undang', 'Peraturan Pemerintah',
                'Instruksi Presiden', 'Lainnya'
            ];
            foreach ($defaults as $name) {
                Category::firstOrCreate([
                    'type' => 'produk_hukum',
                    'name' => $name,
                ], [
                    'slug' => Category::generateUniqueSlug($name, 'produk_hukum'),
                ]);
            }
        }
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->category_id = null;
        $this->title = '';
        $this->category = 'perdes';
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

    protected function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'year' => 'required|integer|min:2000|max:2099',
            'number' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:2000',
            'is_published' => 'required|boolean',
        ];
    }

    #[Layout('layouts.admin', ['title' => 'Produk Hukum'])]
    public function render()
    {
        $this->ensureDefaultCategoriesExist();
        $dynamicCategories = Category::where('type', 'produk_hukum')->orderByDesc('id')->get();

        $items = LegalDocument::query()
            ->with('categoryRef')
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->filterCategory, fn($q) => $q->where(function ($sub) {
                $sub->where('category', $this->filterCategory)
                    ->orWhere('category_id', $this->filterCategory);
            }))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.legal-document-management', [
            'items' => $items,
            'categories' => LegalDocument::CATEGORIES,
            'dynamicCategories' => $dynamicCategories,
        ]);
    }
}
