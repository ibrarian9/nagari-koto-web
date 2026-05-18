<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DonationCampaign extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'thumbnail',
        'target_amount', 'collected_amount', 'start_date', 'end_date',
        'status', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'target_amount'    => 'decimal:2',
            'collected_amount' => 'decimal:2',
            'start_date'       => 'date',
            'end_date'         => 'date',
        ];
    }

    // ─── Relations ─────────────────────────────────────────

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class, 'campaign_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ─── Accessors ─────────────────────────────────────────

    public function getProgressPercentAttribute(): float
    {
        if ($this->target_amount <= 0) return 0;
        return min(100, round(($this->collected_amount / $this->target_amount) * 100, 1));
    }

    public function getDonorCountAttribute(): int
    {
        return $this->donations()->where('payment_status', 'success')->count();
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->end_date && $this->end_date->isPast();
    }

    // ─── Scopes ────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Recalculate collected amount from successful donations.
     */
    public function recalculateCollected(): void
    {
        $this->update([
            'collected_amount' => $this->donations()->where('payment_status', 'success')->sum('amount'),
        ]);
    }
}
