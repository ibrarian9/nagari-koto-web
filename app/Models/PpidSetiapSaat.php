<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class PpidSetiapSaat extends Model
{
    use LogsActivity;

    protected $table = 'ppid_setiap_saat';

    protected $fillable = [
        'title', 'category', 'year', 'description',
        'file_path', 'file_name', 'file_size',
        'download_count', 'is_published', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'download_count' => 'integer',
            'file_size' => 'integer',
        ];
    }

    // ─── Categories ────────────────────────────────────────

    public const CATEGORIES = [
        'dip' => 'Daftar Informasi Publik',
        'statistik_desa' => 'Statistik Desa',
        'prosedur' => 'Prosedur Layanan',
        'perjanjian' => 'Perjanjian',
        'lainnya' => 'Lainnya',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    // ─── Scopes ────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    // ─── Helpers ───────────────────────────────────────────

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024) return round($bytes / 1024, 1) . ' KB';
        return $bytes . ' B';
    }

    public function getFileExtensionAttribute(): string
    {
        return strtoupper(pathinfo($this->file_name, PATHINFO_EXTENSION));
    }

    protected function getActivityModelLabel(): string
    {
        return "PPID Setiap Saat: {$this->title}";
    }
}
