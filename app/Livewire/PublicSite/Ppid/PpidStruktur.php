<?php

namespace App\Livewire\PublicSite\Ppid;

use App\Models\PpidContent;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PpidStruktur extends Component
{
    #[Layout('layouts.app', ['title' => 'Struktur Organisasi PPID'])]
    public function render()
    {
        return view('livewire.public.ppid.struktur', [
            'item' => PpidContent::getByType('struktur'),
        ]);
    }
}
