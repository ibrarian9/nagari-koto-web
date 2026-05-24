<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class PpidSertaMerta extends Model
{
    use LogsActivity;

    protected $table = 'ppid_serta_merta';

    protected $fillable = [
        'title', 'content', 'urgency', 'is_active', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    // ─── Urgency Config ───────────────────────────────────

    public const URGENCY_LEVELS = [
        'rendah' => ['label' => 'Rendah', 'color' => 'bg-blue-100 text-blue-800', 'icon' => 'info'],
        'sedang' => ['label' => 'Sedang', 'color' => 'bg-amber-100 text-amber-800', 'icon' => 'warning'],
        'tinggi' => ['label' => 'Tinggi', 'color' => 'bg-orange-100 text-orange-800', 'icon' => 'priority_high'],
        'kritis' => ['label' => 'Kritis', 'color' => 'bg-red-100 text-red-800', 'icon' => 'emergency'],
    ];

    public function getUrgencyLabelAttribute(): string
    {
        return self::URGENCY_LEVELS[$this->urgency]['label'] ?? $this->urgency;
    }

    public function getUrgencyColorAttribute(): string
    {
        return self::URGENCY_LEVELS[$this->urgency]['color'] ?? 'bg-gray-100 text-gray-800';
    }

    public function getUrgencyIconAttribute(): string
    {
        return self::URGENCY_LEVELS[$this->urgency]['icon'] ?? 'info';
    }

    // ─── Scopes ────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByUrgency($query, string $urgency)
    {
        return $query->where('urgency', $urgency);
    }

    protected function getActivityModelLabel(): string
    {
        return "PPID Serta Merta: {$this->title}";
    }
}
