<?php
namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Post;
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

    public function create(): void { $this->resetForm(); $this->showForm = true; }

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
        if ($this->status === 'published') { $data['published_at'] = now(); }
        if ($this->thumbnail) {
            $path = $this->thumbnail->store('posts', 'public');
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

    private function resetForm(): void
    {
        $this->reset(['showForm','editingId','category_id','title','excerpt','body','status','thumbnail','existingThumbnail']);
        $this->status = 'draft';
    }

    public function render()
    {
        $posts = Post::with('category', 'user')
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->latest()->paginate(10);
        $categories = Category::ofType('berita')->get();
        return view('livewire.admin.post-management', compact('posts', 'categories'))
            ->layout('layouts.admin', ['title' => 'Berita']);
    }
}
