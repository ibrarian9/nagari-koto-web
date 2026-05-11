<?php
namespace App\Livewire\PublicSite;
use App\Models\Agenda as AgendaModel;
use Livewire\Component;

class Agenda extends Component
{
    public function render()
    {
        $upcoming = AgendaModel::publicOnly()->upcoming()->get();
        $past = AgendaModel::publicOnly()->past()->take(10)->get();
        return view('livewire.public.agenda', compact('upcoming', 'past'))
            ->layout('layouts.app', ['title' => 'Agenda Kegiatan']);
    }
}
