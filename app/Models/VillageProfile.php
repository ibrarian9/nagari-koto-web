<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class VillageProfile extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'tagline',
        'history',
        'vision',
        'mission',
        'address',
        'province',
        'regency',
        'district',
        'village_code',
        'area_ha',
        'established_year',
        'photo',
        'logo',
        'map_embed_url',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'area_ha' => 'decimal:2',
            'established_year' => 'integer',
        ];
    }

    /**
     * Get the village profile (single-row pattern).
     */
    public static function getCached(): ?self
    {
        return static::query()->first();
    }

    protected function getActivityModelLabel(): string
    {
        return "Profil Desa: {$this->name}";
    }
}
