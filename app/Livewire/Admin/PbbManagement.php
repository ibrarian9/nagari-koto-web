<?php
namespace App\Livewire\Admin;
use App\Models\PbbRecord;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class PbbManagement extends Component
{
    use WithPagination;
    public bool $showForm = false;
    public ?int $editingId = null;
    #[Url(as: 'q')] public string $search = '';
    #[Url] public string $yearFilter = '';
    #[Url] public string $statusFilter = '';

    #[Validate('required|string|max:30')] public string $nop = '';
    #[Validate('required|string|max:255')] public string $taxpayer_name = '';
    #[Validate('nullable|string')] public string $address = '';
    #[Validate('required|numeric|min:0')] public $land_area = 0;
    #[Validate('required|numeric|min:0')] public $building_area = 0;
    #[Validate('required|integer|min:0')] public $njop = 0;
    #[Validate('required|integer|min:0')] public $tax_amount = 0;
    #[Validate('required|integer|min:2000|max:2100')] public int $tax_year = 2024;
    #[Validate('required|in:unpaid,paid')] public string $status = 'unpaid';

    public function create(): void { $this->resetForm(); $this->showForm = true; }
    public function edit(int $id): void { $m = PbbRecord::findOrFail($id); $this->editingId = $m->id; $this->fill($m->only(['nop','taxpayer_name','address','land_area','building_area','njop','tax_amount','tax_year','status'])); $this->address = $this->address ?? ''; $this->showForm = true; }
    public function save(): void { $this->validate(); $data = ['nop'=>$this->nop,'taxpayer_name'=>$this->taxpayer_name,'address'=>$this->address,'land_area'=>$this->land_area,'building_area'=>$this->building_area,'njop'=>$this->njop,'tax_amount'=>$this->tax_amount,'tax_year'=>$this->tax_year,'status'=>$this->status]; if ($this->status === 'paid') $data['paid_at'] = now(); if ($this->editingId) PbbRecord::findOrFail($this->editingId)->update($data); else PbbRecord::create($data); $this->resetForm(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data PBB disimpan.'); }
    #[On('markPaidConfirmed')]
    public function markPaid(int $id): void { PbbRecord::findOrFail($id)->update(['status'=>'paid','paid_at'=>now()]); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'PBB ditandai lunas.'); }
    #[On('deleteConfirmed')]
    public function delete(int $id): void { PbbRecord::findOrFail($id)->delete(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data PBB dihapus.'); }
    private function resetForm(): void { $this->reset(['showForm','editingId','nop','taxpayer_name','address','land_area','building_area','njop','tax_amount','tax_year','status']); $this->tax_year = (int) date('Y'); $this->status = 'unpaid'; }
    public function render() {
        $records = PbbRecord::when($this->search, fn($q) => $q->where('nop','like',"%{$this->search}%")->orWhere('taxpayer_name','like',"%{$this->search}%"))
            ->when($this->yearFilter, fn($q) => $q->forYear((int)$this->yearFilter))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->latest()->paginate(15);
        $summary = ['total'=>PbbRecord::count(),'paid'=>PbbRecord::paid()->count(),'unpaid'=>PbbRecord::unpaid()->count(),'total_amount'=>PbbRecord::forYear((int)($this->yearFilter ?: date('Y')))->sum('tax_amount')];
        return view('livewire.admin.pbb-management', compact('records','summary'))->layout('layouts.admin', ['title' => 'PBB']);
    }
}
