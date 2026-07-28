<?php

namespace App\Livewire\Admin;

use App\Models\PpidContent;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class PpidContentManagement extends Component
{
    use WithFileUploads;

    public string $activeTab = 'profil';

    public string $title = '';
    public string $content = '';
    public string $contentExtra = '';

    #[Validate('nullable|file|mimes:pdf|max:2048')]
    public $attachmentUpload = null;


    public ?string $existingAttachment = null;

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $imageUpload = null;

    public ?string $existingImage = null;

    // Members for struktur tab
    public array $members = [];

    // Temporary photo uploads per member index
    public array $memberPhotoUploads = [];

    public function mount(): void
    {
        $this->loadTab('profil');
    }

    public function switchTab(string $type): void
    {
        $this->activeTab = $type;
        $this->loadTab($type);
    }

    private function loadTab(string $type): void
    {
        $item = PpidContent::getByType($type);
        $this->title = $item->title;
        $this->content = $item->content ?? '';
        $this->contentExtra = $item->content_extra ?? '';
        $this->existingAttachment = $item->attachment;
        $this->existingImage = $item->image;
        $this->members = $item->members_data ?? [];
        $this->reset(['attachmentUpload', 'imageUpload', 'memberPhotoUploads']);
    }

    public function addMember(): void
    {
        $this->members[] = [
            'name' => '',
            'position' => '',
            'role' => '',
            'desc' => '',
            'photo' => null,
            'is_leader' => false,
        ];
    }

    public function removeMember(int $index): void
    {
        unset($this->members[$index]);
        $this->members = array_values($this->members);
    }

    public function updatedMemberPhotoUploads($value, $key): void
    {
        $this->validate([
            "memberPhotoUploads.{$key}" => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            "memberPhotoUploads.{$key}.max" => 'Ukuran foto anggota maksimal 2MB.',
            "memberPhotoUploads.{$key}.image" => 'File foto harus berupa gambar.',
            "memberPhotoUploads.{$key}.mimes" => 'Format foto harus JPG, PNG, atau WebP.',
        ]);

        $index = (int) $key;

        if ($value && $value->isValid()) {
            $path = $value->store('ppid/members', 'public');
            $this->members[$index]['photo'] = $path;
            unset($this->memberPhotoUploads[$index]);
        }
    }

    public function removeMemberPhoto(int $index): void
    {
        $this->members[$index]['photo'] = null;
    }

    public function save(): void
    {
        $this->validate();

        $item = PpidContent::getByType($this->activeTab);


        $data = [
            'title'         => $this->title,
            'content'       => $this->content,
            'content_extra' => $this->contentExtra,
        ];

        if ($this->attachmentUpload) {
            $data['attachment'] = $this->attachmentUpload->store('ppid/attachments', 'public');
            $this->existingAttachment = $data['attachment'];
        }

        if ($this->imageUpload) {
            $data['image'] = $this->imageUpload->store('ppid/images', 'public');
            $this->existingImage = $data['image'];
        }

        if ($this->activeTab === 'struktur') {
            $data['members_data'] = array_values(array_filter($this->members, fn($m) => !empty($m['name'])));
        }

        $item->update($data);

        $this->reset(['attachmentUpload', 'imageUpload', 'memberPhotoUploads']);
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Konten PPID berhasil disimpan.');
    }

    public function removeAttachment(): void
    {
        $item = PpidContent::getByType($this->activeTab);
        $item->update(['attachment' => null]);
        $this->existingAttachment = null;
    }

    public function removeImage(): void
    {
        $item = PpidContent::getByType($this->activeTab);
        $item->update(['image' => null]);
        $this->existingImage = null;
    }

    #[Layout('layouts.admin', ['title' => 'Konten PPID'])]
    public function render()
    {
        return view('livewire.admin.ppid-content-management');
    }
}
