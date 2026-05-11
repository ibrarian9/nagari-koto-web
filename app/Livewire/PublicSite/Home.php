<?php

namespace App\Livewire\PublicSite;

use App\Models\Agenda;
use App\Models\GovernmentMember;
use App\Models\IdmStat;
use App\Models\PopulationStat;
use App\Models\Post;
use App\Models\Potential;
use App\Models\Product;
use App\Models\VillageProfile;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $village = VillageProfile::first();
        $latestStats = PopulationStat::latestYear()->first();
        $latestPosts = Post::with('category')->published()->latest('published_at')->take(3)->get();
        $upcomingAgendas = Agenda::publicOnly()->upcoming()->take(3)->get();
        $potentials = Potential::latest()->take(4)->get();
        $products = Product::active()->latest()->take(6)->get();
        $idm = IdmStat::latestYear()->first();
        $kepala = GovernmentMember::active()->ordered()->first();

        return view('livewire.public.home', compact(
            'village',
            'latestStats',
            'latestPosts',
            'upcomingAgendas',
            'potentials',
            'products',
            'idm',
            'kepala'
        ))->layout('layouts.app', ['title' => 'Beranda']);
    }
}
