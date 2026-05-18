<?php
namespace App\Livewire\PublicSite;
use App\Models\PopulationStat;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PopulationInfographic extends Component
{
    #[Layout('layouts.app', ['title' => 'Infografis Penduduk'])]
    public function render()
    {
        $stats = PopulationStat::latestYear()->first();
        return view('livewire.public.population-infographic', compact('stats'));
    }
}
