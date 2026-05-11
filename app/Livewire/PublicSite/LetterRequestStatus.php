<?php
namespace App\Livewire\PublicSite;
use Livewire\Component;

class LetterRequestStatus extends Component
{
    public function render()
    {
        $requests = auth()->user()->letterRequests()->latest()->get();
        return view('livewire.public.letter-request-status', compact('requests'))
            ->layout('layouts.app', ['title' => 'Status Permohonan Surat']);
    }
}
