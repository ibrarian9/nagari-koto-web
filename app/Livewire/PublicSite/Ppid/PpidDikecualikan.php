<?php

namespace App\Livewire\PublicSite\Ppid;

use App\Models\PpidDikecualikan as PpidDikecualikanModel;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PpidDikecualikan extends Component
{
    #[Layout('layouts.app', ['title' => 'Informasi Dikecualikan — PPID'])]
    public function render()
    {
        return view('livewire.public.ppid.dikecualikan', [
            'record' => PpidDikecualikanModel::getContent(),
        ]);
    }
}
