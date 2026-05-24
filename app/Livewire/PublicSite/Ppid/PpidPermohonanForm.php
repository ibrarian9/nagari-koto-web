<?php

namespace App\Livewire\PublicSite\Ppid;

use App\Models\PpidPermohonan;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class PpidPermohonanForm extends Component
{
    use WithFileUploads;

    public string $nama_pemohon = '';
    public string $nik = '';
    public string $no_telepon = '';
    public string $email = '';
    public string $alamat = '';
    public string $informasi_diminta = '';
    public string $tujuan_penggunaan = '';
    public string $format_informasi = 'softcopy';
    public string $cara_mendapatkan = 'mengambil_langsung';
    public $lampiran = null;

    public bool $submitted = false;
    public string $nomor = '';

    public function rules(): array
    {
        return [
            'nama_pemohon' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'no_telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'required|string|max:1000',
            'informasi_diminta' => 'required|string|max:2000',
            'tujuan_penggunaan' => 'required|string|max:1000',
            'format_informasi' => 'required|in:softcopy,hardcopy,keduanya',
            'cara_mendapatkan' => 'required|in:mengambil_langsung,email,pos',
            'lampiran' => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pemohon.required' => 'Nama pemohon wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'informasi_diminta.required' => 'Informasi yang diminta wajib diisi.',
            'tujuan_penggunaan.required' => 'Tujuan penggunaan informasi wajib diisi.',
            'lampiran.image' => 'Lampiran harus berupa gambar.',
            'lampiran.max' => 'Ukuran lampiran maks. 2MB.',
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $data = [
            'nomor_permohonan' => PpidPermohonan::generateNomorPermohonan(),
            'nama_pemohon' => $this->nama_pemohon,
            'nik' => $this->nik,
            'no_telepon' => $this->no_telepon,
            'email' => $this->email ?: null,
            'alamat' => $this->alamat,
            'informasi_diminta' => $this->informasi_diminta,
            'tujuan_penggunaan' => $this->tujuan_penggunaan,
            'format_informasi' => $this->format_informasi,
            'cara_mendapatkan' => $this->cara_mendapatkan,
            'status' => 'menunggu',
        ];

        if ($this->lampiran) {
            $data['lampiran'] = $this->lampiran->store('ppid/lampiran', 'public');
        }

        PpidPermohonan::create($data);

        $this->nomor = $data['nomor_permohonan'];
        $this->submitted = true;
    }

    #[Layout('layouts.app', ['title' => 'Permohonan Informasi Publik — PPID'])]
    public function render()
    {
        return view('livewire.public.ppid.permohonan-form', [
            'formatOptions' => PpidPermohonan::FORMAT_MAP,
            'caraOptions' => PpidPermohonan::CARA_MAP,
        ]);
    }
}
