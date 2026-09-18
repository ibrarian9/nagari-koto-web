<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\IdmStat;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class IdmStatManagement extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;

    // Modal Kelola Kategori
    public bool $showCategoryModal = false;
    public string $newCategoryName = '';
    public ?int $editingCategoryId = null;
    public string $editingCategoryName = '';

    #[Validate('required|integer|min:2000|max:2100')]
    public int $year = 2024;
    #[Validate('required|numeric|min:0|max:635')]
    public $score = 0;
    #[Validate('required|in:sangat_tertinggal,tertinggal,berkembang,maju,mandiri')]
    public string $status = 'berkembang';
    #[Validate('required|numeric|min:0|max:635')]
    public $social_score = 0;
    #[Validate('required|numeric|min:0|max:635')]
    public $economic_score = 0;
    #[Validate('required|numeric|min:0|max:635')]
    public $environment_score = 0;
    #[Validate('nullable|numeric|min:0|max:635')]
    public $accessibility_score = 0;
    #[Validate('nullable|numeric|min:0|max:635')]
    public $basic_service_score = 0;
    #[Validate('nullable|numeric|min:0|max:635')]
    public $governance_score = 0;
    #[Validate('nullable|string')]
    public string $notes = '';

    public function create(): void
    {
        $this->resetForm();
        $this->ensureDefaultCategoriesExist();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $this->ensureDefaultCategoriesExist();
        $m = IdmStat::findOrFail($id);
        $this->editingId = $m->id;
        $this->fill($m->only(['year', 'score', 'status', 'social_score', 'economic_score', 'environment_score', 'accessibility_score', 'basic_service_score', 'governance_score']));
        $this->notes = $m->notes ?? '';
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'year' => $this->year,
            'score' => $this->score,
            'status' => $this->status,
            'social_score' => $this->social_score,
            'economic_score' => $this->economic_score,
            'environment_score' => $this->environment_score,
            'accessibility_score' => $this->accessibility_score,
            'basic_service_score' => $this->basic_service_score,
            'governance_score' => $this->governance_score,
            'notes' => $this->notes,
        ];
        if ($this->editingId) {
            IdmStat::findOrFail($this->editingId)->update($data);
        } else {
            IdmStat::create($data);
        }
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data IDM disimpan.');
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        IdmStat::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data IDM dihapus.');
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
            'newCategoryName' => 'required|string|max:100|unique:categories,name,NULL,id,type,idm',
        ], [
            'newCategoryName.required' => 'Nama kategori wajib diisi.',
            'newCategoryName.unique' => 'Nama kategori sudah ada.',
        ]);

        Category::create([
            'name' => trim($this->newCategoryName),
            'slug' => Category::generateUniqueSlug($this->newCategoryName, 'idm'),
            'type' => 'idm',
        ]);

        $this->newCategoryName = '';
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Kategori IDM baru berhasil ditambahkan.');
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
            'editingCategoryName' => 'required|string|max:100|unique:categories,name,' . $this->editingCategoryId . ',id,type,idm',
        ]);

        $cat = Category::findOrFail($this->editingCategoryId);
        $cat->update([
            'name' => trim($this->editingCategoryName),
            'slug' => Category::generateUniqueSlug($this->editingCategoryName, 'idm', $cat->id),
        ]);

        $this->editingCategoryId = null;
        $this->editingCategoryName = '';
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Kategori IDM berhasil diperbarui.');
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
        $statusKey = Str::slug($cat->name, '_');
        if (IdmStat::where('status', $statusKey)->orWhere('status', $cat->slug)->count() > 0) {
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
        if (Category::where('type', 'idm')->count() === 0) {
            $defaults = ['Sangat Tertinggal', 'Tertinggal', 'Berkembang', 'Maju', 'Mandiri'];
            foreach ($defaults as $name) {
                Category::firstOrCreate([
                    'type' => 'idm',
                    'name' => $name,
                ], [
                    'slug' => Category::generateUniqueSlug($name, 'idm'),
                ]);
            }
        }
    }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'year', 'score', 'status', 'social_score', 'economic_score', 'environment_score', 'accessibility_score', 'basic_service_score', 'governance_score', 'notes']);
        $this->year = (int) date('Y');
        $this->status = 'berkembang';
    }

    public function render()
    {
        $this->ensureDefaultCategoriesExist();
        $categories = Category::where('type', 'idm')->orderByDesc('id')->get();
        $stats = IdmStat::orderByDesc('year')->get();

        return view('livewire.admin.idm-stat-management', compact('stats', 'categories'))
            ->layout('layouts.admin', ['title' => 'IDM']);
    }
}

