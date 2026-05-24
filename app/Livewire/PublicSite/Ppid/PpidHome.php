<?php

namespace App\Livewire\PublicSite\Ppid;

use App\Models\PpidBerkala;
use App\Models\PpidSetiapSaat;
use App\Models\PpidSertaMerta;
use App\Models\PpidPermohonan;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PpidHome extends Component
{
    #[Layout('layouts.app', ['title' => 'PPID — Informasi Publik'])]
    public function render()
    {
        return view('livewire.public.ppid.home', [
            'berkalaCount' => PpidBerkala::published()->count(),
            'setiapSaatCount' => PpidSetiapSaat::published()->count(),
            'urgentItems' => PpidSertaMerta::active()->latest('published_at')->take(3)->get(),
            'permohonanCount' => PpidPermohonan::count(),
        ]);
    }
}
