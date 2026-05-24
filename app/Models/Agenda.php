<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use LogsActivity;

    protected $fillable = [
        'title',
        'description',
        'location',
        'start_date',
        'end_date',
        'is_public',
        'flyer',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'is_public' => 'boolean',
        ];
    }

    // ─── Scopes ─────────────────────────────────────────────

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now())
            ->orderBy('start_date');
    }

    public function scopePast($query)
    {
        return $query->where('start_date', '<', now())
            ->orderByDesc('start_date');
    }

    public function scopePublicOnly($query)
    {
        return $query->where('is_public', true);
    }

    protected function getActivityModelLabel(): string
    {
        return "Agenda: {$this->title}";
    }
}
