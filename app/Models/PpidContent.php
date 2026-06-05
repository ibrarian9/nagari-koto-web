<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class PpidContent extends Model
{
    use LogsActivity;

    protected $fillable = [
        'type', 'title', 'content', 'content_extra', 'attachment', 'image', 'members_data',
    ];

    protected function casts(): array
    {
        return ['members_data' => 'array'];
    }

    public const TYPES = [
        'profil'         => 'Profil Singkat PPID',
        'visi_misi'      => 'Visi & Misi PPID',
        'tugas_fungsi'   => 'Tugas & Fungsi PPID',
        'struktur'       => 'Struktur Organisasi PPID',
        'dikecualikan'   => 'Informasi Dikecualikan',
        'alur_informasi' => 'Alur Permohonan Informasi',
        'alur_keberatan' => 'Alur Pengajuan Keberatan',
        'alur_sengketa'  => 'Alur Penyelesaian Sengketa',
        'maklumat'       => 'Maklumat Pelayanan',
        'jadwal_biaya'   => 'Jadwal & Biaya Pelayanan',
        'dasar_hukum'    => 'Dasar Hukum',
        'sop'            => 'SOP PPID',
    ];

    /**
     * Get or create content by type (singleton per type).
     */
    public static function getByType(string $type): self
    {
        return static::firstOrCreate(
            ['type' => $type],
            ['title' => self::TYPES[$type] ?? $type, 'content' => '']
        );
    }

    protected function getActivityModelLabel(): string
    {
        return "Konten PPID: " . (self::TYPES[$this->type] ?? $this->type);
    }
}
