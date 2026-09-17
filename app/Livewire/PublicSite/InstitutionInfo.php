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
        $institutions = VillageInstitution::with('category')->active()->ordered()
            ->when($this->typeFilter, fn($q) => $q->where(function ($sub) {
                $sub->where('type', $this->typeFilter)->orWhere('category_id', $this->typeFilter);
            }))
            ->get();
        $categories = \App\Models\Category::where('type', 'lembaga')->orderBy('name')->get();
        $village = VillageProfile::first();

        return view('livewire.public.institution-info', compact('institutions', 'categories', 'village'))
            ->layout('layouts.app', ['title' => 'Lembaga Nagari']);
    }
}
