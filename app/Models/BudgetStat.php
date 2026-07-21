<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class BudgetStat extends Model
{
    use LogsActivity;

    protected $table = 'budget_stats';

    protected $fillable = [
        'year',
        'total_income',
        'total_expenditure',
        'apbdes_data',
        'realization_pct',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'total_income' => 'integer',
            'total_expenditure' => 'integer',
            'apbdes_data' => 'array',
            'realization_pct' => 'decimal:2',
        ];
    }

    // ─── Scopes ─────────────────────────────────────────────

    public function scopeLatestYear($query)
    {
        return $query->orderByDesc('year');
    }

    public function getApbnagDataAttribute()
    {
        $val = $this->apbdes_data;
        if (is_string($val)) {
            $decoded = json_decode($val, true);
            return is_array($decoded) ? $decoded : [];
        }
        return $val ?? [];
    }

    protected function getActivityModelLabel(): string
    {
        return "Anggaran Tahun: {$this->year}";
    }
}
