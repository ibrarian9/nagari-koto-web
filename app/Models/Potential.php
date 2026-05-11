<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Potential extends Model
{
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
}
