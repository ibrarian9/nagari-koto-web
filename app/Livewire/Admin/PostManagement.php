<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Services\ImageOptimizer;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PostManagement extends Component
{
    use WithFileUploads, WithPagination;

    public bool $showForm = false;
    public ?int $editingId = null;
    public string $search = '';
    public string $categoryFilter = '';

    // Modal Kelola Kategori
    public bool $showCategoryModal = false;
    public string $newCategoryName = '';
    public ?int $editingCategoryId = null;
    public string $editingCategoryName = '';

    #[Validate('required|exists:categories,id')]
    public $category_id = '';
    #[Validate('required|string|max:255')]
    public string $title = '';
    #[Validate('nullable|string|max:500')]
    public string $excerpt = '';
    #[Validate('required|string')]
    public string $body = '';
    #[Validate('required|in:draft,published')]
    public string $status = 'draft';
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $thumbnail = null;
    public ?string $existingThumbnail = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->ensureDefaultCategoriesExist();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $p = Post::findOrFail($id);
        $this->editingId = $p->id;
        $this->category_id = $p->category_id;
        $this->title = $p->title;
        $this->excerpt = $p->excerpt ?? '';
        $this->body = $p->body;
        $this->status = $p->status;
        $this->existingThumbnail = $p->thumbnail;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . Str::random(5),
            'excerpt' => $this->excerpt,
            'body' => $this->body,
            'status' => $this->status,
            'user_id' => auth()->id(),
        ];
        if ($this->status === 'published') {
            $data['published_at'] = now();
        }
        if ($this->thumbnail) {
            $path = (new ImageOptimizer())->optimize($this->thumbnail, 'posts', 'thumbnail');
            $data['thumbnail'] = $path;
        }
        if ($this->editingId) {
            $post = Post::findOrFail($this->editingId);
            unset($data['slug'], $data['user_id']);
            $post->update($data);
        } else {
            Post::create($data);
        }
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Berita berhasil disimpan.');
    }

    public function toggleStatus(int $id): void
    {
        $p = Post::findOrFail($id);
        $newStatus = $p->status === 'published' ? 'draft' : 'published';
        $p->update(['status' => $newStatus, 'published_at' => $newStatus === 'published' ? now() : null]);
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        Post::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Berita berhasil dihapus.');
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
            'newCategoryName' => 'required|string|max:100|unique:categories,name,NULL,id,type,berita',
        ], [
            'newCategoryName.required' => 'Nama kategori wajib diisi.',
            'newCategoryName.unique' => 'Nama kategori sudah ada.',
        ]);

        $cat = Category::create([
            'name' => trim($this->newCategoryName),
            'slug' => Str::slug($this->newCategoryName),
            'type' => 'berita',
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
            'editingCategoryName' => 'required|string|max:100|unique:categories,name,' . $this->editingCategoryId . ',id,type,berita',
        ]);

        $cat = Category::findOrFail($this->editingCategoryId);
        $cat->update([
            'name' => trim($this->editingCategoryName),
            'slug' => Str::slug($this->editingCategoryName),
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

    public function deleteCategory(int $id): void
    {
        $cat = Category::findOrFail($id);
        if ($cat->posts()->count() > 0) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Kategori tidak dapat dihapus karena masih digunakan oleh berita.');
            return;
        }
        $cat->delete();
        if ($this->category_id == $id) {
            $this->category_id = '';
        }
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Kategori berhasil dihapus.');
    }

    private function resetCategoryForm(): void
    {
        $this->newCategoryName = '';
        $this->editingCategoryId = null;
        $this->editingCategoryName = '';
    }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'category_id', 'title', 'excerpt', 'body', 'status', 'thumbnail', 'existingThumbnail']);
        $this->status = 'draft';
    }

    private function ensureDefaultCategoriesExist(): void
    {
        if (Category::where('type', 'berita')->count() === 0) {
            $defaults = ['Pengumuman', 'Pembangunan', 'Kegiatan', 'Pendidikan', 'Kesehatan', 'Umum'];
            foreach ($defaults as $name) {
                Category::firstOrCreate(
                    ['name' => $name, 'type' => 'berita'],
                    ['slug' => Str::slug($name)]
                );
            }
        }
    }

    public function render()
    {
        $this->ensureDefaultCategoriesExist();

        $posts = Post::with('category', 'user')
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->categoryFilter, fn ($q) => $q->where('category_id', $this->categoryFilter))
            ->latest()->paginate(10);

        $categories = Category::where('type', 'berita')->orderBy('name')->get();

        return view('livewire.admin.post-management', compact('posts', 'categories'))
            ->layout('layouts.admin', ['title' => 'Berita']);
    }
}
