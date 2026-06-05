<?php

namespace App\Livewire\PublicSite\Ppid;

use App\Models\PpidBerkala;
use App\Models\PpidComment;
use App\Models\PpidContent;
use App\Models\PpidKeberatan;
use App\Models\PpidPermohonan;
use App\Models\PpidSetiapSaat;
use App\Models\PpidSertaMerta;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PpidHome extends Component
{
    use WithPagination, WithFileUploads;

    #[Url(as: 'q')]
    public string $infoSearch = '';

    // ── Keberatan form
    public string $kbrNoReg = '';
    public string $kbrNama = '';
    public string $kbrNoHp = '';
    public string $kbrEmail = '';
    public string $kbrPekerjaan = '';
    public string $kbrAlamat = '';
    public string $kbrInfoDimohon = '';
    public string $kbrAlasan = '';
    public bool $kbrSubmitted = false;
    public string $kbrKode = '';

    // ── Permohonan form (inline)
    public string $pmhNama = '';
    public string $pmhNik = '';
    public string $pmhTelepon = '';
    public string $pmhEmail = '';
    public string $pmhAlamat = '';
    public string $pmhInfoDiminta = '';
    public string $pmhTujuan = '';
    public string $pmhFormat = 'softcopy';
    public string $pmhCara = 'mengambil_langsung';
    public $pmhLampiran = null;
    public bool $pmhSubmitted = false;
    public string $pmhNomor = '';

    // ── Comment form
    public string $cmtKomentar = '';
    public string $cmtNama = '';
    public string $cmtEmail = '';
    public string $cmtNoHp = '';
    public string $cmtCaptcha = '';
    public string $captchaCode = '';
    public bool $cmtSubmitted = false;

    public function mount(): void
    {
        $this->generateCaptcha();
    }

    public function updatingInfoSearch(): void
    {
        $this->resetPage('berkala');
        $this->resetPage('setiapsaat');
    }

    // ── Downloads ──
    public function downloadBerkala(int $id)
    {
        $item = PpidBerkala::published()->findOrFail($id);
        $item->increment('download_count');
        return Storage::disk('public')->download($item->file_path, $item->file_name);
    }

    public function downloadSetiapSaat(int $id)
    {
        $item = PpidSetiapSaat::published()->findOrFail($id);
        $item->increment('download_count');
        return Storage::disk('public')->download($item->file_path, $item->file_name);
    }

    public function generateCaptcha(): void
    {
        $this->captchaCode = strtoupper(substr(md5(mt_rand()), 0, 5));
    }

    // ── Keberatan ──
    public function submitKeberatan(): void
    {
        $this->validate([
            'kbrNama'   => 'required|string|max:255',
            'kbrNoHp'   => 'required|string|max:20',
            'kbrAlamat' => 'required|string',
            'kbrAlasan' => 'required|in:' . implode(',', array_keys(PpidKeberatan::ALASAN)),
        ]);

        $kode = PpidKeberatan::generateKode();
        PpidKeberatan::create([
            'kode_registrasi'          => $kode,
            'no_registrasi_permohonan' => $this->kbrNoReg ?: null,
            'nama'                     => $this->kbrNama,
            'no_hp'                    => $this->kbrNoHp,
            'email'                    => $this->kbrEmail ?: null,
            'pekerjaan'                => $this->kbrPekerjaan ?: null,
            'alamat'                   => $this->kbrAlamat,
            'informasi_dimohon'        => $this->kbrInfoDimohon ?: null,
            'alasan_keberatan'         => $this->kbrAlasan,
        ]);

        $this->kbrKode = $kode;
        $this->kbrSubmitted = true;
        $this->dispatch('swal', icon: 'success', title: 'Berhasil!', text: "Keberatan berhasil diajukan. Kode: {$kode}");
    }

    public function resetKeberatanForm(): void
    {
        $this->reset(['kbrNoReg', 'kbrNama', 'kbrNoHp', 'kbrEmail', 'kbrPekerjaan', 'kbrAlamat', 'kbrInfoDimohon', 'kbrAlasan', 'kbrSubmitted', 'kbrKode']);
    }

    // ── Permohonan ──
    public function submitPermohonan(): void
    {
        $this->validate([
            'pmhNama'       => 'required|string|max:255',
            'pmhNik'        => 'required|digits:16',
            'pmhTelepon'    => 'required|string|max:20',
            'pmhEmail'      => 'nullable|email|max:255',
            'pmhAlamat'     => 'required|string|max:1000',
            'pmhInfoDiminta' => 'required|string|max:2000',
            'pmhTujuan'     => 'required|string|max:1000',
            'pmhFormat'     => 'required|in:softcopy,hardcopy,keduanya',
            'pmhCara'       => 'required|in:mengambil_langsung,email,pos',
            'pmhLampiran'   => 'nullable|image|max:2048',
        ]);

        $data = [
            'nomor_permohonan' => PpidPermohonan::generateNomorPermohonan(),
            'nama_pemohon'     => $this->pmhNama,
            'nik'              => $this->pmhNik,
            'no_telepon'       => $this->pmhTelepon,
            'email'            => $this->pmhEmail ?: null,
            'alamat'           => $this->pmhAlamat,
            'informasi_diminta' => $this->pmhInfoDiminta,
            'tujuan_penggunaan' => $this->pmhTujuan,
            'format_informasi' => $this->pmhFormat,
            'cara_mendapatkan' => $this->pmhCara,
            'status'           => 'menunggu',
        ];

        if ($this->pmhLampiran) {
            $data['lampiran'] = $this->pmhLampiran->store('ppid/lampiran', 'public');
        }

        PpidPermohonan::create($data);
        $this->pmhNomor = $data['nomor_permohonan'];
        $this->pmhSubmitted = true;
        $this->dispatch('swal', icon: 'success', title: 'Berhasil!', text: "Permohonan berhasil. Nomor: {$data['nomor_permohonan']}");
    }

    public function resetPermohonanForm(): void
    {
        $this->reset(['pmhNama', 'pmhNik', 'pmhTelepon', 'pmhEmail', 'pmhAlamat', 'pmhInfoDiminta', 'pmhTujuan', 'pmhFormat', 'pmhCara', 'pmhLampiran', 'pmhSubmitted', 'pmhNomor']);
    }

    // ── Komentar ──
    public function submitComment(): void
    {
        $this->validate([
            'cmtKomentar' => 'required|string|max:2000',
            'cmtNama'     => 'required|string|max:255',
            'cmtEmail'    => 'nullable|email|max:255',
            'cmtNoHp'     => 'required|string|max:20',
            'cmtCaptcha'  => 'required',
        ]);

        if (strtoupper($this->cmtCaptcha) !== $this->captchaCode) {
            $this->addError('cmtCaptcha', 'Kode captcha tidak sesuai.');
            $this->generateCaptcha();
            return;
        }

        PpidComment::create([
            'komentar' => $this->cmtKomentar,
            'nama'     => $this->cmtNama,
            'email'    => $this->cmtEmail ?: null,
            'no_hp'    => $this->cmtNoHp,
        ]);

        $this->cmtSubmitted = true;
        $this->reset(['cmtKomentar', 'cmtNama', 'cmtEmail', 'cmtNoHp', 'cmtCaptcha']);
        $this->generateCaptcha();
    }

    public function resetCommentForm(): void
    {
        $this->reset(['cmtKomentar', 'cmtNama', 'cmtEmail', 'cmtNoHp', 'cmtCaptcha', 'cmtSubmitted']);
        $this->generateCaptcha();
    }

    #[Layout('layouts.app', ['title' => 'PPID — Informasi Publik'])]
    public function render()
    {
        $berkalaQuery = PpidBerkala::published()
            ->when($this->infoSearch, fn($q) => $q->where('title', 'like', "%{$this->infoSearch}%"))
            ->latest('published_at');

        $setiapSaatQuery = PpidSetiapSaat::published()
            ->when($this->infoSearch, fn($q) => $q->where('title', 'like', "%{$this->infoSearch}%"))
            ->latest('published_at');

        $sertaMertaQuery = PpidSertaMerta::active()
            ->when($this->infoSearch, fn($q) => $q->where('title', 'like', "%{$this->infoSearch}%"))
            ->latest('published_at');

        return view('livewire.public.ppid.home', [
            'profil'          => PpidContent::getByType('profil'),
            'visiMisi'        => PpidContent::getByType('visi_misi'),
            'tugasFungsi'     => PpidContent::getByType('tugas_fungsi'),
            'struktur'        => PpidContent::getByType('struktur'),
            'berkalaItems'    => $berkalaQuery->paginate(10, pageName: 'berkala'),
            'berkalaCount'    => PpidBerkala::published()->count(),
            'berkalaCategories' => PpidBerkala::CATEGORIES,
            'setiapSaatItems' => $setiapSaatQuery->paginate(10, pageName: 'setiapsaat'),
            'setiapSaatCount' => PpidSetiapSaat::published()->count(),
            'setiapSaatCategories' => PpidSetiapSaat::CATEGORIES,
            'sertaMertaItems' => $sertaMertaQuery->paginate(10, pageName: 'sertamerta'),
            'sertaMertaCount' => PpidSertaMerta::active()->count(),
            'urgentItems'     => PpidSertaMerta::active()->latest('published_at')->take(3)->get(),
            'permohonanCount' => PpidPermohonan::count(),
            'dikecualikan'    => PpidContent::getByType('dikecualikan'),
            'alurInformasi'   => PpidContent::getByType('alur_informasi'),
            'alurKeberatan'   => PpidContent::getByType('alur_keberatan'),
            'alurSengketa'    => PpidContent::getByType('alur_sengketa'),
            'maklumat'        => PpidContent::getByType('maklumat'),
            'jadwalBiaya'     => PpidContent::getByType('jadwal_biaya'),
            'dasarHukum'      => PpidContent::getByType('dasar_hukum'),
            'sop'             => PpidContent::getByType('sop'),
            'approvedComments' => PpidComment::approved()->latest()->take(10)->get(),
            'formatOptions'   => PpidPermohonan::FORMAT_MAP,
            'caraOptions'     => PpidPermohonan::CARA_MAP,
        ]);
    }
}
