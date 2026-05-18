<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForestryRecord extends Model
{
    protected $fillable = [
        'title',
        'category',
        'area_ha',
        'location',
        'description',
        'status',
        'year',
        'thumbnail',
    ];

    protected function casts(): array
    {
        return [
            'area_ha' => 'decimal:2',
            'year' => 'integer',
        ];
    }

    // ─── Labels ────────────────────────────────────────────

    public const CATEGORIES = [
        'hutan_lindung'  => 'Hutan Lindung',
        'hutan_produksi' => 'Hutan Produksi',
        'hutan_rakyat'   => 'Hutan Rakyat',
        'lahan_kritis'   => 'Lahan Kritis',
        'rehabilitasi'   => 'Rehabilitasi',
    ];

    public const STATUSES = [
        'aktif'           => 'Aktif',
        'dalam_pemulihan' => 'Dalam Pemulihan',
        'kritis'          => 'Kritis',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    // ─── Scopes ────────────────────────────────────────────

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
