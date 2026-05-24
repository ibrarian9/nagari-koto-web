<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class BumnagProgram extends Model
{
    use LogsActivity;

    protected $fillable = [
        'nama_kegiatan', 'kepala_unit_usaha', 'keterangan',
        'output_program', 'kendala', 'penerima_manfaat',
        'tahun', 'order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
            'tahun' => 'integer',
        ];
    }

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeOrdered($query) { return $query->orderBy('order'); }

    protected function getActivityModelLabel(): string
    {
        return "Program BUMNag: {$this->nama_kegiatan}";
    }
}
