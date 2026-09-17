<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SiteVisitor extends Model
{
    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'visit_date',
        'hits',
        'last_activity',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
            'last_activity' => 'datetime',
            'hits' => 'integer',
        ];
    }

    /**
     * Count visitors who were active within the given threshold (default 5 minutes).
     * Guaranteed minimum of 1 for the current viewer.
     */
    public static function getOnlineCount(int $minutes = 5): int
    {
        $since = now()->subMinutes($minutes);

        $siteCount = (int) static::where('last_activity', '>=', $since)
            ->distinct('session_id')
            ->count('session_id');

        $sessionCount = 0;
        if (Schema::hasTable('sessions')) {
            $sessionCount = (int) DB::table('sessions')
                ->where('last_activity', '>=', $since->timestamp)
                ->count();
        }

        return max(1, max($siteCount, $sessionCount));
    }

    /**
     * Count unique visitors today.
     */
    public static function getTodayCount(): int
    {
        return (int) static::where('visit_date', today())->count();
    }

    /**
     * Count unique visitors yesterday.
     */
    public static function getYesterdayCount(): int
    {
        return (int) static::where('visit_date', today()->subDay())->count();
    }

    /**
     * Count unique visitors this month.
     */
    public static function getThisMonthCount(): int
    {
        return (int) static::whereYear('visit_date', now()->year)
            ->whereMonth('visit_date', now()->month)
            ->count();
    }

    /**
     * Total unique visitor count across all time.
     */
    public static function getTotalCount(): int
    {
        return (int) static::count();
    }

    /**
     * Total page hits across all time.
     */
    public static function getTotalHits(): int
    {
        return (int) static::sum('hits');
    }
}
