<?php
namespace App\Livewire\Admin;
use App\Models\BudgetStat;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BudgetStatManagement extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;
    #[Validate('required|integer|min:2000|max:2100')] public int $year = 2024;
    #[Validate('required|integer|min:0')] public $total_income = 0;
    #[Validate('required|integer|min:0')] public $total_expenditure = 0;
    #[Validate('required|numeric|min:0|max:100')] public $realization_pct = 0;
    public array $apbnag_rows = [];

    public function create(): void { $this->resetForm(); $this->showForm = true; }
    public function edit(int $id): void {
        $m = BudgetStat::findOrFail($id);
        $this->editingId = $m->id;
        $this->fill($m->only(['year','total_income','total_expenditure','realization_pct']));
        $data = is_string($m->apbdes_data) ? json_decode($m->apbdes_data, true) : ($m->apbdes_data ?? []);
        $this->apbnag_rows = collect($data)->map(fn($v,$k)=>['label'=>$k,'value'=>$v])->values()->toArray();
        $this->showForm = true;
    }
    public function addRow(): void { $this->apbnag_rows[] = ['label'=>'','value'=>0]; }
    public function removeRow(int $i): void { unset($this->apbnag_rows[$i]); $this->apbnag_rows = array_values($this->apbnag_rows); }
    public function save(): void {
        $this->validate();
        $apbdes = collect($this->apbnag_rows)->pluck('value','label')->filter(fn($v,$k)=>$k!=='')->toArray();
        $data = [
            'year'=>$this->year,
            'total_income'=>$this->total_income,
            'total_expenditure'=>$this->total_expenditure,
            'realization_pct'=>$this->realization_pct,
            'apbdes_data'=>$apbdes
        ];
        if ($this->editingId) BudgetStat::findOrFail($this->editingId)->update($data);
        else BudgetStat::create($data);
        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data anggaran disimpan.');
    }
    #[On('deleteConfirmed')]
    public function delete(int $id): void { BudgetStat::findOrFail($id)->delete(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data dihapus.'); }
    private function resetForm(): void { $this->reset(['showForm','editingId','year','total_income','total_expenditure','realization_pct','apbnag_rows']); $this->year = (int) date('Y'); }
    public function render() { return view('livewire.admin.budget-stat-management', ['stats' => BudgetStat::orderByDesc('year')->get()])->layout('layouts.admin', ['title' => 'Anggaran']); }
}
