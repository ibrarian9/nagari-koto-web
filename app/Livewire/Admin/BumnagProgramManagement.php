<?php

namespace App\Livewire\Admin;

use App\Models\BumnagProgram;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BumnagProgramManagement extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;

    #[Validate('required|string|max:255')]
    public string $nama_kegiatan = '';
    #[Validate('nullable|string|max:255')]
    public ?string $kepala_unit_usaha = '';
    #[Validate('nullable|string')]
    public ?string $keterangan = '';
    #[Validate('nullable|string')]
    public ?string $output_program = '';
    #[Validate('nullable|string')]
    public ?string $kendala = '';
    #[Validate('nullable|string|max:255')]
    public ?string $penerima_manfaat = '';
    #[Validate('nullable|integer|min:2000|max:2100')]
    public ?int $tahun = null;
    #[Validate('nullable|integer|min:0')]
    public int $order = 0;
    #[Validate('boolean')]
    public bool $is_active = true;

    public function create(): void { $this->resetForm(); $this->showForm = true; }

    public function edit(int $id): void
    {
        $m = BumnagProgram::findOrFail($id);
        $this->editingId = $m->id;
        $this->fill($m->only(['nama_kegiatan', 'kepala_unit_usaha', 'keterangan', 'output_program', 'kendala', 'penerima_manfaat', 'tahun', 'order', 'is_active']));
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'nama_kegiatan' => $this->nama_kegiatan,
            'kepala_unit_usaha' => $this->kepala_unit_usaha,
            'keterangan' => $this->keterangan,
            'output_program' => $this->output_program,
            'kendala' => $this->kendala,
            'penerima_manfaat' => $this->penerima_manfaat,
            'tahun' => $this->tahun,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ];
        if ($this->editingId) {
            BumnagProgram::findOrFail($this->editingId)->update($data);
        } else {
            BumnagProgram::create($data);
        }
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Program kerja berhasil disimpan.');
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        BumnagProgram::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data dihapus.');
    }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'nama_kegiatan', 'kepala_unit_usaha', 'keterangan', 'output_program', 'kendala', 'penerima_manfaat', 'tahun', 'order', 'is_active']);
        $this->is_active = true;
        $this->tahun = (int) date('Y');
    }

    public function render()
    {
        return view('livewire.admin.bumnag-program-management', ['programs' => BumnagProgram::ordered()->get()])
            ->layout('layouts.admin', ['title' => 'Program Kerja BUMNag']);
    }
}
