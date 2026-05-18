<?php

namespace App\Livewire\PublicSite;

use App\Models\VillageProfile;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BansosLink extends Component
{
    #[Layout('layouts.app', ['title' => 'Cek Bansos'])]
    public function render()
    {
        $village = VillageProfile::first();

        $links = [
            [
                'title'       => 'Cek Bansos Kemensos',
                'description' => 'Cek status penerima bantuan sosial melalui website resmi Kementerian Sosial RI.',
                'url'         => 'https://cekbansos.kemensos.go.id',
                'icon'        => 'verified',
                'color'       => 'from-blue-500 to-blue-700',
                'light'       => 'bg-blue-50 text-blue-600',
            ],
        ];

        return view('livewire.public.bansos-link', compact('village', 'links'));
    }
}
