<?php

namespace App\Livewire\PublicSite;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

class UmkmDetail extends Component
{
    public Product $product;

    public function mount(int $id): void
    {
        $this->product = Product::active()->findOrFail($id);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $relatedProducts = Product::active()
            ->where('id', '!=', $this->product->id)
            ->when($this->product->category, fn ($q) => $q->where('category', $this->product->category))
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.public.umkm-detail', [
            'product' => $this->product,
            'relatedProducts' => $relatedProducts,
        ])->title($this->product->business_name . ' — UMKM Nagari');
    }
}
