<?php
namespace App\Livewire\Admin;
use App\Models\Product;
use App\Services\ImageOptimizer;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductManagement extends Component
{
    use WithFileUploads;
    public bool $showForm = false;
    public ?int $editingId = null;
    public string $search = '';
    #[Validate('required|string|max:255')] public string $owner_name = '';
    #[Validate('required|string|max:255')] public string $business_name = '';
    #[Validate('nullable|string|max:100')] public string $category = '';
    #[Validate('nullable|string')] public string $description = '';
    #[Validate('nullable|string|max:20')] public string $whatsapp = '';
    #[Validate('nullable|string|max:500')] public string $address = '';
    #[Validate('boolean')] public bool $is_active = true;
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')] public $photo = null;
    public ?string $existingPhoto = null;

    public function create(): void { $this->resetForm(); $this->showForm = true; }
    public function edit(int $id): void { $m = Product::findOrFail($id); $this->editingId = $m->id; $this->fill($m->only(['owner_name','business_name','category','description','whatsapp','address','is_active'])); $this->existingPhoto = $m->photo; $this->showForm = true; }
    public function save(): void {
        $this->validate();
        $data = ['owner_name'=>$this->owner_name,'business_name'=>$this->business_name,'category'=>$this->category,'description'=>$this->description,'whatsapp'=>$this->whatsapp,'address'=>$this->address,'is_active'=>$this->is_active];
        if ($this->photo) $data['photo'] = (new ImageOptimizer())->optimize($this->photo, 'products', 'photo');
        if ($this->editingId) Product::findOrFail($this->editingId)->update($data); else Product::create($data);
        $this->resetForm(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data UMKM berhasil disimpan.');
    }
    public function toggleActive(int $id): void { $p = Product::findOrFail($id); $p->update(['is_active' => !$p->is_active]); }
    #[On('deleteConfirmed')]
    public function delete(int $id): void { Product::findOrFail($id)->delete(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data dihapus.'); }
    private function resetForm(): void { $this->reset(['showForm','editingId','owner_name','business_name','category','description','whatsapp','address','is_active','photo','existingPhoto']); $this->is_active = true; }
    public function render() {
        $products = Product::when($this->search, fn($q) => $q->where('business_name','like',"%{$this->search}%"))->latest()->get();
        return view('livewire.admin.product-management', compact('products'))->layout('layouts.admin', ['title' => 'UMKM']);
    }
}
