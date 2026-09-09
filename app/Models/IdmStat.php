<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class IdmStat extends Model
{
    use LogsActivity;

    protected $table = 'idm_stats';

    protected $appends = [
        'status_label',
        'status_color',
        'formatted_score',
    ];

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

    /**
     * Helper to format IDM score (e.g., 0.170 becomes 170).
     */
    public static function formatIdmScore($value): string
    {
        $floatVal = (float) $value;
        if ($floatVal > 0 && $floatVal < 1) {
            return (string) (int) round($floatVal * 1000);
        }
        return (string) (int) round($floatVal);
    }

    /**
     * Get formatted IDM score attribute (e.g. 0.170 -> 170).
     */
    protected function formattedScore(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => static::formatIdmScore($attributes['score'] ?? 0)
        );
    }

    protected function getActivityModelLabel(): string
    {
        return "IDM Tahun: {$this->year}";
    }
}
