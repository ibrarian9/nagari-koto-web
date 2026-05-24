<?php

namespace App\Livewire\Admin;

use App\Models\BumnagProfile;
use App\Services\ImageOptimizer;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class BumnagProfileManagement extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = '';
    #[Validate('nullable|string')]
    public ?string $description = '';
    #[Validate('nullable|string')]
    public ?string $sejarah = '';
    #[Validate('nullable|string')]
    public ?string $visi = '';
    #[Validate('nullable|string')]
    public ?string $misi = '';
    #[Validate('nullable|string|max:255')]
    public ?string $alamat = '';
    #[Validate('nullable|string|max:50')]
    public ?string $telepon = '';
    #[Validate('nullable|email|max:255')]
    public ?string $email = '';

    // Badan Hukum
    #[Validate('nullable|string|max:255')]
    public ?string $sk_pendirian = '';
    #[Validate('nullable|date')]
    public ?string $tanggal_pendirian = '';

    // File uploads
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $logo = null;
    public ?string $existingLogo = null;

    #[Validate('nullable|file|mimes:pdf|max:10240')]
    public $badan_hukum_file_upload = null;
    public ?string $existingBadanHukum = null;

    // Unit Usaha (dynamic list)
    public array $units = [];

    public function mount(): void
    {
        $p = BumnagProfile::getContent();
        $this->fill($p->only([
            'name', 'description', 'sejarah', 'visi', 'misi',
            'alamat', 'telepon', 'email',
            'sk_pendirian',
        ]));
        $this->tanggal_pendirian = $p->tanggal_pendirian?->format('Y-m-d');
        $this->existingLogo = $p->logo;
        $this->existingBadanHukum = $p->badan_hukum_file;
        $this->units = $p->unit_usaha ?? [];
    }

    public function addUnit(): void
    {
        $this->units[] = ['nama' => '', 'deskripsi' => ''];
    }

    public function removeUnit(int $index): void
    {
        unset($this->units[$index]);
        $this->units = array_values($this->units);
    }

    public function save(): void
    {
        $this->validate();

        $profile = BumnagProfile::getContent();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'sejarah' => $this->sejarah,
            'visi' => $this->visi,
            'misi' => $this->misi,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'sk_pendirian' => $this->sk_pendirian,
            'tanggal_pendirian' => $this->tanggal_pendirian ?: null,
            'unit_usaha' => array_filter($this->units, fn($u) => !empty($u['nama'])),
        ];

        if ($this->logo) {
            $data['logo'] = (new ImageOptimizer())->optimize($this->logo, 'bumnag', 'logo');
        }

        if ($this->badan_hukum_file_upload) {
            $data['badan_hukum_file'] = $this->badan_hukum_file_upload->store('bumnag/dokumen', 'public');
        }

        $profile->update($data);

        $this->existingLogo = $profile->logo;
        $this->existingBadanHukum = $profile->badan_hukum_file;
        $this->reset(['logo', 'badan_hukum_file_upload']);

        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Profil BUMNag berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.admin.bumnag-profile-management')
            ->layout('layouts.admin', ['title' => 'BUMNag Profil']);
    }
}
