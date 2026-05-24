<?php

namespace App\Livewire\Admin;

use App\Models\PpidPermohonan;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PpidPermohonanManagement extends Component
{
    use WithPagination, WithFileUploads;

    #[Url]
    public string $statusFilter = '';
    public ?int $viewingId = null;
    public string $updateStatus = '';
    public string $catatan = '';
    public $dokumenBalasan = null;

    public function view(int $id): void
    {
        $this->viewingId = $id;
        $r = PpidPermohonan::findOrFail($id);
        $this->updateStatus = $r->status;
        $this->catatan = $r->catatan_petugas ?? '';
    }

    public function updateRequest(): void
    {
        $this->validate([
            'updateStatus' => 'required|in:menunggu,diproses,selesai,ditolak',
            'catatan' => 'nullable|string|max:2000',
            'dokumenBalasan' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $r = PpidPermohonan::findOrFail($this->viewingId);
        $data = [
            'status' => $this->updateStatus,
            'catatan_petugas' => $this->catatan,
        ];

        if (in_array($this->updateStatus, ['selesai', 'ditolak'])) {
            $data['tanggal_selesai'] = now();
        }

        if ($this->dokumenBalasan) {
            if ($r->dokumen_balasan) Storage::disk('public')->delete($r->dokumen_balasan);
            $data['dokumen_balasan'] = $this->dokumenBalasan->store('ppid/balasan', 'public');
        }

        $r->update($data);
        $this->viewingId = null;
        $this->dokumenBalasan = null;
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Status permohonan diperbarui.');
    }

    #[Layout('layouts.admin', ['title' => 'PPID — Permohonan Informasi'])]
    public function render()
    {
        $requests = PpidPermohonan::query()
            ->when($this->statusFilter, fn($q) => $q->byStatus($this->statusFilter))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.ppid-permohonan-management', [
            'requests' => $requests,
            'overdueCount' => PpidPermohonan::overdue()->count(),
        ]);
    }
}
