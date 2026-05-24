<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use LogsActivity;

    protected $fillable = [
        'label',
        'phone',
        'category',
        'order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    // ─── Scopes ─────────────────────────────────────────────

    public function scopeOfCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    protected function getActivityModelLabel(): string
    {
        return "Kontak: {$this->label}";
    }
}
