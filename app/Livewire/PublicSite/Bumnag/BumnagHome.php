<?php

namespace App\Livewire\PublicSite\Bumnag;

use App\Models\BumnagProfile;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BumnagHome extends Component
{
    #[Layout('layouts.app', ['title' => 'BUMNag — Profil'])]
    public function render()
    {
        return view('livewire.public.bumnag.home', [
            'profile' => BumnagProfile::getContent(),
        ]);
    }
}
