<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class BumnagMember extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'position', 'photo', 'role_type', 'period', 'order', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    // ─── Scopes ─────────────────────────────────────────────

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeOrdered($query) { return $query->orderBy('order'); }
    public function scopePengurus($query) { return $query->where('role_type', 'pengurus'); }
    public function scopePengawas($query) { return $query->where('role_type', 'pengawas'); }

    protected function getActivityModelLabel(): string
    {
        return "BUMNag Anggota: {$this->name}";
    }
}
