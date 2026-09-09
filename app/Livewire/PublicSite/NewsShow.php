<?php

namespace App\Livewire\PublicSite;

use App\Models\Post;
use Livewire\Component;

class NewsShow extends Component
{
    public Post $post;

    public function mount(string $slug): void
    {
        $this->post = Post::with('category', 'user')
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();
        
        $this->post->increment('views', 1);
    }

    public function render()
    {
        $relatedPosts = Post::with('category')
            ->published()
            ->where('category_id', $this->post->category_id)
            ->where('id', '!=', $this->post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $ogDescription = $this->post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($this->post->body), 150);

        return view('livewire.public.news-show', [
            'post' => $this->post, 
            'relatedPosts' => $relatedPosts
        ])->layout('layouts.app', [
            'title' => $this->post->title,
            'metaDescription' => $ogDescription,
            'ogImage' => $this->post->og_image_url,
            'ogType' => 'article',
        ]);
    }
}
