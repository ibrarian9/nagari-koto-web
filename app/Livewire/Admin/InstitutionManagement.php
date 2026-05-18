<?php

namespace App\Livewire\Admin;

use App\Models\VillageInstitution;
use App\Services\ImageOptimizer;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class InstitutionManagement extends Component
{
    use WithFileUploads;

    public bool $showForm = false;
    public ?int $editingId = null;

    #[Validate('required|string|max:255')]
    public string $name = '';
    #[Validate('required|in:adat,kepemudaan,perempuan,keagamaan,sosial,pendidikan,lainnya')]
    public string $type = 'lainnya';
    #[Validate('nullable|string|max:255')]
    public ?string $head_name = '';
    #[Validate('nullable|string')]
    public ?string $description = '';
    #[Validate('nullable|string|max:255')]
    public ?string $contact = '';
    #[Validate('nullable|integer|min:1900|max:2100')]
    public $established_year = null;
    #[Validate('nullable|integer|min:0')]
    public int $order = 0;
    #[Validate('boolean')]
    public bool $is_active = true;
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $logo = null;
    public ?string $existingLogo = null;

    public function create(): void { $this->resetForm(); $this->showForm = true; }

    public function edit(int $id): void
    {
        $m = VillageInstitution::findOrFail($id);
        $this->editingId = $m->id;
        $this->fill($m->only(['name', 'type', 'head_name', 'description', 'contact', 'established_year', 'order', 'is_active']));
        $this->existingLogo = $m->logo;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'name' => $this->name, 'type' => $this->type, 'head_name' => $this->head_name,
            'description' => $this->description, 'contact' => $this->contact,
            'established_year' => $this->established_year, 'order' => $this->order, 'is_active' => $this->is_active,
        ];
        if ($this->logo) { $data['logo'] = (new ImageOptimizer())->optimize($this->logo, 'institutions', 'logo'); }
        if ($this->editingId) { VillageInstitution::findOrFail($this->editingId)->update($data); }
        else { VillageInstitution::create($data); }
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil disimpan.');
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        VillageInstitution::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil dihapus.');
    }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'name', 'type', 'head_name', 'description', 'contact', 'established_year', 'order', 'is_active', 'logo', 'existingLogo']);
        $this->is_active = true;
        $this->type = 'lainnya';
    }

    public function render()
    {
        $institutions = VillageInstitution::ordered()->get();
        return view('livewire.admin.institution-management', compact('institutions'))
            ->layout('layouts.admin', ['title' => 'Lembaga Nagari']);
    }
}
