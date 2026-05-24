<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class BumnagBudget extends Model
{
    use LogsActivity;

    protected $fillable = [
        'year', 'total_income', 'total_expenditure',
        'realization_pct', 'apbdes_data', 'keterangan',
    ];

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

    public function scopeLatestYear($query)
    {
        return $query->orderByDesc('year');
    }

    protected function getActivityModelLabel(): string
    {
        return "Anggaran BUMNag: {$this->year}";
    }
}
