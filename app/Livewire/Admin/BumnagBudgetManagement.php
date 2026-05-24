<?php

namespace App\Livewire\Admin;

use App\Models\BumnagBudget;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BumnagBudgetManagement extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;

    #[Validate('required|integer|min:2000|max:2100')]
    public int $year = 2024;
    #[Validate('required|integer|min:0')]
    public $total_income = 0;
    #[Validate('required|integer|min:0')]
    public $total_expenditure = 0;
    #[Validate('required|numeric|min:0|max:100')]
    public $realization_pct = 0;
    #[Validate('nullable|string')]
    public ?string $keterangan = '';
    public array $apbdes_rows = [];

    public function create(): void { $this->resetForm(); $this->showForm = true; }

    public function edit(int $id): void
    {
        $m = BumnagBudget::findOrFail($id);
        $this->editingId = $m->id;
        $this->fill($m->only(['year', 'total_income', 'total_expenditure', 'realization_pct', 'keterangan']));
        $this->apbdes_rows = collect($m->apbdes_data ?? [])->map(fn($v, $k) => ['label' => $k, 'value' => $v])->values()->toArray();
        $this->showForm = true;
    }

    public function addRow(): void { $this->apbdes_rows[] = ['label' => '', 'value' => 0]; }
    public function removeRow(int $i): void { unset($this->apbdes_rows[$i]); $this->apbdes_rows = array_values($this->apbdes_rows); }

    public function save(): void
    {
        $this->validate();
        $apbdes = collect($this->apbdes_rows)->pluck('value', 'label')->filter(fn($v, $k) => $k !== '')->toArray();
        $data = [
            'year' => $this->year,
            'total_income' => $this->total_income,
            'total_expenditure' => $this->total_expenditure,
            'realization_pct' => $this->realization_pct,
            'keterangan' => $this->keterangan,
            'apbdes_data' => json_encode($apbdes),
        ];
        if ($this->editingId) {
            BumnagBudget::findOrFail($this->editingId)->update($data);
        } else {
            BumnagBudget::create($data);
        }
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data anggaran BUMNag disimpan.');
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        BumnagBudget::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data dihapus.');
    }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'year', 'total_income', 'total_expenditure', 'realization_pct', 'keterangan', 'apbdes_rows']);
        $this->year = (int) date('Y');
    }

    public function render()
    {
        return view('livewire.admin.bumnag-budget-management', ['stats' => BumnagBudget::orderByDesc('year')->get()])
            ->layout('layouts.admin', ['title' => 'Anggaran BUMNag']);
    }
}
