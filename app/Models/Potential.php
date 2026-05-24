<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Potential extends Model
{
    use LogsActivity;

    protected $fillable = [
        'category',
        'title',
        'slug',
        'description',
        'thumbnail',
    ];

    // ─── Scopes ─────────────────────────────────────────────

    public function scopeOfCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    protected function getActivityModelLabel(): string
    {
        return "Potensi: {$this->title}";
    }
}
