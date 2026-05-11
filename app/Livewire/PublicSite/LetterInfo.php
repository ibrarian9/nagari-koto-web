<?php
namespace App\Livewire\PublicSite;
use Livewire\Component;

class LetterInfo extends Component
{
    public function render()
    {
        $letterTypes = config('letters.types', []);
        return view('livewire.public.letter-info', compact('letterTypes'))
            ->layout('layouts.app', ['title' => 'Layanan Surat']);
    }
}
