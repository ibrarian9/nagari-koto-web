<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class PpidComment extends Model
{
    use LogsActivity;

    protected $fillable = [
        'komentar', 'nama', 'email', 'no_hp', 'is_approved',
    ];

    protected function casts(): array
    {
        return ['is_approved' => 'boolean'];
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    protected function getActivityModelLabel(): string
    {
        return "Komentar PPID: {$this->nama}";
    }
}
