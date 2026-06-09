<?php

namespace App\Livewire\PublicSite;

use App\Models\Donation;
use App\Models\DonationCampaign;
use App\Models\DonationSetting;
use Livewire\Component;

class DonationDetail extends Component
{
    public DonationCampaign $campaign;

    public function mount(string $slug): void
    {
        $this->campaign = DonationCampaign::where('slug', $slug)->firstOrFail();
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
