<?php

namespace App\Livewire\PublicSite\Ppid;

use App\Models\PpidSertaMerta as PpidSertaMertaModel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PpidSertaMerta extends Component
{
    use WithPagination;

    #[Url]
    public string $urgency = '';

    public function updatingUrgency(): void { $this->resetPage(); }

    #[Layout('layouts.app', ['title' => 'Informasi Serta Merta — PPID'])]
    public function render()
    {
        $items = PpidSertaMertaModel::active()
            ->when($this->urgency, fn($q) => $q->byUrgency($this->urgency))
            ->latest('published_at')
            ->paginate(15);

        return view('livewire.public.ppid.serta-merta', [
            'items' => $items,
            'urgencyLevels' => PpidSertaMertaModel::URGENCY_LEVELS,
        ]);
    }
}
