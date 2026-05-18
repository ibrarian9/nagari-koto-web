<?php
namespace App\Livewire\PublicSite;

use App\Models\LetterRequest;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LetterRequestForm extends Component
{
    #[Validate('required|in:' . 'surat_domisili,surat_tidak_mampu,surat_keterangan_usaha,surat_keterangan_lahir,surat_kematian,surat_pengantar_nikah,surat_izin_keramaian')]
    public string $letter_type = '';

    #[Validate('required|string|max:255')]
    public string $full_name = '';

    #[Validate('required|digits:16')]
    public string $nik = '';

    #[Validate('required|string|max:500')]
    public string $address = '';

    #[Validate('nullable|string|max:1000')]
    public string $purpose = '';

    public bool $submitted = false;

    public function submit(): void
    {
        $this->validate();

        LetterRequest::create([
            'user_id' => auth()->id(),
            'letter_type' => $this->letter_type,
            'full_name' => $this->full_name,
            'nik' => $this->nik,
            'address' => $this->address,
            'purpose' => $this->purpose,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        $this->submitted = true;
    }

    #[Layout('layouts.app', ['title' => 'Ajukan Surat'])]
    public function render()
    {
        $letterTypes = config('letters.types', []);
        return view('livewire.public.letter-request-form', compact('letterTypes'));
    }
}
