<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LetterRequest extends Model
{
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'letter_type',
        'full_name',
        'nik',
        'address',
        'purpose',
        'status',
        'notes',
        'requested_at',
        'processed_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'requested_at' => 'datetime',
            'processed_at' => 'datetime',
        ];
    }

    // ─── Relationships ──────────────────────────────────────

    /**
     * User who submitted this letter request.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ─── Helpers ────────────────────────────────────────────

    /**
     * Get human-readable letter type label.
     */
    public function getLetterTypeLabelAttribute(): string
    {
        return config("letters.types.{$this->letter_type}", $this->letter_type);
    }

    /**
     * Get status badge color CSS classes.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-100 text-amber-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'ready' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get Indonesian status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'ready' => 'Siap Diambil',
            'rejected' => 'Ditolak',
            default => $this->status,
        };
    }

    protected function getActivityModelLabel(): string
    {
        return "Surat: {$this->letter_type_label}";
    }
}
