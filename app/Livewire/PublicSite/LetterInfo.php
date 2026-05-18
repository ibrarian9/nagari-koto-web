<?php
namespace App\Livewire\PublicSite;
use Livewire\Attributes\Layout;
use Livewire\Component;

class LetterInfo extends Component
{
    #[Layout('layouts.app', ['title' => 'Layanan Surat'])]
    public function render()
    {
        $letterTypes = config('letters.types', []);
        return view('livewire.public.letter-info', compact('letterTypes'));
    }
}
