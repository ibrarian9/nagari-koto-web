<?php

namespace App\Livewire\PublicSite\Ppid;

use App\Models\PpidContent;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PpidProfil extends Component
{
    #[Layout('layouts.app', ['title' => 'Profil Singkat PPID'])]
    public function render()
    {
        return view('livewire.public.ppid.profil', [
            'item' => PpidContent::getByType('profil'),
        ]);
    }
}
