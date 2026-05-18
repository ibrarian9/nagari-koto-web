<?php
namespace App\Livewire\PublicSite;
use App\Models\Agenda as AgendaModel;
use Livewire\Attributes\Layout;
use App\Models\VillageProfile;
use Livewire\Component;

#[Layout('layouts.app', ['title' => 'Agenda Kegiatan'])]
class Agenda extends Component
{
    public function render()
    {
        $upcoming = AgendaModel::publicOnly()->upcoming()->get();
        $past = AgendaModel::publicOnly()->past()->take(10)->get();
        $village = VillageProfile::first()?->name;
        return view('livewire.public.agenda', compact('upcoming', 'past', 'village'));
    }
}
