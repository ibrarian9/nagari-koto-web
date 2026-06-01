<?php

namespace App\Livewire\PublicSite;

use App\Models\Donation;
use App\Models\DonationCampaign;
use App\Models\DonationSetting;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class DonationDetail extends Component
{
    use WithFileUploads;

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

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:3072')]
    public $payment_proof_upload = null;

    public bool $showForm = false;
    public bool $submitted = false;

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

        $data = [
            'campaign_id'    => $this->campaign->id,
            'order_id'       => $orderId,
            'donor_name'     => $this->donor_name,
            'donor_email'    => $this->donor_email,
            'donor_phone'    => $this->donor_phone,
            'amount'         => $this->amount,
            'message'        => $this->message,
            'is_anonymous'   => $this->is_anonymous,
            'payment_status' => 'pending',
            'payment_type'   => 'transfer',
        ];

        if ($this->payment_proof_upload) {
            $data['payment_proof'] = $this->payment_proof_upload->store('donations/proof', 'public');
        }

        Donation::create($data);

        $this->submitted = true;
        $this->dispatch('swal', icon: 'success', title: 'Donasi Tercatat!', text: 'Terima kasih! Silakan transfer ke rekening yang tertera. Admin akan mengkonfirmasi donasi Anda.');
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

        $donationSetting = DonationSetting::getContent();

        return view('livewire.public.donation-detail', compact('recentDonors', 'donorCount', 'donationSetting'))
            ->layout('layouts.app', ['title' => 'Donasi — ' . $this->campaign->title]);
    }
}
