<?php

namespace App\Livewire\Admin;

use App\Models\PpidKeberatan;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class PpidKeberatanManagement extends Component
{
    use WithPagination;

    public string $filterStatus = '';
    public string $search = '';
    public ?int $detailId = null;
    public string $catatan = '';
    public string $newStatus = '';

    public function showDetail(int $id): void
    {
        $item = PpidKeberatan::findOrFail($id);
        $this->detailId = $item->id;
        $this->catatan = $item->catatan_admin ?? '';
        $this->newStatus = $item->status;
    }

    public function updateStatus(): void
    {
        $item = PpidKeberatan::findOrFail($this->detailId);
        $item->update([
            'status'       => $this->newStatus,
            'catatan_admin' => $this->catatan,
        ]);
        $this->detailId = null;
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Status keberatan diperbarui.');
    }

    public function delete(int $id): void
    {
        PpidKeberatan::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Dihapus', text: 'Data keberatan dihapus.');
    }

    #[Layout('layouts.admin', ['title' => 'Pengajuan Keberatan PPID'])]
    public function render()
    {
        $query = PpidKeberatan::latest();
        if ($this->filterStatus) $query->where('status', $this->filterStatus);
        if ($this->search) $query->where(fn($q) => $q->where('nama', 'like', "%{$this->search}%")->orWhere('kode_registrasi', 'like', "%{$this->search}%"));

        return view('livewire.admin.ppid-keberatan-management', [
            'items' => $query->paginate(15),
        ]);
    }
}
