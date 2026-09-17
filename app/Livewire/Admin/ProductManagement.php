<?php
namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Services\ImageOptimizer;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductManagement extends Component
{
    use WithFileUploads;

    public bool $showForm = false;
    public bool $showDetailModal = false;
    public ?Product $detailProduct = null;
    public ?int $editingId = null;
    public string $search = '';

    // Modal Kelola Kategori
    public bool $showCategoryModal = false;
    public string $newCategoryName = '';
    public ?int $editingCategoryId = null;
    public string $editingCategoryName = '';

    public function viewDetail(int $id): void
    {
        $this->detailProduct = Product::findOrFail($id);
        $this->showDetailModal = true;
    }

    #[Validate('required|string|max:255')]
    public string $owner_name = '';
    #[Validate('required|string|max:255')]
    public string $business_name = '';
    #[Validate('nullable|string|max:100')]
    public string $category = '';
    #[Validate('nullable|string')]
    public string $description = '';
    #[Validate('nullable|string|max:20')]
    public string $whatsapp = '';
    #[Validate('nullable|string|max:500')]
    public string $address = '';
    #[Validate('boolean')]
    public bool $is_active = true;
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $photo = null;
    public ?string $existingPhoto = null;

    public function create(): void
    {
        $this->resetForm();
        $this->ensureDefaultCategoriesExist();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $this->ensureDefaultCategoriesExist();
        $m = Product::findOrFail($id);
        $this->editingId = $m->id;
        $this->fill($m->only(['owner_name', 'business_name', 'category', 'description', 'whatsapp', 'address', 'is_active']));
        $this->existingPhoto = $m->photo;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'owner_name' => $this->owner_name,
            'business_name' => $this->business_name,
            'category' => $this->category,
            'description' => $this->description,
            'whatsapp' => $this->whatsapp,
            'address' => $this->address,
            'is_active' => $this->is_active,
        ];
        if ($this->photo) {
            $data['photo'] = (new ImageOptimizer())->optimize($this->photo, 'products', 'photo');
        }
        if ($this->editingId) {
            Product::findOrFail($this->editingId)->update($data);
        } else {
            Product::create($data);
        }
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data UMKM berhasil disimpan.');
    }

    public function toggleActive(int $id): void
    {
        $p = Product::findOrFail($id);
        $p->update(['is_active' => !$p->is_active]);
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        Product::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data dihapus.');
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
            'newCategoryName' => 'required|string|max:100|unique:categories,name,NULL,id,type,umkm',
        ], [
            'newCategoryName.required' => 'Nama kategori wajib diisi.',
            'newCategoryName.unique' => 'Nama kategori sudah ada.',
        ]);

        $cat = Category::create([
            'name' => trim($this->newCategoryName),
            'slug' => Category::generateUniqueSlug($this->newCategoryName, 'umkm'),
            'type' => 'umkm',
        ]);

        $this->category = $cat->name;
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
            'editingCategoryName' => 'required|string|max:100|unique:categories,name,' . $this->editingCategoryId . ',id,type,umkm',
        ]);

        $cat = Category::findOrFail($this->editingCategoryId);
        $oldName = $cat->name;
        $newName = trim($this->editingCategoryName);

        $cat->update([
            'name' => $newName,
            'slug' => Category::generateUniqueSlug($newName, 'umkm', $cat->id),
        ]);

        Product::where('category', $oldName)->update(['category' => $newName]);

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
        if (Product::where('category', $cat->name)->orWhere('category', $cat->slug)->count() > 0) {
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
        if (Category::where('type', 'umkm')->count() === 0) {
            $defaults = ['Kuliner', 'Kerajinan', 'Pertanian', 'Minuman', 'Jasa', 'Perdagangan', 'Lainnya'];
            foreach ($defaults as $name) {
                Category::firstOrCreate([
                    'type' => 'umkm',
                    'name' => $name,
                ], [
                    'slug' => Category::generateUniqueSlug($name, 'umkm'),
                ]);
            }
        }
    }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'owner_name', 'business_name', 'category', 'description', 'whatsapp', 'address', 'is_active', 'photo', 'existingPhoto']);
        $this->is_active = true;
    }

    public function render()
    {
        $this->ensureDefaultCategoriesExist();
        $categories = Category::where('type', 'umkm')->orderByDesc('id')->get();
        $products = Product::when($this->search, fn($q) => $q->where('business_name', 'like', "%{$this->search}%"))->latest()->get();
        return view('livewire.admin.product-management', compact('products', 'categories'))->layout('layouts.admin', ['title' => 'UMKM']);
    }
}

