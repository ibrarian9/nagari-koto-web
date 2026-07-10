<?php

namespace App\Livewire\PublicSite;

use App\Models\GovernmentMember;
use Livewire\Attributes\Layout;
use Livewire\Component;

class GovernmentDetail extends Component
{
    public GovernmentMember $member;

    public function mount(int $id): void
    {
        $this->member = GovernmentMember::active()->findOrFail($id);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.public.government-detail')
            ->layoutData(['title' => $this->member->name . ' — Pemerintahan Nagari']);
    }
}
