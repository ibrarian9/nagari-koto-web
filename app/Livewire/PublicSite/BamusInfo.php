<?php

namespace App\Livewire\PublicSite;

use App\Models\BamusMember;
use App\Models\VillageProfile;
use Livewire\Component;

class BamusInfo extends Component
{
    public function render()
    {
        $members = BamusMember::active()->ordered()->get();
        $village = VillageProfile::first();

        return view('livewire.public.bamus-info', compact('members', 'village'))
            ->layout('layouts.app', ['title' => 'BAMUS Nagari']);
    }
}
