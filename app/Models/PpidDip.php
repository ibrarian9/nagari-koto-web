<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class PpidDip extends Model
{
    use LogsActivity;

    protected $table = 'ppid_dip';

    protected $fillable = [
        'judul', 'tahun_dokumen', 'kategori', 'file_path',
        'deskripsi', 'is_published', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public const KATEGORI = [
        'berkala'      => 'Berkala',
        'serta_merta'  => 'Serta Merta',
        'setiap_saat'  => 'Setiap Saat',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeKategori($query, string $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function getKategoriLabelAttribute(): string
    {
        return self::KATEGORI[$this->kategori] ?? $this->kategori;
    }

    protected function getActivityModelLabel(): string
    {
        return "DIP: {$this->judul}";
    }
}
