<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class PbbRecord extends Model
{
    use LogsActivity;

    protected $fillable = [
        'nop', 'taxpayer_name', 'address', 'land_area', 'building_area',
        'njop', 'tax_amount', 'tax_year', 'status', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'land_area' => 'decimal:2', 'building_area' => 'decimal:2',
            'njop' => 'integer', 'tax_amount' => 'integer',
            'tax_year' => 'integer', 'paid_at' => 'datetime',
        ];
    }

    public function scopePaid($query) { return $query->where('status', 'paid'); }
    public function scopeUnpaid($query) { return $query->where('status', 'unpaid'); }
    public function scopeForYear($query, int $year) { return $query->where('tax_year', $year); }

    protected function getActivityModelLabel(): string { return "PBB NOP: {$this->nop}"; }
}
