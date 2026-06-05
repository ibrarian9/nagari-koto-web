<?php

namespace App\Livewire\Admin;

use App\Models\PpidComment;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class PpidCommentManagement extends Component
{
    use WithPagination;

    public string $filterStatus = '';
    public string $search = '';

    public function approve(int $id): void
    {
        PpidComment::findOrFail($id)->update(['is_approved' => true]);
        $this->dispatch('swal', icon: 'success', title: 'Disetujui', text: 'Komentar berhasil disetujui.');
    }

    public function reject(int $id): void
    {
        PpidComment::findOrFail($id)->update(['is_approved' => false]);
    }

    public function delete(int $id): void
    {
        PpidComment::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Dihapus', text: 'Komentar dihapus.');
    }

    #[Layout('layouts.admin', ['title' => 'Komentar PPID'])]
    public function render()
    {
        $query = PpidComment::latest();
        if ($this->filterStatus === 'pending') $query->pending();
        elseif ($this->filterStatus === 'approved') $query->approved();
        if ($this->search) $query->where('nama', 'like', "%{$this->search}%");

        return view('livewire.admin.ppid-comment-management', [
            'items'        => $query->paginate(15),
            'pendingCount' => PpidComment::pending()->count(),
        ]);
    }
}
