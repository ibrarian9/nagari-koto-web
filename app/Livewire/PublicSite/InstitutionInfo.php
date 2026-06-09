<?php

namespace App\Livewire\PublicSite;

use App\Models\VillageInstitution;
use App\Models\VillageProfile;
use Livewire\Component;

class InstitutionInfo extends Component
{
    public string $typeFilter = '';

    #[Layout]
    public function render()
    {
        $institutions = VillageInstitution::active()->ordered()
            ->when($this->typeFilter, fn($q) => $q->byType($this->typeFilter))
            ->get();
        $village = VillageProfile::first();

        return view('livewire.public.institution-info', compact('institutions', 'village'))
            ->layout('layouts.app', ['title' => 'Lembaga Nagari']);
    }
}
