<?php

namespace App\Livewire\PublicSite;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class Umkm extends Component
{
    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'cat')]
    public string $category = '';

    #[Layout('layouts.app', ['title' => 'UMKM & Produk Desa'])]
    public function render()
    {
        $categories = Product::active()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');

        $products = Product::active()
            ->when($this->search, fn ($q) => $q->where(function ($query) {
                $query->where('business_name', 'like', "%{$this->search}%")
                    ->orWhere('owner_name', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            }))
            ->when($this->category, fn ($q) => $q->where('category', $this->category))
            ->latest()
            ->get();

        return view('livewire.public.umkm', compact('products', 'categories'));
    }
}
