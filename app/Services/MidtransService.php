<?php

namespace App\Services;

use App\Models\Donation;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Create a Snap token for a donation.
     */
    public function createSnapToken(Donation $donation): string
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $donation->order_id,
                'gross_amount' => (int) $donation->amount,
            ],
            'customer_details' => [
                'first_name' => $donation->donor_name,
                'email'      => $donation->donor_email ?? 'donor@nagari.id',
                'phone'      => $donation->donor_phone ?? '',
            ],
            'item_details' => [
                [
                    'id'       => 'DONASI-' . $donation->campaign_id,
                    'price'    => (int) $donation->amount,
                    'quantity' => 1,
                    'name'     => 'Donasi: ' . substr($donation->campaign->title, 0, 50),
                ],
            ],
        ];

        return Snap::getSnapToken($params);
    }

    /**
     * Handle webhook notification from Midtrans.
     */
    public function handleNotification(): array
    {
        $notif = new Notification();

        $orderId           = $notif->order_id;
        $transactionStatus = $notif->transaction_status;
        $fraudStatus       = $notif->fraud_status ?? 'accept';
        $paymentType       = $notif->payment_type ?? null;

        $donation = Donation::query()->where('order_id', $orderId)->first();

        if (!$donation) {
            return ['status' => 'error', 'message' => 'Donation not found'];
        }

        $paymentStatus = $this->resolvePaymentStatus($transactionStatus, $fraudStatus);
        $attributes = [
            'payment_status'   => $paymentStatus,
            'payment_type'     => $paymentType,
            'paid_at'          => $paymentStatus === 'success' ? now() : $donation->paid_at,
            'midtrans_response' => [
                'transaction_status' => $transactionStatus,
                'fraud_status'       => $fraudStatus,
                'payment_type'       => $paymentType,
                'transaction_id'     => $notif->transaction_id ?? null,
            ],
        ];

        $donation->update($attributes);

        // Recalculate campaign collected amount
        $donation->campaign->recalculateCollected();

        return ['status' => 'ok', 'payment_status' => $paymentStatus];
    }

    /**
     * Map Midtrans transaction status to our payment status.
     */
    private function resolvePaymentStatus(string $transactionStatus, string $fraudStatus): string
    {
        return match ($transactionStatus) {
            'capture'    => $fraudStatus === 'accept' ? 'success' : 'pending',
            'settlement' => 'success',
            'pending'    => 'pending',
            'deny', 'cancel' => 'failed',
            'expire'     => 'expired',
            default      => 'pending',
        };
    }
}
