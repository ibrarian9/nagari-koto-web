<?php
namespace App\Livewire\Admin;

use App\Models\VillageProfile;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class VillageProfileForm extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255', message: 'Nama desa wajib diisi.')]
    public string $name = '';
    #[Validate('nullable|string|max:255')]
    public ?string $tagline = '';
    #[Validate('nullable|string')]
    public ?string $history = '';
    #[Validate('nullable|string')]
    public ?string $vision = '';
    #[Validate('nullable|string')]
    public ?string $mission = '';
    #[Validate('nullable|string|max:500')]
    public ?string $address = '';
    #[Validate('nullable|string|max:100')]
    public ?string $province = '';
    #[Validate('nullable|string|max:100')]
    public ?string $regency = '';
    #[Validate('nullable|string|max:100')]
    public ?string $district = '';
    #[Validate('nullable|string|max:50')]
    public ?string $village_code = '';
    #[Validate('nullable|numeric|min:0')]
    public $area_ha = null;
    #[Validate('nullable|integer|min:1000|max:2100')]
    public $established_year = null;
    #[Validate('nullable|string|max:1000')]
    public ?string $map_embed_url = '';
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $newPhoto = null;
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048', message: [
        'newLogo.image' => 'File logo harus berupa gambar.',
        'newLogo.mimes' => 'Format logo harus JPG, PNG, atau WebP.',
        'newLogo.max' => 'Ukuran logo maksimal 2MB.',
    ])]
    public $newLogo = null;
    public ?string $croppedBannerData = null;

    public function mount(): void
    {
        $profile = VillageProfile::first();
        if ($profile) {
            $this->fill($profile->only([
                'name','tagline','history','vision','mission','address','province',
                'regency','district','village_code','area_ha','established_year','map_embed_url'
            ]));
        }
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'name' => $this->name, 'tagline' => $this->tagline, 'history' => $this->history,
            'vision' => $this->vision, 'mission' => $this->mission, 'address' => $this->address,
            'province' => $this->province, 'regency' => $this->regency, 'district' => $this->district,
            'village_code' => $this->village_code, 'area_ha' => $this->area_ha,
            'established_year' => $this->established_year, 'map_embed_url' => $this->map_embed_url,
        ];

        // Handle cropped banner (base64)
        if ($this->croppedBannerData) {
            $data['photo'] = $this->saveCroppedBanner($this->croppedBannerData);
        } elseif ($this->newPhoto) {
            $data['photo'] = $this->newPhoto->store('village', 'public');
        }

        if ($this->newLogo) { $data['logo'] = $this->newLogo->store('village', 'public'); }

        VillageProfile::updateOrCreate(['id' => 1], $data);
        $this->croppedBannerData = null;
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Profil desa berhasil diperbarui.');
    }

    private function saveCroppedBanner(string $dataUrl): string
    {
        // Parse base64 data URL
        $data = explode(',', $dataUrl, 2);
        $imageData = base64_decode($data[1]);

        $filename = 'village/banner_' . time() . '.jpg';
        Storage::disk('public')->put($filename, $imageData);

        return $filename;
    }

    public function render()
    {
        return view('livewire.admin.village-profile-form')
            ->layout('layouts.admin', ['title' => 'Profil Desa']);
    }
}
