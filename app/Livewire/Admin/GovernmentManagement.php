<?php
namespace App\Livewire\Admin;

use App\Models\GovernmentMember;
use App\Services\ImageOptimizer;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class GovernmentManagement extends Component
{
    use WithFileUploads;

    public bool $showForm = false;
    public ?int $editingId = null;

    #[Validate('required|string|max:255')]
    public string $name = '';
    #[Validate('required|string|max:255')]
    public string $position = '';
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
        $m = GovernmentMember::findOrFail($id);
        $this->editingId = $m->id;
        $this->name = $m->name;
        $this->position = $m->position;
        $this->order = $m->order;
        $this->is_active = $m->is_active;
        $this->existingPhoto = $m->photo;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = ['name' => $this->name, 'position' => $this->position, 'order' => $this->order, 'is_active' => $this->is_active];
        if ($this->photo) { $data['photo'] = (new ImageOptimizer())->optimize($this->photo, 'government', 'avatar'); }
        if ($this->editingId) { GovernmentMember::findOrFail($this->editingId)->update($data); }
        else { GovernmentMember::create($data); }
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil disimpan.');
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        GovernmentMember::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil dihapus.');
    }

    public function moveUp(int $id): void { $m = GovernmentMember::findOrFail($id); if ($m->order > 0) { $m->update(['order' => $m->order - 1]); } }
    public function moveDown(int $id): void { $m = GovernmentMember::findOrFail($id); $m->update(['order' => $m->order + 1]); }

    private function resetForm(): void
    {
        $this->reset(['showForm','editingId','name','position','order','is_active','photo','existingPhoto']);
        $this->is_active = true;
    }

    public function render()
    {
        $members = GovernmentMember::ordered()->get();
        return view('livewire.admin.government-management', compact('members'))
            ->layout('layouts.admin', ['title' => 'Pemerintahan']);
    }
}
