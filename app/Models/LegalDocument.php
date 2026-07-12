<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class LegalDocument extends Model
{
    use LogsActivity;

    private const CACHE_TTL_MINUTES = 15;
    public const CACHE_KEY_PREFIX = 'legal_document:file_exists:';

    protected $fillable = [
        'title', 'category', 'year', 'number', 'description',
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
        'perdes' => 'Peraturan Desa',
        'sk_wali' => 'SK Wali Nagari',
        'perbup' => 'Peraturan Bupati',
        'perda' => 'Peraturan Daerah',
        'uu' => 'Undang-Undang',
        'pp' => 'Peraturan Pemerintah',
        'inpres' => 'Instruksi Presiden',
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

    public function fileExists(): bool
    {
        if (!$this->file_path) {
            return false;
        }

        // Key cache dibuat unik berdasarkan MD5 dari file_path model ini dengan prefix model-specific
        $cacheKey = self::CACHE_KEY_PREFIX . md5($this->file_path);

        // Cache akan disimpan selama 15 menit untuk menghindari stale data
        return Cache::remember($cacheKey, now()->addMinutes(self::CACHE_TTL_MINUTES), function () {
            return Storage::disk('public')->exists($this->file_path);
        });
    }

    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->fileExists()) {
            return 'N/A';
        }

        $bytes = $this->file_size;
        if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024) return round($bytes / 1024, 1) . ' KB';
        return $bytes . ' B';
    }

    public function getFileExtensionAttribute(): string
    {
        if (!$this->file_name) {
            return 'N/A';
        }
        return strtoupper(pathinfo($this->file_name, PATHINFO_EXTENSION));
    }

    protected function getActivityModelLabel(): string
    {
        return "Produk Hukum: {$this->title}";
    }
}
