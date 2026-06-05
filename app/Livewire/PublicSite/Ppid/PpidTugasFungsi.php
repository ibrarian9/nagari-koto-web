<?php

namespace App\Livewire\PublicSite\Ppid;

use App\Models\PpidContent;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PpidTugasFungsi extends Component
{
    #[Layout('layouts.app', ['title' => 'Tugas & Fungsi PPID'])]
    public function render()
    {
        return view('livewire.public.ppid.tugas-fungsi', [
            'item' => PpidContent::getByType('tugas_fungsi'),
        ]);
    }
}
