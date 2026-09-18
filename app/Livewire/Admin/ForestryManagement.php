<?php

namespace App\Livewire\Admin;

use App\Models\Category;
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

    // Modal Kelola Kategori
    public bool $showCategoryModal = false;
    public string $newCategoryName = '';
    public ?int $editingCategoryId = null;
    public string $editingCategoryName = '';

    #[Validate('required|string|max:255')]
    public string $title = '';
    #[Validate('required|string|max:100')]
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
        $this->ensureDefaultCategoriesExist();
        $this->year = date('Y');
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $this->ensureDefaultCategoriesExist();
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

    public function openCategoryModal(): void
    {
        $this->ensureDefaultCategoriesExist();
        $this->resetCategoryForm();
        $this->showCategoryModal = true;
    }

    public function addCategory(): void
    {
        $this->validate([
            'newCategoryName' => 'required|string|max:100|unique:categories,name,NULL,id,type,kehutanan',
        ], [
            'newCategoryName.required' => 'Nama kategori wajib diisi.',
            'newCategoryName.unique' => 'Nama kategori sudah ada.',
        ]);

        $cat = Category::create([
            'name' => trim($this->newCategoryName),
            'slug' => Category::generateUniqueSlug($this->newCategoryName, 'kehutanan'),
            'type' => 'kehutanan',
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
            'editingCategoryName' => 'required|string|max:100|unique:categories,name,' . $this->editingCategoryId . ',id,type,kehutanan',
        ]);

        $cat = Category::findOrFail($this->editingCategoryId);
        $oldSlug = $cat->slug;
        $newSlug = Category::generateUniqueSlug($this->editingCategoryName, 'kehutanan', $cat->id);

        $cat->update([
            'name' => trim($this->editingCategoryName),
            'slug' => $newSlug,
        ]);

        ForestryRecord::where('category', $oldSlug)->update(['category' => $newSlug]);

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
        if (ForestryRecord::where('category', $cat->slug)->orWhere('category', $cat->name)->count() > 0) {
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
        if (Category::where('type', 'kehutanan')->count() === 0) {
            $defaults = [
                'Hutan Lindung',
                'Hutan Produksi',
                'Hutan Rakyat',
                'Lahan Kritis',
                'Rehabilitasi Hutan',
            ];
            foreach ($defaults as $name) {
                Category::firstOrCreate([
                    'type' => 'kehutanan',
                    'name' => $name,
                ], [
                    'slug' => Category::generateUniqueSlug($name, 'kehutanan'),
                ]);
            }
        }
    }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'title', 'category', 'area_ha', 'location', 'description', 'status', 'year', 'thumbnail', 'existingThumbnail']);
        $this->status = 'aktif';
    }

    public function render()
    {
        $this->ensureDefaultCategoriesExist();
        $categories = Category::where('type', 'kehutanan')->orderByDesc('id')->get();

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

        return view('livewire.admin.forestry-management', compact('records', 'summary', 'categories'))
            ->layout('layouts.admin', ['title' => 'Data Kehutanan']);
    }
}
