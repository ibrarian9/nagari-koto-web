<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BansosRecipient extends Model
{
    use LogsActivity;

    protected $fillable = [
        'nik', 'full_name', 'address', 'program_name',
        'program_type', 'start_period', 'end_period', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_period' => 'date', 'end_period' => 'date', 'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query) { return $query->where('is_active', true); }

    /** Get masked name for public display (e.g. "Budi S***"). */
    public function getMaskedNameAttribute(): string
    {
        return Str::mask($this->full_name, '*', 6);
    }

    /** Get masked NIK for public display. */
    public function getMaskedNikAttribute(): string
    {
        return Str::mask($this->nik, '*', 6, 6);
    }

    protected function getActivityModelLabel(): string { return 'Bansos Recipient'; }
}
