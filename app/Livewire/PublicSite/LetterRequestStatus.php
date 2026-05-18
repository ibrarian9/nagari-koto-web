<?php
namespace App\Livewire\PublicSite;
use Livewire\Attributes\Layout;
use Livewire\Component;

class LetterRequestStatus extends Component
{
    #[Layout('layouts.app', ['title' => 'Status Permohonan Surat'])]
    public function render()
    {
        $requests = auth()->user()->letterRequests()->latest()->get();
        return view('livewire.public.letter-request-status', compact('requests'));
    }
}
