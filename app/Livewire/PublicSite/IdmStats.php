<?php
namespace App\Livewire\PublicSite;
use App\Models\IdmStat;
use Livewire\Attributes\Layout;
use Livewire\Component;

class IdmStats extends Component
{
    #[Layout('layouts.app', ['title' => 'Statistik IDM'])]
    public function render()
    {
        $allStats = IdmStat::query()->latestYear()->get();
        $latest = $allStats->first();
        return view('livewire.public.idm-stats', compact('allStats', 'latest'));
    }
}
