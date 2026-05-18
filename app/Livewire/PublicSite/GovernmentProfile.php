<?php

namespace App\Livewire\PublicSite;

use App\Models\GovernmentMember;
use Livewire\Attributes\Layout;
use Livewire\Component;

class GovernmentProfile extends Component
{
    #[Layout('layouts.app', ['title' => 'Pemerintahan Nagari'])]
    public function render()
    {
        $members = GovernmentMember::active()->ordered()->get();
        return view('livewire.public.government-profile', compact('members'));
    }
}
