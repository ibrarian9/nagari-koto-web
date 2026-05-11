<?php
namespace App\Livewire\PublicSite;
use App\Models\PopulationStat;
use Livewire\Component;

class PopulationInfographic extends Component
{
    public function render()
    {
        $stats = PopulationStat::latestYear()->first();
        return view('livewire.public.population-infographic', compact('stats'))
            ->layout('layouts.app', ['title' => 'Infografis Penduduk']);
    }
}
