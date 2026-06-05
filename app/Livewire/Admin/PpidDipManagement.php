<?php

namespace App\Livewire\Admin;

use App\Models\PpidDip;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PpidDipManagement extends Component
{
    use WithFileUploads, WithPagination;

    public bool $showForm = false;
    public ?int $editId = null;
    public string $judul = '';
    public ?int $tahun_dokumen = null;
    public string $kategori = 'berkala';
    public string $deskripsi = '';
    public bool $is_published = true;
    public $fileUpload = null;
    public ?string $existingFile = null;
    public string $filterKategori = '';
    public string $search = '';

    public function create(): void
    {
        $this->reset(['editId', 'judul', 'tahun_dokumen', 'kategori', 'deskripsi', 'is_published', 'fileUpload', 'existingFile']);
        $this->tahun_dokumen = now()->year;
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $item = PpidDip::findOrFail($id);
        $this->editId = $item->id;
        $this->judul = $item->judul;
        $this->tahun_dokumen = $item->tahun_dokumen;
        $this->kategori = $item->kategori;
        $this->deskripsi = $item->deskripsi ?? '';
        $this->is_published = $item->is_published;
        $this->existingFile = $item->file_path;
        $this->fileUpload = null;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate([
            'judul'          => 'required|string|max:255',
            'tahun_dokumen'  => 'nullable|integer|min:2000|max:2100',
            'kategori'       => 'required|in:berkala,serta_merta,setiap_saat',
            'deskripsi'      => 'nullable|string',
            'fileUpload'     => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:20480',
        ]);

        $data = [
            'judul'         => $this->judul,
            'tahun_dokumen' => $this->tahun_dokumen,
            'kategori'      => $this->kategori,
            'deskripsi'     => $this->deskripsi,
            'is_published'  => $this->is_published,
            'published_at'  => $this->is_published ? now() : null,
        ];

        if ($this->fileUpload) {
            $data['file_path'] = $this->fileUpload->store('ppid/dip', 'public');
        }

        if ($this->editId) {
            PpidDip::findOrFail($this->editId)->update($data);
        } else {
            PpidDip::create($data);
        }

        $this->showForm = false;
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Dokumen DIP berhasil disimpan.');
    }

    public function delete(int $id): void
    {
        PpidDip::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Dihapus', text: 'Dokumen berhasil dihapus.');
    }

    public function togglePublish(int $id): void
    {
        $item = PpidDip::findOrFail($id);
        $item->update(['is_published' => !$item->is_published]);
    }

    #[Layout('layouts.admin', ['title' => 'Daftar Informasi Publik'])]
    public function render()
    {
        $query = PpidDip::latest();
        if ($this->filterKategori) $query->where('kategori', $this->filterKategori);
        if ($this->search) $query->where('judul', 'like', "%{$this->search}%");

        return view('livewire.admin.ppid-dip-management', [
            'items' => $query->paginate(15),
            'stats' => [
                'total'       => PpidDip::count(),
                'berkala'     => PpidDip::where('kategori', 'berkala')->count(),
                'serta_merta' => PpidDip::where('kategori', 'serta_merta')->count(),
                'setiap_saat' => PpidDip::where('kategori', 'setiap_saat')->count(),
            ],
        ]);
    }
}
