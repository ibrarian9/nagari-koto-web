<?php

namespace App\Livewire\PublicSite\Bumnag;

use App\Models\BumnagBudget;
use App\Models\BumnagProfile;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BumnagAnggaran extends Component
{
    public int $selectedYear = 0;

    public function mount(): void
    {
        $this->selectedYear = BumnagBudget::latestYear()->value('year') ?? (int) date('Y');
    }

    #[Layout('layouts.app', ['title' => 'BUMNag — Anggaran'])]
    public function render()
    {
        return view('livewire.public.bumnag.anggaran', [
            'profile' => BumnagProfile::getContent(),
            'stat' => BumnagBudget::where('year', $this->selectedYear)->first(),
            'years' => BumnagBudget::orderByDesc('year')->pluck('year'),
        ]);
    }
}
