<?php

namespace App\Traits;

use App\Models\ActivityLog;

/**
 * Trait LogsActivity
 *
 * Auto-logs created, updated, and deleted events to the activity_logs table.
 * Use this trait on any Eloquent model that needs an audit trail.
 *
 * Usage: `use LogsActivity;` in your model class.
 */
trait LogsActivity
{
    /**
     * Boot the trait and register model event listeners.
     */
    public static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            $model->logActivity('created', "Membuat {$model->getActivityModelLabel()} baru");
        });

        static::updated(function ($model) {
            $model->logActivity('updated', "Mengubah data {$model->getActivityModelLabel()}");
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted', "Menghapus {$model->getActivityModelLabel()}");
        });
    }

    /**
     * Write an activity log entry.
     */
    protected function logActivity(string $action, string $description): void
    {
        try {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'model_type' => static::class,
                'model_id' => $this->getKey(),
                'description' => $description,
                'ip_address' => request()?->ip(),
            ]);
        } catch (\Throwable) {
            // Silently fail — logging should never break the main operation
        }
    }

    /**
     * Get a human-readable label for this model (override in model if needed).
     */
    protected function getActivityModelLabel(): string
    {
        return class_basename(static::class);
    }
}
