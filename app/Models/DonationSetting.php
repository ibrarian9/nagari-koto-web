<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class DonationSetting extends Model
{
    use LogsActivity;

    protected $fillable = [
        'bank_accounts',
        'transfer_instructions',
    ];

    protected function casts(): array
    {
        return [
            'bank_accounts' => 'array',
        ];
    }

    /**
     * Single-row pattern — get or create the config record.
     */
    public static function getContent(): self
    {
        return static::firstOrCreate([], [
            'bank_accounts' => [],
            'transfer_instructions' => 'Silakan transfer ke salah satu rekening di atas, lalu upload bukti transfer pada form donasi.',
        ]);
    }

    protected function getActivityModelLabel(): string
    {
        return "Pengaturan Donasi";
    }
}
