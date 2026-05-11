<?php

namespace App\Livewire\PublicSite;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class NewsIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $category = '';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingCategory(): void { $this->resetPage(); }

    public function render()
    {
        $posts = Post::with('category', 'user')
            ->published()
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->category, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $this->category)))
            ->latest('published_at')
            ->paginate(9);

        $categories = Category::ofType('berita')->get();

        return view('livewire.public.news-index', compact('posts', 'categories'))
            ->layout('layouts.app', ['title' => 'Berita']);
    }
}
