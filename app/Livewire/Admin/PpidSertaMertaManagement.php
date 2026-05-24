<?php

namespace App\Livewire\Admin;

use App\Models\PpidSertaMerta;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class PpidSertaMertaManagement extends Component
{
    use WithPagination;

    public bool $showForm = false;
    public ?int $editingId = null;
    public string $search = '';

    public string $title = '';
    public string $content = '';
    public string $urgency = 'rendah';
    public bool $is_active = true;

    public function create(): void { $this->resetForm(); $this->showForm = true; }

    public function edit(int $id): void
    {
        $item = PpidSertaMerta::findOrFail($id);
        $this->editingId = $id;
        $this->title = $item->title;
        $this->content = $item->content;
        $this->urgency = $item->urgency;
        $this->is_active = $item->is_active;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'urgency' => 'required|in:rendah,sedang,tinggi,kritis',
            'is_active' => 'required|boolean',
        ]);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'urgency' => $this->urgency,
            'is_active' => $this->is_active,
            'published_at' => $this->is_active ? now() : null,
        ];

        $this->editingId ? PpidSertaMerta::findOrFail($this->editingId)->update($data) : PpidSertaMerta::create($data);
        $this->showForm = false;
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data disimpan.');
    }

    public function delete(int $id): void
    {
        PpidSertaMerta::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data dihapus.');
    }

    private function resetForm(): void
    {
        $this->editingId = null; $this->title = ''; $this->content = '';
        $this->urgency = 'rendah'; $this->is_active = true;
    }

    #[Layout('layouts.admin', ['title' => 'PPID — Informasi Serta Merta'])]
    public function render()
    {
        $items = PpidSertaMerta::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->latest()->paginate(15);

        return view('livewire.admin.ppid-serta-merta-management', ['items' => $items]);
    }
}
