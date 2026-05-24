<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class PopulationStat extends Model
{
    use LogsActivity;

    protected $table = 'population_stats';

    protected $fillable = [
        'year',
        'total_population',
        'male',
        'female',
        'total_families',
        'age_group_data',
        'education_data',
        'occupation_data',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'total_population' => 'integer',
            'male' => 'integer',
            'female' => 'integer',
            'total_families' => 'integer',
            'age_group_data' => 'array',
            'education_data' => 'array',
            'occupation_data' => 'array',
        ];
    }

    // ─── Scopes ─────────────────────────────────────────────

    public function scopeLatestYear($query)
    {
        return $query->orderByDesc('year');
    }

    protected function getActivityModelLabel(): string
    {
        return "Statistik Penduduk: {$this->year}";
    }
}
