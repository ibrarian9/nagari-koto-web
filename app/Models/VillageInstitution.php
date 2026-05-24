<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class VillageInstitution extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'type', 'head_name', 'description', 'logo', 'contact', 'established_year', 'is_active', 'order'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'order' => 'integer', 'established_year' => 'integer'];
    }

    public const TYPES = [
        'adat'        => 'Adat & Budaya',
        'kepemudaan'  => 'Kepemudaan',
        'perempuan'   => 'Perempuan',
        'keagamaan'   => 'Keagamaan',
        'sosial'      => 'Sosial',
        'pendidikan'  => 'Pendidikan',
        'lainnya'     => 'Lainnya',
    ];

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeOrdered($query) { return $query->orderBy('order'); }
    public function scopeByType($query, $type) { return $query->where('type', $type); }

    protected function getActivityModelLabel(): string
    {
        return "Lembaga: {$this->name}";
    }
}
