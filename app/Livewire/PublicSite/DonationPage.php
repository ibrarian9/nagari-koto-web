<?php

namespace App\Livewire\PublicSite;

use App\Models\DonationCampaign;
use App\Models\VillageProfile;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DonationPage extends Component
{
    #[Layout('layouts.app', ['title' => 'Donasi'])]
    public function render()
    {
        $campaigns = DonationCampaign::active()
            ->withCount(['donations as donor_count' => fn($q) => $q->where('payment_status', 'success')])
            ->latest()
            ->get();

        $village = VillageProfile::first();

        $summary = [
            'total_collected' => DonationCampaign::sum('collected_amount'),
            'total_donors' => \App\Models\Donation::query()->where('payment_status', 'success')->count(),
            'active_campaigns' => DonationCampaign::query()->where('status', 'active')->count(),
        ];

        return view('livewire.public.donation-page', compact('campaigns', 'village', 'summary'));
    }
}
