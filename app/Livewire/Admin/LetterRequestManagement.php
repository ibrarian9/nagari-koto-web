<?php
namespace App\Livewire\Admin;
use App\Models\LetterRequest;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class LetterRequestManagement extends Component
{
    use WithPagination;
    #[Url] public string $statusFilter = '';
    public ?int $viewingId = null;
    public string $updateStatus = '';
    public string $updateNotes = '';

    public function view(int $id): void { $this->viewingId = $id; $r = LetterRequest::findOrFail($id); $this->updateStatus = $r->status; $this->updateNotes = $r->notes ?? ''; }
    public function updateRequest(): void { $r = LetterRequest::findOrFail($this->viewingId); $r->update(['status'=>$this->updateStatus,'notes'=>$this->updateNotes,'processed_at'=>in_array($this->updateStatus,['ready','rejected']) ? now() : $r->processed_at]); $this->viewingId = null; $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Status surat diperbarui.'); }
    public function render() {
        $requests = LetterRequest::with('user')->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))->latest()->paginate(15);
        return view('livewire.admin.letter-request-management', compact('requests'))->layout('layouts.admin', ['title' => 'Permohonan Surat']);
    }
}
