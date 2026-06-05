<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class PpidKeberatan extends Model
{
    use LogsActivity;

    protected $table = 'ppid_keberatan';

    protected $fillable = [
        'kode_registrasi', 'no_registrasi_permohonan', 'nama', 'no_hp',
        'email', 'pekerjaan', 'alamat', 'informasi_dimohon',
        'alasan_keberatan', 'status', 'catatan_admin',
    ];

    public const ALASAN = [
        'penolakan_pengecualian'   => 'Penolakan atas permintaan informasi berdasarkan alasan pengecualian',
        'tidak_disediakan_berkala' => 'Tidak disediakannya informasi berkala',
        'tidak_ditanggapi'        => 'Tidak ditanggapinya permintaan informasi',
        'tidak_sesuai'            => 'Permintaan informasi ditanggapi tidak sebagaimana yang diminta',
        'tidak_dipenuhi'          => 'Tidak dipenuhinya permintaan informasi',
        'biaya_tidak_wajar'       => 'Pengenaan biaya yang tidak wajar',
        'melebihi_waktu'          => 'Penyampaian informasi yang melebihi waktu yang diatur dalam Undang-Undang',
    ];

    public const STATUS = [
        'diterima'  => 'Diterima',
        'diproses'  => 'Diproses',
        'selesai'   => 'Selesai',
        'ditolak'   => 'Ditolak',
    ];

    public function getAlasanLabelAttribute(): string
    {
        return self::ALASAN[$this->alasan_keberatan] ?? $this->alasan_keberatan;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'diterima'  => 'bg-blue-100 text-blue-700',
            'diproses'  => 'bg-amber-100 text-amber-700',
            'selesai'   => 'bg-green-100 text-green-700',
            'ditolak'   => 'bg-red-100 text-red-700',
            default     => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Generate unique registration code: KBR-YYYYMMDD-XXXX
     */
    public static function generateKode(): string
    {
        $date = now()->format('Ymd');
        $count = static::whereDate('created_at', today())->count() + 1;
        return 'KBR-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    protected function getActivityModelLabel(): string
    {
        return "Keberatan PPID: {$this->kode_registrasi}";
    }
}
