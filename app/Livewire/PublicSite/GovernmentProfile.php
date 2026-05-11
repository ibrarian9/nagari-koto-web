<?php

namespace App\Livewire\PublicSite;

use App\Models\GovernmentMember;
use Livewire\Component;

class GovernmentProfile extends Component
{
    public function render()
    {
        $members = GovernmentMember::active()->ordered()->get();
        return view('livewire.public.government-profile', compact('members'))
            ->layout('layouts.app', ['title' => 'Pemerintahan Desa']);
    }
}
