<?php

namespace App\Livewire\PublicSite;

use App\Models\Donation;
use App\Models\DonationCampaign;
use App\Services\MidtransService;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DonationDetail extends Component
{
    public DonationCampaign $campaign;

    #[Validate('required|string|max:255')]
    public string $donor_name = '';
    #[Validate('nullable|email|max:255')]
    public ?string $donor_email = '';
    #[Validate('nullable|string|max:20')]
    public ?string $donor_phone = '';
    #[Validate('required|numeric|min:10000')]
    public $amount = '';
    #[Validate('nullable|string|max:500')]
    public ?string $message = '';
    public bool $is_anonymous = false;

    public ?string $snapToken = null;
    public bool $showForm = false;

    public function mount(string $slug): void
    {
        $this->campaign = DonationCampaign::where('slug', $slug)->firstOrFail();
    }

    public function openForm(): void
    {
        $this->showForm = true;
    }

    public function submitDonation(): void
    {
        $this->validate();

        if ($this->campaign->status !== 'active') {
            $this->dispatch('swal', icon: 'error', title: 'Campaign Ditutup', text: 'Campaign ini sudah tidak menerima donasi.');
            return;
        }

        $orderId = 'DON-' . strtoupper(uniqid()) . '-' . time();

        $donation = Donation::create([
            'campaign_id' => $this->campaign->id,
            'order_id'    => $orderId,
            'donor_name'  => $this->donor_name,
            'donor_email' => $this->donor_email,
            'donor_phone' => $this->donor_phone,
            'amount'      => $this->amount,
            'message'     => $this->message,
            'is_anonymous' => $this->is_anonymous,
            'payment_status' => 'pending',
        ]);

        try {
            $midtrans = new MidtransService();
            $this->snapToken = $midtrans->createSnapToken($donation);
            $donation->update(['snap_token' => $this->snapToken]);

            $this->dispatch('openSnap', token: $this->snapToken);
        } catch (\Exception $e) {
            report($e);
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Tidak dapat memproses pembayaran. Pastikan konfigurasi Midtrans sudah benar.');
        }
    }

    public function render()
    {
        $recentDonors = Donation::query()->where('campaign_id', $this->campaign->id)
            ->where('payment_status', 'success')
            ->latest('paid_at')
            ->take(10)
            ->get();

        $donorCount = Donation::query()->where('campaign_id', $this->campaign->id)
            ->where('payment_status', 'success')
            ->count();

        return view('livewire.public.donation-detail', compact('recentDonors', 'donorCount'))
            ->layout('layouts.app', ['title' => 'Donasi — ' . $this->campaign->title]);
    }
}
