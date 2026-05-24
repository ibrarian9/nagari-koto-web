<?php

namespace App\Livewire\Admin;

use App\Models\HeroSetting;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class HeroSettingManagement extends Component
{
    use WithFileUploads;

    public ?int $editingId = null;
    public $newImage;

    #[Layout('layouts.admin', ['title' => 'Hero Halaman'])]
    public function render()
    {
        return view('livewire.admin.hero-setting-management', [
            'heroes' => HeroSetting::orderBy('page_label')->get(),
        ]);
    }

    public function uploadImage(int $id): void
    {
        $this->validate([
            'newImage' => 'required|image|max:3072', // 3MB max for hero images
        ]);

        $hero = HeroSetting::findOrFail($id);

        // Delete old image
        if ($hero->image) {
            Storage::disk('public')->delete($hero->image);
        }

        $path = $this->newImage->store('heroes', 'public');
        $hero->update(['image' => $path]);
        HeroSetting::clearCache($hero->page_slug);

        $this->reset('newImage', 'editingId');
        session()->flash('message', "Hero \"{$hero->page_label}\" berhasil diperbarui.");
    }

    public function removeImage(int $id): void
    {
        $hero = HeroSetting::findOrFail($id);

        if ($hero->image) {
            Storage::disk('public')->delete($hero->image);
            $hero->update(['image' => null]);
            HeroSetting::clearCache($hero->page_slug);
        }

        session()->flash('message', "Hero \"{$hero->page_label}\" dikembalikan ke default.");
    }

    public function startEdit(int $id): void
    {
        $this->editingId = $id;
        $this->reset('newImage');
    }

    public function cancelEdit(): void
    {
        $this->reset('editingId', 'newImage');
    }
}
