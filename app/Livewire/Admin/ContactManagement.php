<?php
namespace App\Livewire\Admin;
use App\Models\Contact;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactManagement extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;
    #[Validate('required|string|max:255')] public string $label = '';
    #[Validate('required|string|max:20')] public string $phone = '';
    #[Validate('required|in:emergency,government,health,social')] public string $category = '';
    #[Validate('nullable|integer|min:0')] public int $order = 0;

    public function create(): void { $this->resetForm(); $this->showForm = true; }
    public function edit(int $id): void { $m = Contact::findOrFail($id); $this->editingId = $m->id; $this->fill($m->only(['label','phone','category','order'])); $this->showForm = true; }
    public function save(): void { $this->validate(); $data = ['label'=>$this->label,'phone'=>$this->phone,'category'=>$this->category,'order'=>$this->order]; if ($this->editingId) Contact::findOrFail($this->editingId)->update($data); else Contact::create($data); $this->resetForm(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Kontak berhasil disimpan.'); }
    #[On('deleteConfirmed')]
    public function delete(int $id): void { Contact::findOrFail($id)->delete(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Kontak dihapus.'); }
    private function resetForm(): void { $this->reset(['showForm','editingId','label','phone','category','order']); }
    public function render() { return view('livewire.admin.contact-management', ['contacts' => Contact::ordered()->get()])->layout('layouts.admin', ['title' => 'Kontak']); }
}
