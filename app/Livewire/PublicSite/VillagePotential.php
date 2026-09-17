<?php
namespace App\Livewire\PublicSite;

use App\Models\Potential;
use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use Livewire\Component;

class VillagePotential extends Component
{
    #[Url]
    public string $category = '';

    #[Layout('layouts.app', ['title' => 'Potensi Desa'])]
    public function render()
    {
        $potentials = Potential::query()->when($this->category, fn ($q) => $q->where('category', $this->category))->latest()->get();
        $categoriesList = \App\Models\Category::where('type', 'potensi')->orderBy('name')->get();
        $categories = $categoriesList->pluck('name', 'slug')->toArray();

        return view('livewire.public.village-potential', compact('potentials', 'categories'));
    }
}
