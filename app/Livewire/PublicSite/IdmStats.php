<?php
namespace App\Livewire\PublicSite;
use App\Models\IdmStat;
use Livewire\Component;

class IdmStats extends Component
{
    public function render()
    {
        $allStats = IdmStat::latestYear()->get();
        $latest = $allStats->first();
        return view('livewire.public.idm-stats', compact('allStats', 'latest'))
            ->layout('layouts.app', ['title' => 'Statistik IDM']);
    }
}
