<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class GovernmentMember extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'position',
        'photo',
        'order',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    // ─── Scopes ─────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    protected function getActivityModelLabel(): string
    {
        return "Perangkat Desa: {$this->name}";
    }
}
