<?php

namespace App\Livewire\Admin;

use App\Models\BamusMember;
use App\Services\ImageOptimizer;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class BamusManagement extends Component
{
    use WithFileUploads;

    public bool $showForm = false;
    public ?int $editingId = null;

    #[Validate('required|string|max:255')]
    public string $name = '';
    #[Validate('required|string|max:255')]
    public string $position = '';
    #[Validate('nullable|string|max:100')]
    public ?string $period = '';
    #[Validate('nullable|integer|min:0')]
    public int $order = 0;
    #[Validate('boolean')]
    public bool $is_active = true;
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $photo = null;
    public ?string $existingPhoto = null;

    public function create(): void { $this->resetForm(); $this->showForm = true; }

    public function edit(int $id): void
    {
        $m = BamusMember::findOrFail($id);
        $this->editingId = $m->id;
        $this->fill($m->only(['name', 'position', 'period', 'order', 'is_active']));
        $this->existingPhoto = $m->photo;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = ['name' => $this->name, 'position' => $this->position, 'period' => $this->period, 'order' => $this->order, 'is_active' => $this->is_active];
        if ($this->photo) { $data['photo'] = (new ImageOptimizer())->optimize($this->photo, 'bamus', 'avatar'); }
        if ($this->editingId) { BamusMember::findOrFail($this->editingId)->update($data); }
        else { BamusMember::create($data); }
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil disimpan.');
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        BamusMember::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil dihapus.');
    }

    public function moveUp(int $id): void { $m = BamusMember::findOrFail($id); if ($m->order > 0) $m->update(['order' => $m->order - 1]); }
    public function moveDown(int $id): void { $m = BamusMember::findOrFail($id); $m->update(['order' => $m->order + 1]); }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'name', 'position', 'period', 'order', 'is_active', 'photo', 'existingPhoto']);
        $this->is_active = true;
    }

    public function render()
    {
        $members = BamusMember::ordered()->get();
        return view('livewire.admin.bamus-management', compact('members'))
            ->layout('layouts.admin', ['title' => 'BAMUS Nagari']);
    }
}
