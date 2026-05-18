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
        $potentials = Potential::query()->when($this->category, fn ($q) => $q->ofCategory($this->category))->latest()->get();
        $categories = ['economy' => 'Ekonomi', 'tourism' => 'Pariwisata', 'agriculture' => 'Pertanian', 'creative' => 'Kreatif', 'environment' => 'Lingkungan'];
        return view('livewire.public.village-potential', compact('potentials', 'categories'));
    }
}
