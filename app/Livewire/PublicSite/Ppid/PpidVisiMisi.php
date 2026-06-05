<?php

namespace App\Livewire\PublicSite\Ppid;

use App\Models\PpidContent;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PpidVisiMisi extends Component
{
    #[Layout('layouts.app', ['title' => 'Visi & Misi PPID'])]
    public function render()
    {
        return view('livewire.public.ppid.visi-misi', [
            'item' => PpidContent::getByType('visi_misi'),
        ]);
    }
}
