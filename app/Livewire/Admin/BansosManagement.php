<?php
namespace App\Livewire\Admin;
use App\Models\BansosProgram;
use App\Models\BansosRecipient;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class BansosManagement extends Component
{
    use WithPagination;
    public bool $showForm = false;
    public ?int $editingId = null;
    public string $search = '';
    #[Validate('required|digits:16')] public string $nik = '';
    #[Validate('required|string|max:255')] public string $full_name = '';
    #[Validate('nullable|string')] public string $address = '';
    #[Validate('required|string|max:255')] public string $program_name = '';
    #[Validate('nullable|string|max:100')] public string $program_type = '';
    #[Validate('nullable|date')] public string $start_period = '';
    #[Validate('nullable|date')] public string $end_period = '';
    #[Validate('boolean')] public bool $is_active = true;
    public string $newProgramName = '';

    public function create(): void { 
        $this->resetForm(); $this->showForm = true; 
    }
    public function edit(int $id): void { 
        $m = BansosRecipient::findOrFail($id);
        $this->editingId = $m->id; 
        $this->fill($m->only(['nik','full_name','address','program_name','program_type','is_active'])); 
        $this->address = $this->address ?? ''; 
        $this->program_type = $this->program_type ?? ''; 
        $this->start_period = $m->start_period?->format('Y-m-d') ?? ''; 
        $this->end_period = $m->end_period?->format('Y-m-d') ?? ''; $this->showForm = true; 
    }
    public function addProgram(): void {
        $name = trim($this->newProgramName);
        if ($name === '') { return; }
        if (BansosProgram::query()->where('name', $name)->exists()) {
            $this->dispatch('swal', icon: 'warning', title: 'Sudah Ada', text: "Program '$name' sudah ada di daftar.");
            return;
        }
        BansosProgram::query()->create(['name' => $name]);
        $this->newProgramName = '';
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: "Program '$name' berhasil ditambahkan.");
    }
    public function save(): void { 
        $this->validate(); 
        $data = [
            'nik'=>$this->nik,
            'full_name'=>$this->full_name,
            'address'=>$this->address,
            'program_name'=>$this->program_name,
            'program_type'=>$this->program_type,
            'start_period'=>$this->start_period ?: null,
            'end_period'=>$this->end_period ?: null,
            'is_active'=>$this->is_active]; 
            if ($this->editingId) {
                BansosRecipient::findOrFail($this->editingId)->update($data); 
            } else {
                BansosRecipient::create($data); 
            } 
            $this->resetForm(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data bansos disimpan.'); 
        }
    #[On('toggleActiveConfirmed')]
    public function toggleActive(int $id): void { $m = BansosRecipient::findOrFail($id); $m->update(['is_active'=>!$m->is_active]); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: $m->is_active ? 'Penerima diaktifkan.' : 'Penerima dinonaktifkan.'); }
    #[On('deleteConfirmed')]
    public function delete(int $id): void { BansosRecipient::findOrFail($id)->delete(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data dihapus.'); }

    // ─── Program Management ──────────────────────────
    public ?int $editingProgramId = null;
    public string $editingProgramName = '';

    public function editProgram(int $id): void {
        $p = BansosProgram::findOrFail($id);
        $this->editingProgramId = $p->id;
        $this->editingProgramName = $p->name;
    }

    public function updateProgram(): void {
        $name = trim($this->editingProgramName);
        if ($name === '' || !$this->editingProgramId) { return; }
        $p = BansosProgram::findOrFail($this->editingProgramId);
        $oldName = $p->name;
        if (BansosProgram::query()->where('name', $name)->where('id', '!=', $p->id)->exists()) {
            $this->dispatch('swal', icon: 'warning', title: 'Sudah Ada', text: "Program '$name' sudah ada.");
            return;
        }
        $p->update(['name' => $name]);
        // Update all recipients with old program name
        BansosRecipient::query()->where('program_name', $oldName)->update(['program_name' => $name]);
        $this->editingProgramId = null;
        $this->editingProgramName = '';
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: "Program diubah menjadi '$name'.");
    }

    public function cancelEditProgram(): void {
        $this->editingProgramId = null;
        $this->editingProgramName = '';
    }

    #[On('deleteProgramConfirmed')]
    public function deleteProgram(int $id): void {
        $p = BansosProgram::findOrFail($id);
        $count = BansosRecipient::query()->where('program_name', $p->name)->count();
        if ($count > 0) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: "Program '{$p->name}' masih digunakan oleh $count penerima. Hapus atau ubah penerima terlebih dahulu.");
            return;
        }
        $p->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Program berhasil dihapus.');
    }

    private function resetForm(): void {
        $this->reset([
            'showForm',
            'editingId',
            'nik',
            'full_name',
            'address',
            'program_name',
            'program_type',
            'start_period',
            'end_period',
            'is_active',
            'newProgramName']);
        $this->is_active = true; 
    }
    public function render() {
        $recipients = BansosRecipient::query()->when($this->search, fn($q) => $q->where('full_name','like',"%{$this->search}%")->orWhere('nik','like',"%{$this->search}%"))->latest()->paginate(15);
        $programs = BansosProgram::query()->orderBy('name')->get();
        $programNames = $programs->pluck('name');
        return view('livewire.admin.bansos-management', compact('recipients', 'programNames', 'programs'))->layout('layouts.admin', ['title' => 'Bansos']);
    }
}
