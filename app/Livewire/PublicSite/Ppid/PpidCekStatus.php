<?php

namespace App\Livewire\PublicSite\Ppid;

use App\Models\PpidPermohonan;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PpidCekStatus extends Component
{
    public string $nomor_permohonan = '';
    public ?PpidPermohonan $result = null;
    public bool $searched = false;
    public string $errorMessage = '';

    public function cekStatus(): void
    {
        $this->validate([
            'nomor_permohonan' => 'required|string',
        ], [
            'nomor_permohonan.required' => 'Masukkan nomor permohonan Anda.',
        ]);

        $this->result = PpidPermohonan::where('nomor_permohonan', $this->nomor_permohonan)->first();
        $this->searched = true;
        $this->errorMessage = $this->result ? '' : 'Nomor permohonan tidak ditemukan. Pastikan nomor yang dimasukkan benar.';
    }

    #[Layout('layouts.app', ['title' => 'Cek Status Permohonan — PPID'])]
    public function render()
    {
        return view('livewire.public.ppid.cek-status');
    }
}
