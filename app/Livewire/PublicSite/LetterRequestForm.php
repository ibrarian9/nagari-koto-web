<?php
namespace App\Livewire\PublicSite;

use App\Models\LetterRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class LetterRequestForm extends Component
{
    use WithFileUploads;

    public string $letter_type = '';
    public string $full_name = '';
    public string $nik = '';
    public string $address = '';
    public string $purpose = '';
    public $ktp_image = null;
    public $ktp_image_2 = null;
    public $nikah_form_image = null;
    public bool $submitted = false;

    /**
     * Dynamic validation rules based on letter type.
     */
    public function rules(): array
    {
        $rules = [
            'letter_type' => 'required|in:surat_domisili,surat_tidak_mampu,surat_keterangan_usaha,surat_keterangan_lahir,surat_kematian,surat_pengantar_nikah',
            'full_name' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'address' => 'required|string|max:500',
            'purpose' => 'nullable|string|max:1000',
            'ktp_image' => 'required|image|max:2048',
        ];

        if ($this->letter_type === 'surat_pengantar_nikah') {
            $rules['ktp_image_2'] = 'required|image|max:2048';
            $rules['nikah_form_image'] = 'required|image|max:4096';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'ktp_image.required' => 'Foto KTP wajib diunggah.',
            'ktp_image.image' => 'File harus berupa gambar (JPG, PNG, dll).',
            'ktp_image.max' => 'Ukuran foto maks. 2MB.',
            'ktp_image_2.required' => 'Foto KTP Calon Mempelai Wanita wajib diunggah.',
            'ktp_image_2.image' => 'File harus berupa gambar.',
            'ktp_image_2.max' => 'Ukuran foto maks. 2MB.',
            'nikah_form_image.required' => 'Foto formulir nikah wajib diunggah.',
            'nikah_form_image.image' => 'File harus berupa gambar.',
            'nikah_form_image.max' => 'Ukuran foto formulir maks. 4MB.',
        ];
    }

    /**
     * Reset upload fields when letter type changes.
     */
    public function updatedLetterType(): void
    {
        if ($this->letter_type !== 'surat_pengantar_nikah') {
            $this->ktp_image_2 = null;
            $this->nikah_form_image = null;
        }
    }

    public function submit(): void
    {
        $this->validate();

        $data = [
            'user_id' => auth()->id(),
            'letter_type' => $this->letter_type,
            'full_name' => $this->full_name,
            'nik' => $this->nik,
            'address' => $this->address,
            'purpose' => $this->purpose,
            'ktp_image' => $this->ktp_image->store('ktp', 'public'),
            'status' => 'pending',
            'requested_at' => now(),
        ];

        if ($this->letter_type === 'surat_pengantar_nikah') {
            $data['ktp_image_2'] = $this->ktp_image_2->store('ktp', 'public');
            $data['nikah_form_image'] = $this->nikah_form_image->store('nikah-forms', 'public');
        }

        LetterRequest::create($data);

        $this->submitted = true;
    }

    /**
     * Check if nikah form template exists.
     */
    public function hasNikahTemplate(): bool
    {
        return file_exists(storage_path('app/public/templates/formulir-nikah-n1.pdf'));
    }

    #[Layout('layouts.app', ['title' => 'Ajukan Surat'])]
    public function render()
    {
        $letterTypes = config('letters.types', []);
        return view('livewire.public.letter-request-form', [
            'letterTypes' => $letterTypes,
            'isNikah' => $this->letter_type === 'surat_pengantar_nikah',
            'hasTemplate' => $this->hasNikahTemplate(),
        ]);
    }
}
