<?php
namespace App\Livewire\PublicSite;

use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Umkm extends Component
{
    #[Url(as: 'q')]
    public string $search = '';

    #[Layout('layouts.app', ['title' => 'UMKM & Produk Desa'])]
    public function render()
    {
        $products = Product::active()
            ->when($this->search, fn ($q) => $q->where('business_name', 'like', "%{$this->search}%"))
            ->latest()->get();
        return view('livewire.public.umkm', compact('products'));
    }
}
