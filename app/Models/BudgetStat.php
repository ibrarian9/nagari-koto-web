<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetStat extends Model
{
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
}
