<?php
namespace App\Livewire\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithFileUploads, WithPagination;
    public bool $showForm = false;
    public ?int $editingId = null;
    public string $search = '';
    public string $roleFilter = '';

    #[Validate('required|string|max:255')] public string $name = '';
    #[Validate('required|email|max:255')] public string $email = '';
    #[Validate('nullable|string|min:8')] public string $password = '';
    #[Validate('required|in:super_admin,admin,operator,warga')] public string $role = 'warga';
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')] public $photo = null;
    public ?string $existingPhoto = null;

    public function create(): void { $this->resetForm(); $this->showForm = true; }
    public function edit(int $id): void { $m = User::findOrFail($id); $this->editingId = $m->id; $this->fill($m->only(['name','email','role'])); $this->existingPhoto = $m->photo; $this->password = ''; $this->showForm = true; }
    public function save(): void {
        $rules = $this->editingId ? ['email' => "required|email|unique:users,email,{$this->editingId}"] : ['email' => 'required|email|unique:users,email', 'password' => 'required|string|min:8'];
        $this->validate(array_merge($this->rules ?? [], $rules));
        $data = ['name'=>$this->name,'email'=>$this->email,'role'=>$this->role];
        if ($this->password) $data['password'] = Hash::make($this->password);
        if ($this->photo) $data['photo'] = $this->photo->store('users','public');
        if ($this->editingId) User::findOrFail($this->editingId)->update($data); else User::create(array_merge($data, ['password' => Hash::make($this->password)]));
        $this->resetForm(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'User berhasil disimpan.');
    }
    #[On('toggleActiveConfirmed')]
    public function toggleActive(int $id): void { $u = User::findOrFail($id); if ($u->isSuperAdmin()) return; $u->update(['is_active'=>!$u->is_active]); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: $u->is_active ? 'Akun berhasil diaktifkan.' : 'Akun berhasil dinonaktifkan.'); }
    #[On('deleteConfirmed')]
    public function delete(int $id): void { $u = User::findOrFail($id); if ($u->isSuperAdmin()) return; $u->delete(); $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'User dihapus.'); }
    private function resetForm(): void { $this->reset(['showForm','editingId','name','email','password','role','photo','existingPhoto']); $this->role = 'warga'; }
    public function render() {
        $users = User::when($this->search, fn($q) => $q->where('name','like',"%{$this->search}%")->orWhere('email','like',"%{$this->search}%"))
            ->when($this->roleFilter, fn($q) => $q->where('role', $this->roleFilter))
            ->latest()->paginate(15);
        return view('livewire.admin.user-management', compact('users'))->layout('layouts.admin', ['title' => 'Manajemen User']);
    }
}
