<?php

namespace App\Livewire\PublicSite;

use App\Models\PbbRecord;
use Livewire\Component;
use Livewire\Attributes\Layout;

class PbbCheck extends Component
{
    public string $nop = '';
    public ?PbbRecord $result = null;
    public bool $searched = false;
    public string $errorMessage = '';

    public function search(): void
    {
        $this->errorMessage = '';
        $this->result = null;
        $this->searched = true;

        if (strlen($this->nop) < 5) {
            $this->errorMessage = 'Masukkan minimal 5 karakter NOP.';
            return;
        }

        $this->result = PbbRecord::query()->where('nop', $this->nop)->latest('tax_year')->first();

        if (!$this->result) {
            $this->errorMessage = 'Data PBB dengan NOP tersebut tidak ditemukan.';
        }
    }

    #[Layout('layouts.app', ['title' => 'Informasi PBB'])]
    public function render()
    {
        // Summary stats for the hero section
        $currentYear = (int) date('Y');
        $summary = [
            'total_wajib_pajak' => PbbRecord::forYear($currentYear)->count(),
            'total_lunas' => PbbRecord::forYear($currentYear)->paid()->count(),
            'total_belum_lunas' => PbbRecord::forYear($currentYear)->unpaid()->count(),
            'total_penerimaan' => PbbRecord::forYear($currentYear)->paid()->sum('tax_amount'),
        ];

        return view('livewire.public.pbb-check', compact('summary', 'currentYear'));
    }
}
