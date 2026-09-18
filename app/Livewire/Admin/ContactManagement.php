<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Contact;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactManagement extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;

    // Modal Kelola Kategori
    public bool $showCategoryModal = false;
    public string $newCategoryName = '';
    public ?int $editingCategoryId = null;
    public string $editingCategoryName = '';

    #[Validate('required|string|max:255')]
    public string $label = '';
    #[Validate('required|string|max:20')]
    public string $phone = '';
    #[Validate('required|string|max:100')]
    public string $category = '';
    #[Validate('nullable|integer|min:0')]
    public int $order = 0;

    public function create(): void
    {
        $this->resetForm();
        $this->ensureDefaultCategoriesExist();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $this->ensureDefaultCategoriesExist();
        $m = Contact::findOrFail($id);
        $this->editingId = $m->id;
        $this->fill($m->only(['label', 'phone', 'category', 'order']));
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'label' => $this->label,
            'phone' => $this->phone,
            'category' => $this->category,
            'order' => $this->order,
        ];
        if ($this->editingId) {
            Contact::findOrFail($this->editingId)->update($data);
        } else {
            Contact::create($data);
        }
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Kontak berhasil disimpan.');
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        Contact::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Kontak dihapus.');
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
            'newCategoryName' => 'required|string|max:100|unique:categories,name,NULL,id,type,kontak',
        ], [
            'newCategoryName.required' => 'Nama kategori wajib diisi.',
            'newCategoryName.unique' => 'Nama kategori sudah ada.',
        ]);

        $cat = Category::create([
            'name' => trim($this->newCategoryName),
            'slug' => Category::generateUniqueSlug($this->newCategoryName, 'kontak'),
            'type' => 'kontak',
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
            'editingCategoryName' => 'required|string|max:100|unique:categories,name,' . $this->editingCategoryId . ',id,type,kontak',
        ]);

        $cat = Category::findOrFail($this->editingCategoryId);
        $oldSlug = $cat->slug;
        $newSlug = Category::generateUniqueSlug($this->editingCategoryName, 'kontak', $cat->id);

        $cat->update([
            'name' => trim($this->editingCategoryName),
            'slug' => $newSlug,
        ]);

        Contact::where('category', $oldSlug)->update(['category' => $newSlug]);

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
        if (Contact::where('category', $cat->slug)->orWhere('category', $cat->name)->count() > 0) {
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
        if (Category::where('type', 'kontak')->count() === 0) {
            $defaults = [
                'emergency' => 'Darurat',
                'government' => 'Pemerintahan',
                'health' => 'Kesehatan',
                'social' => 'Sosial',
                'lainnya' => 'Lainnya',
            ];
            foreach ($defaults as $name) {
                Category::firstOrCreate([
                    'type' => 'kontak',
                    'name' => $name,
                ], [
                    'slug' => Category::generateUniqueSlug($name, 'kontak'),
                ]);
            }
        }
    }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'label', 'phone', 'category', 'order']);
    }

    public function render()
    {
        $this->ensureDefaultCategoriesExist();
        $categories = Category::where('type', 'kontak')->orderByDesc('id')->get();
        $contacts = Contact::ordered()->get();

        return view('livewire.admin.contact-management', compact('contacts', 'categories'))
            ->layout('layouts.admin', ['title' => 'Kontak']);
    }
}
