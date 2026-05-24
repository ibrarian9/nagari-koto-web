<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class BumnagProfile extends Model
{
    use LogsActivity;

    protected $table = 'bumnag_profiles';

    protected $fillable = [
        'name', 'logo', 'description', 'sejarah', 'visi', 'misi',
        'alamat', 'telepon', 'email',
        'sk_pendirian', 'tanggal_pendirian',
        'badan_hukum_file',
        'unit_usaha',
    ];

    protected function casts(): array
    {
        return [
            'unit_usaha' => 'array',
            'tanggal_pendirian' => 'date',
        ];
    }

    /**
     * Single-row pattern — get or create the config record.
     */
    public static function getContent(): self
    {
        return static::firstOrCreate([], [
            'name' => 'BUMNag',
            'description' => 'Badan Usaha Milik Nagari',
        ]);
    }

    protected function getActivityModelLabel(): string
    {
        return "BUMNag Profil";
    }
}
