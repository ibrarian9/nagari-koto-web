<?php

namespace App\Livewire\PublicSite\Bumnag;

use App\Models\BumnagProfile;
use App\Models\BumnagProgram as BumnagProgramModel;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BumnagProgramKerja extends Component
{
    #[Layout('layouts.app', ['title' => 'BUMNag — Program Kerja'])]
    public function render()
    {
        return view('livewire.public.bumnag.program-kerja', [
            'profile' => BumnagProfile::getContent(),
            'programs' => BumnagProgramModel::active()->ordered()->get(),
        ]);
    }
}
