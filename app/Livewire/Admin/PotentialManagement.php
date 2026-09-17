<?php
namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Potential;
use App\Services\ImageOptimizer;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class PotentialManagement extends Component
{
    use WithFileUploads;

    public bool $showForm = false;
    public ?int $editingId = null;

    // Modal Kelola Kategori
    public bool $showCategoryModal = false;
    public string $newCategoryName = '';
    public ?int $editingCategoryId = null;
    public string $editingCategoryName = '';

    #[Validate('required|string|max:100')]
    public string $category = '';
    #[Validate('required|string|max:255')]
    public string $title = '';
    #[Validate('nullable|string')]
    public string $description = '';
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $thumbnail = null;
    public ?string $existingThumbnail = null;

    public function create(): void
    {
        $this->resetForm();
        $this->ensureDefaultCategoriesExist();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $this->ensureDefaultCategoriesExist();
        $m = Potential::findOrFail($id);
        $this->editingId = $m->id;
        $this->fill($m->only(['category', 'title', 'description']));
        $this->existingThumbnail = $m->thumbnail;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'category' => $this->category,
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . Str::random(5),
            'description' => $this->description,
        ];
        if ($this->thumbnail) {
            $data['thumbnail'] = (new ImageOptimizer())->optimize($this->thumbnail, 'potentials', 'thumbnail');
        }
        if ($this->editingId) {
            unset($data['slug']);
            Potential::findOrFail($this->editingId)->update($data);
        } else {
            Potential::create($data);
        }
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil disimpan.');
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        Potential::findOrFail($id)->delete();
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
            'newCategoryName' => 'required|string|max:100|unique:categories,name,NULL,id,type,potensi',
        ], [
            'newCategoryName.required' => 'Nama kategori wajib diisi.',
            'newCategoryName.unique' => 'Nama kategori sudah ada.',
        ]);

        $cat = Category::create([
            'name' => trim($this->newCategoryName),
            'slug' => Category::generateUniqueSlug($this->newCategoryName, 'potensi'),
            'type' => 'potensi',
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
            'editingCategoryName' => 'required|string|max:100|unique:categories,name,' . $this->editingCategoryId . ',id,type,potensi',
        ]);

        $cat = Category::findOrFail($this->editingCategoryId);
        $oldSlug = $cat->slug;
        $newSlug = Category::generateUniqueSlug($this->editingCategoryName, 'potensi', $cat->id);

        $cat->update([
            'name' => trim($this->editingCategoryName),
            'slug' => $newSlug,
        ]);

        // Synchronize existing potential records using old slug
        Potential::where('category', $oldSlug)->update(['category' => $newSlug]);

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
        if (Potential::where('category', $cat->slug)->orWhere('category', $cat->name)->count() > 0) {
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
        if (Category::where('type', 'potensi')->count() === 0) {
            $defaults = [
                'Ekonomi',
                'Pariwisata',
                'Pertanian',
                'Kreatif',
                'Lingkungan',
            ];
            foreach ($defaults as $name) {
                Category::firstOrCreate([
                    'type' => 'potensi',
                    'name' => $name,
                ], [
                    'slug' => Category::generateUniqueSlug($name, 'potensi'),
                ]);
            }
        }
    }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'category', 'title', 'description', 'thumbnail', 'existingThumbnail']);
    }

    public function render()
    {
        $this->ensureDefaultCategoriesExist();
        $categories = Category::where('type', 'potensi')->orderByDesc('id')->get();
        $potentials = Potential::latest()->get();
        return view('livewire.admin.potential-management', compact('potentials', 'categories'))
            ->layout('layouts.admin', ['title' => 'Potensi Desa']);
    }
}

