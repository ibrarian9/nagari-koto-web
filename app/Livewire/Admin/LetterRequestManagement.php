<?php
namespace App\Livewire\Admin;
use App\Models\LetterRequest;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class LetterRequestManagement extends Component
{
    use WithPagination, WithFileUploads;

    #[Url] public string $statusFilter = '';
    public ?int $viewingId = null;
    public string $updateStatus = '';
    public string $updateNotes = '';

    /** Template nikah form upload */
    public $nikahTemplate = null;

    public function view(int $id): void
    {
        $this->viewingId = $id;
        $r = LetterRequest::findOrFail($id);
        $this->updateStatus = $r->status;
        $this->updateNotes = $r->notes ?? '';
    }

    public function updateRequest(): void
    {
        $r = LetterRequest::findOrFail($this->viewingId);
        $r->update([
            'status' => $this->updateStatus,
            'notes' => $this->updateNotes,
            'processed_at' => in_array($this->updateStatus, ['ready', 'rejected']) ? now() : $r->processed_at,
        ]);
        $this->viewingId = null;
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Status surat diperbarui.');
    }

    /**
     * Upload or replace the nikah form template PDF.
     */
    public function uploadTemplate(): void
    {
        $this->validate([
            'nikahTemplate' => 'required|file|mimes:pdf|max:5120',
        ], [
            'nikahTemplate.required' => 'Pilih file PDF terlebih dahulu.',
            'nikahTemplate.mimes' => 'File harus berformat PDF.',
            'nikahTemplate.max' => 'Ukuran file maks. 5MB.',
        ]);

        // Ensure directory exists
        Storage::disk('public')->makeDirectory('templates');

        // Store with fixed name so public URL is stable
        $this->nikahTemplate->storeAs('templates', 'formulir-nikah-n1.pdf', 'public');

        $this->nikahTemplate = null;
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Template formulir nikah berhasil diupload.');
    }

    /**
     * Delete the nikah form template.
     */
    public function deleteTemplate(): void
    {
        Storage::disk('public')->delete('templates/formulir-nikah-n1.pdf');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Template formulir nikah dihapus.');
    }

    public function hasNikahTemplate(): bool
    {
        return Storage::disk('public')->exists('templates/formulir-nikah-n1.pdf');
    }

    #[Layout('layouts.admin', ['title' => 'Permohonan Surat'])]
    public function render()
    {
        $requests = LetterRequest::with('user')
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.letter-request-management', [
            'requests' => $requests,
            'templateExists' => $this->hasNikahTemplate(),
        ]);
    }
}
