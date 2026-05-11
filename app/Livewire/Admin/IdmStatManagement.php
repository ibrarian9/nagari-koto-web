<?php
namespace App\Livewire\Admin;
use App\Models\IdmStat;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class IdmStatManagement extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;
    #[Validate('required|integer|min:2000|max:2100')] public int $year = 2024;
    #[Validate('required|numeric|min:0|max:1')] public $score = 0;
    #[Validate('required|in:sangat_tertinggal,tertinggal,berkembang,maju,mandiri')] public string $status = 'berkembang';
    #[Validate('required|numeric|min:0|max:1')] public $social_score = 0;
    #[Validate('required|numeric|min:0|max:1')] public $economic_score = 0;
    #[Validate('required|numeric|min:0|max:1')] public $environment_score = 0;
    #[Validate('nullable|string')] public string $notes = '';

    public function create(): void { $this->resetForm(); $this->showForm = true; }
    public function edit(int $id): void { $m = IdmStat::findOrFail($id); $this->editingId = $m->id; $this->fill($m->only(['year','score','status','social_score','economic_score','environment_score'])); $this->notes = $m->notes ?? ''; $this->showForm = true; }
    public function save(): void { $this->validate(); $data = ['year'=>$this->year,'score'=>$this->score,'status'=>$this->status,'social_score'=>$this->social_score,'economic_score'=>$this->economic_score,'environment_score'=>$this->environment_score,'notes'=>$this->notes]; if ($this->editingId) IdmStat::findOrFail($this->editingId)->update($data); else IdmStat::create($data); $this->resetForm(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data IDM disimpan.'); }
    #[On('deleteConfirmed')]
    public function delete(int $id): void { IdmStat::findOrFail($id)->delete(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data IDM dihapus.'); }
    private function resetForm(): void { $this->reset(['showForm','editingId','year','score','status','social_score','economic_score','environment_score','notes']); $this->year = (int) date('Y'); $this->status = 'berkembang'; }
    public function render() { return view('livewire.admin.idm-stat-management', ['stats' => IdmStat::orderByDesc('year')->get()])->layout('layouts.admin', ['title' => 'IDM']); }
}
