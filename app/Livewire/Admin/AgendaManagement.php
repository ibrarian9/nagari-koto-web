<?php

namespace App\Livewire\Admin;

use App\Models\Agenda;
use App\Services\ImageOptimizer;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class AgendaManagement extends Component
{
    use WithFileUploads;

    public bool $showForm = false;
    public ?int $editingId = null;

    #[Validate('required|string|max:255')]
    public string $title = '';
    #[Validate('nullable|string')]
    public string $description = '';
    #[Validate('nullable|string|max:255')]
    public string $location = '';
    #[Validate('required|date')]
    public string $start_date = '';
    #[Validate('nullable|date|after_or_equal:start_date')]
    public string $end_date = '';
    #[Validate('boolean')]
    public bool $is_public = true;
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $flyer = null;
    public ?string $existingFlyer = null;

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $m = Agenda::findOrFail($id);
        $this->editingId = $m->id;
        $this->title = $m->title;
        $this->description = $m->description ?? '';
        $this->location = $m->location ?? '';
        $this->start_date = $m->start_date->format('Y-m-d\TH:i');
        $this->end_date = $m->end_date?->format('Y-m-d\TH:i') ?? '';
        $this->is_public = $m->is_public;
        $this->existingFlyer = $m->flyer;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'title'       => $this->title,
            'description' => $this->description,
            'location'    => $this->location,
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date ?: null,
            'is_public'   => $this->is_public,
        ];

        if ($this->flyer) {
            $data['flyer'] = (new ImageOptimizer())->optimize($this->flyer, 'agendas', 'flyer');
        }

        if ($this->editingId) {
            Agenda::findOrFail($this->editingId)->update($data);
        } else {
            Agenda::create($data);
        }

        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Agenda berhasil disimpan.');
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        Agenda::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Agenda dihapus.');
    }

    public function removeFlyer(): void
    {
        $this->existingFlyer = null;
        if ($this->editingId) {
            Agenda::findOrFail($this->editingId)->update(['flyer' => null]);
        }
    }

    private function resetForm(): void
    {
        $this->reset([
            'showForm',
            'editingId',
            'title',
            'description',
            'location',
            'start_date',
            'end_date',
            'is_public',
            'flyer',
            'existingFlyer'
        ]);
        $this->is_public = true;
    }

    #[Layout('layouts.admin', ['title' => 'Agenda'])]
    public function render()
    {
        return view('livewire.admin.agenda-management', [
            'agendas' => Agenda::latest('start_date')->get(),
        ]);
    }
}
