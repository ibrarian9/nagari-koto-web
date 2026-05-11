<?php

namespace App\Livewire\PublicSite;

use App\Models\GovernmentMember;
use App\Models\PopulationStat;
use App\Models\VillageProfile as VillageProfileModel;
use Livewire\Component;

class VillageProfile extends Component
{
    public function render()
    {
        $village = VillageProfileModel::getCached();
        $kepala = GovernmentMember::active()->ordered()->first();
        $latestStats = PopulationStat::latestYear()->first();

        return view('livewire.public.village-profile', compact('village', 'kepala', 'latestStats'))
            ->layout('layouts.app', ['title' => 'Profil Desa']);
    }
}
