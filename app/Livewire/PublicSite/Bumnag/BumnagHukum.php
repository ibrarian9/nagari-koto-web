<?php

namespace App\Livewire\PublicSite\Bumnag;

use App\Models\BumnagProfile;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BumnagHukum extends Component
{
    #[Layout('layouts.app', ['title' => 'BUMNag — Badan Hukum'])]
    public function render()
    {
        return view('livewire.public.bumnag.hukum', [
            'profile' => BumnagProfile::getContent(),
        ]);
    }
}
