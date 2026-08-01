<?php

namespace App\Livewire\PublicSite\Bumnag;

use App\Models\BumnagMember;
use App\Models\BumnagProfile;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BumnagStruktur extends Component
{
    #[Layout('layouts.app', ['title' => 'BUMNag — Struktur Organisasi'])]
    public function render()
    {
        return view('livewire.public.bumnag.struktur', [
            'profile' => BumnagProfile::getContent(),
            'pembina' => BumnagMember::active()->pembina()->ordered()->get(),
            'pengurus' => BumnagMember::active()->pengurus()->ordered()->get(),
            'pengawas' => BumnagMember::active()->pengawas()->ordered()->get(),
        ]);

    }
}
