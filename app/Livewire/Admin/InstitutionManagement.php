<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\VillageInstitution;
use App\Services\ImageOptimizer;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class InstitutionManagement extends Component
{
    use WithFileUploads;

    public bool $showForm = false;
    public ?int $editingId = null;

    // Modal Kelola Kategori
    public bool $showCategoryModal = false;
    public string $newCategoryName = '';
    public ?int $editingCategoryId = null;
    public string $editingCategoryName = '';

    #[Validate('nullable|exists:categories,id')]
    public $category_id = null;
    #[Validate('required|string|max:255')]
    public string $name = '';
    #[Validate('nullable|string')]
    public string $type = 'lainnya';
    #[Validate('nullable|string|max:255')]
    public ?string $head_name = '';
    #[Validate('nullable|string')]
    public ?string $description = '';
    #[Validate('nullable|string|max:255')]
    public ?string $contact = '';
    #[Validate('nullable|integer|min:1900|max:2100')]
    public $established_year = null;
    #[Validate('nullable|integer|min:0')]
    public int $order = 0;
    #[Validate('boolean')]
    public bool $is_active = true;
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $logo = null;
    public ?string $existingLogo = null;

    public function create(): void
    {
        $this->resetForm();
        $this->ensureDefaultCategoriesExist();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $this->ensureDefaultCategoriesExist();
        $m = VillageInstitution::findOrFail($id);
        $this->editingId = $m->id;
        $this->fill($m->only(['category_id', 'name', 'type', 'head_name', 'description', 'contact', 'established_year', 'order', 'is_active']));
        $this->existingLogo = $m->logo;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'category_id' => $this->category_id ?: null,
            'name' => $this->name,
            'type' => $this->type,
            'head_name' => $this->head_name,
            'description' => $this->description,
            'contact' => $this->contact,
            'established_year' => $this->established_year,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ];
        if ($this->logo) {
            $data['logo'] = (new ImageOptimizer())->optimize($this->logo, 'institutions', 'logo');
        }
        if ($this->editingId) {
            VillageInstitution::findOrFail($this->editingId)->update($data);
        } else {
            VillageInstitution::create($data);
        }
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil disimpan.');
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        VillageInstitution::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil dihapus.');
    }

    // ─── Kategori Management ───────────────────────────────

    public function openCategoryModal(): void
    {
        $this->ensureDefaultCategoriesExist();
        $this->resetCategoryForm();
        $this->showCategoryModal = true;
    }

    public function addCategory(): void
    {
        $this->validate([
            'newCategoryName' => 'required|string|max:100|unique:categories,name,NULL,id,type,lembaga',
        ], [
            'newCategoryName.required' => 'Nama kategori wajib diisi.',
            'newCategoryName.unique' => 'Nama kategori sudah ada.',
        ]);

        $cat = Category::create([
            'name' => trim($this->newCategoryName),
            'slug' => Category::generateUniqueSlug($this->newCategoryName, 'lembaga'),
            'type' => 'lembaga',
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
            'editingCategoryName' => 'required|string|max:100|unique:categories,name,' . $this->editingCategoryId . ',id,type,lembaga',
        ]);

        $cat = Category::findOrFail($this->editingCategoryId);
        $cat->update([
            'name' => trim($this->editingCategoryName),
            'slug' => Category::generateUniqueSlug($this->editingCategoryName, 'lembaga', $cat->id),
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
        if (VillageInstitution::where('category_id', $cat->id)->count() > 0) {
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
        if (Category::where('type', 'lembaga')->count() === 0) {
            $defaults = [
                'Adat & Budaya', 'Kepemudaan', 'Perempuan', 'Keagamaan',
                'Sosial', 'Pendidikan', 'Lainnya'
            ];
            foreach ($defaults as $name) {
                Category::firstOrCreate([
                    'type' => 'lembaga',
                    'name' => $name,
                ], [
                    'slug' => Category::generateUniqueSlug($name, 'lembaga'),
                ]);
            }
        }
    }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'category_id', 'name', 'type', 'head_name', 'description', 'contact', 'established_year', 'order', 'is_active', 'logo', 'existingLogo']);
        $this->is_active = true;
        $this->type = 'lainnya';
    }

    public function render()
    {
        $this->ensureDefaultCategoriesExist();
        $categories = Category::where('type', 'lembaga')->orderByDesc('id')->get();
        $institutions = VillageInstitution::with('category')->ordered()->get();
        return view('livewire.admin.institution-management', compact('institutions', 'categories'))
            ->layout('layouts.admin', ['title' => 'Lembaga Nagari']);
    }
}
