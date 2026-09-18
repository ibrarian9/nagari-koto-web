<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Support\Str;

class Category extends Model
{
    use LogsActivity;
    protected $fillable = [
        'name',
        'slug',
        'type',
    ];

    /**
     * Generate a guaranteed unique slug for a category across all types.
     */
    public static function generateUniqueSlug(string $name, string $type, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;

        $exists = static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        if ($exists) {
            $slug = "{$baseSlug}-" . Str::slug($type);
            $exists = static::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists();
        }

        $counter = 1;
        while ($exists) {
            $slug = "{$baseSlug}-{$counter}";
            $exists = static::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists();
            $counter++;
        }

        return $slug;
    }

    /**
     * Posts belonging to this category.
     *
     * @return HasMany<Post, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
