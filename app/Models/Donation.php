<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use LogsActivity;

    protected $fillable = [
        'campaign_id', 'order_id', 'donor_name', 'donor_email', 'donor_phone',
        'amount', 'message', 'is_anonymous', 'payment_status', 'payment_type',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'       => 'decimal:2',
            'is_anonymous' => 'boolean',
            'paid_at'      => 'datetime',
        ];
    }

    // ─── Relations ─────────────────────────────────────────

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(DonationCampaign::class, 'campaign_id');
    }

    // ─── Accessors ─────────────────────────────────────────

    public function getDisplayNameAttribute(): string
    {
        if ($this->is_anonymous) return 'Hamba Allah';
        return $this->donor_name;
    }

    // ─── Scopes ────────────────────────────────────────────

    public function scopeSuccessful($query)
    {
        return $query->where('payment_status', 'success');
    }
}
