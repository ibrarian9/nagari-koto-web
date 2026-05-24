<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HeroSetting extends Model
{
    use LogsActivity;

    protected $fillable = ['page_slug', 'page_label', 'image'];

    /**
     * Get hero image URL for a given page slug.
     * Cached for 60 minutes to avoid repeated DB queries.
     */
    public static function getImageUrl(string $slug): ?string
    {
        $image = Cache::remember("hero_image_{$slug}", 3600, function () use ($slug) {
            return static::where('page_slug', $slug)->value('image');
        });

        return $image ? Storage::url($image) : null;
    }

    /**
     * Clear cache for a specific slug.
     */
    public static function clearCache(string $slug): void
    {
        Cache::forget("hero_image_{$slug}");
    }

    protected function getActivityModelLabel(): string
    {
        return "Hero: {$this->page_label}";
    }
}
