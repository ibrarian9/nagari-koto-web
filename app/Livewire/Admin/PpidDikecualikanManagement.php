<?php

namespace App\Livewire\Admin;

use App\Models\PpidDikecualikan;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PpidDikecualikanManagement extends Component
{
    public string $content = '';

    public function mount(): void
    {
        $this->content = PpidDikecualikan::getContent()->content;
    }

    public function save(): void
    {
        $this->validate(['content' => 'required|string']);

        $record = PpidDikecualikan::getContent();
        $record->update([
            'content' => $this->content,
            'updated_by' => auth()->id(),
        ]);

        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Konten diperbarui.');
    }

    #[Layout('layouts.admin', ['title' => 'PPID — Informasi Dikecualikan'])]
    public function render()
    {
        return view('livewire.admin.ppid-dikecualikan-management');
    }
}
