<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class IdmStat extends Model
{
    use LogsActivity;

    protected $table = 'idm_stats';

    protected $fillable = [
        'year',
        'score',
        'status',
        'social_score',
        'economic_score',
        'environment_score',
        'accessibility_score',
        'basic_service_score',
        'governance_score',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'score' => 'decimal:3',
            'social_score' => 'decimal:3',
            'economic_score' => 'decimal:3',
            'environment_score' => 'decimal:3',
            'accessibility_score' => 'decimal:3',
            'basic_service_score' => 'decimal:3',
            'governance_score' => 'decimal:3',
        ];
    }

    // ─── Scopes ─────────────────────────────────────────────

    public function scopeLatestYear($query)
    {
        return $query->orderByDesc('year');
    }

    // ─── Helpers ────────────────────────────────────────────

    /**
     * Get status label in Indonesian.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'sangat_tertinggal' => 'Sangat Tertinggal',
            'tertinggal' => 'Tertinggal',
            'berkembang' => 'Berkembang',
            'maju' => 'Maju',
            'mandiri' => 'Mandiri',
            default => $this->status,
        };
    }

    /**
     * Get CSS color class for the IDM status badge.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'sangat_tertinggal' => 'bg-red-100 text-red-800',
            'tertinggal' => 'bg-orange-100 text-orange-800',
            'berkembang' => 'bg-amber-100 text-amber-800',
            'maju' => 'bg-blue-100 text-blue-800',
            'mandiri' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    protected function getActivityModelLabel(): string
    {
        return "IDM Tahun: {$this->year}";
    }
}
