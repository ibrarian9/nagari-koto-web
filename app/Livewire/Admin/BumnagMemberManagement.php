<?php

namespace App\Livewire\Admin;

use App\Models\BumnagMember;
use App\Services\ImageOptimizer;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class BumnagMemberManagement extends Component
{
    use WithFileUploads;

    public bool $showForm = false;
    public ?int $editingId = null;

    #[Validate('required|string|max:255')]
    public string $name = '';
    #[Validate('required|string|max:255')]
    public string $position = '';
    #[Validate('required|in:pengurus,pengawas')]
    public string $role_type = 'pengurus';
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
        $m = BumnagMember::findOrFail($id);
        $this->editingId = $m->id;
        $this->fill($m->only(['name', 'position', 'role_type', 'period', 'order', 'is_active']));
        $this->existingPhoto = $m->photo;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'name' => $this->name,
            'position' => $this->position,
            'role_type' => $this->role_type,
            'period' => $this->period,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ];
        if ($this->photo) {
            $data['photo'] = (new ImageOptimizer())->optimize($this->photo, 'bumnag', 'avatar');
        }
        if ($this->editingId) {
            BumnagMember::findOrFail($this->editingId)->update($data);
        } else {
            BumnagMember::create($data);
        }
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil disimpan.');
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        BumnagMember::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil dihapus.');
    }

    public function moveUp(int $id): void { $m = BumnagMember::findOrFail($id); if ($m->order > 0) $m->update(['order' => $m->order - 1]); }
    public function moveDown(int $id): void { $m = BumnagMember::findOrFail($id); $m->update(['order' => $m->order + 1]); }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'name', 'position', 'role_type', 'period', 'order', 'is_active', 'photo', 'existingPhoto']);
        $this->is_active = true;
        $this->role_type = 'pengurus';
    }

    public function render()
    {
        $members = BumnagMember::ordered()->get();
        return view('livewire.admin.bumnag-member-management', compact('members'))
            ->layout('layouts.admin', ['title' => 'BUMNag Anggota']);
    }
}
