<?php
namespace App\Livewire\Admin;
use App\Models\Potential;
use App\Services\ImageOptimizer;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class PotentialManagement extends Component
{
    use WithFileUploads;
    public bool $showForm = false;
    public ?int $editingId = null;
    #[Validate('required|in:economy,tourism,agriculture,creative,environment')]
    public string $category = '';
    #[Validate('required|string|max:255')]
    public string $title = '';
    #[Validate('nullable|string')]
    public string $description = '';
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $thumbnail = null;
    public ?string $existingThumbnail = null;

    public function create(): void { $this->resetForm(); $this->showForm = true; }
    public function edit(int $id): void { $m = Potential::findOrFail($id); $this->editingId = $m->id; $this->fill($m->only(['category','title','description'])); $this->existingThumbnail = $m->thumbnail; $this->showForm = true; }
    public function save(): void
    {
        $this->validate();
        $data = ['category'=>$this->category,'title'=>$this->title,'slug'=>Str::slug($this->title).'-'.Str::random(5),'description'=>$this->description];
        if ($this->thumbnail) $data['thumbnail'] = (new ImageOptimizer())->optimize($this->thumbnail, 'potentials', 'thumbnail');
        if ($this->editingId) { unset($data['slug']); Potential::findOrFail($this->editingId)->update($data); } else { Potential::create($data); }
        $this->resetForm(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil disimpan.');
    }
    #[On('deleteConfirmed')]
    public function delete(int $id): void { Potential::findOrFail($id)->delete(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data dihapus.'); }
    private function resetForm(): void { $this->reset(['showForm','editingId','category','title','description','thumbnail','existingThumbnail']); }
    public function render()
    {
        $potentials = Potential::latest()->get();
        return view('livewire.admin.potential-management', compact('potentials'))->layout('layouts.admin', ['title' => 'Potensi Desa']);
    }
}
