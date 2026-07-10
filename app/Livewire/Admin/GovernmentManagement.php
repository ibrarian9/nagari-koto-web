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
    #[Validate('nullable|string|max:50')]
    public string $nip = '';
    #[Validate('nullable|string|max:100')]
    public string $place_of_birth = '';
    #[Validate('nullable|date')]
    public ?string $date_of_birth = null;
    #[Validate('nullable|integer|min:0')]
    public int $order = 0;
    #[Validate('boolean')]
    public bool $is_active = true;
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $photo = null;
    public ?string $existingPhoto = null;

    // JSON arrays for education & position history
    public array $education_rows = [];
    public array $position_rows = [];

    public function create(): void { $this->resetForm(); $this->showForm = true; }
    public function edit(int $id): void
    {
        $m = GovernmentMember::findOrFail($id);
        $this->editingId = $m->id;
        $this->name = $m->name;
        $this->position = $m->position;
        $this->nip = $m->nip ?? '';
        $this->place_of_birth = $m->place_of_birth ?? '';
        $this->date_of_birth = $m->date_of_birth?->format('Y-m-d');
        $this->order = $m->order;
        $this->is_active = $m->is_active;
        $this->existingPhoto = $m->photo;
        $this->education_rows = $m->education_history ?? [];
        $this->position_rows = $m->position_history ?? [];
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'name' => $this->name,
            'position' => $this->position,
            'nip' => $this->nip ?: null,
            'place_of_birth' => $this->place_of_birth ?: null,
            'date_of_birth' => $this->date_of_birth ?: null,
            'order' => $this->order,
            'is_active' => $this->is_active,
            'education_history' => array_values(array_filter($this->education_rows, fn($r) => !empty($r['institution']))),
            'position_history' => array_values(array_filter($this->position_rows, fn($r) => !empty($r['position']))),
        ];
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

    // Education rows
    public function addEducationRow(): void { $this->education_rows[] = ['level' => '', 'institution' => '', 'major' => '', 'year' => '']; }
    public function removeEducationRow(int $i): void { unset($this->education_rows[$i]); $this->education_rows = array_values($this->education_rows); }

    // Position rows
    public function addPositionRow(): void { $this->position_rows[] = ['period' => '', 'position' => '', 'institution' => '']; }
    public function removePositionRow(int $i): void { unset($this->position_rows[$i]); $this->position_rows = array_values($this->position_rows); }

    private function resetForm(): void
    {
        $this->reset(['showForm','editingId','name','position','nip','place_of_birth','date_of_birth','order','is_active','photo','existingPhoto','education_rows','position_rows']);
        $this->is_active = true;
    }

    public function render()
    {
        $members = GovernmentMember::ordered()->get();
        return view('livewire.admin.government-management', compact('members'))
            ->layout('layouts.admin', ['title' => 'Pemerintahan']);
    }
}
