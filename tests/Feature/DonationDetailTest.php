<?php

use App\Livewire\PublicSite\DonationDetail;
use App\Livewire\PublicSite\DonationPage;
use App\Models\Donation;
use App\Models\DonationCampaign;
use App\Models\DonationSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('renders public donation page with active campaigns', function () {
    $user = User::factory()->create();

    $campaign = DonationCampaign::create([
        'title' => 'Renovasi Jembatan Nagari',
        'slug' => 'renovasi-jembatan-nagari',
        'description' => 'Program penggalangan dana perbaikan jembatan utama nagari.',
        'target_amount' => 50000000,
        'collected_amount' => 15000000,
        'start_date' => now()->subDays(5),
        'end_date' => now()->addDays(25),
        'status' => 'active',
        'created_by' => $user->id,
    ]);

    Livewire::test(DonationPage::class)
        ->assertStatus(200)
        ->assertSee('Donasi untuk Nagari')
        ->assertSee('Renovasi Jembatan Nagari')
        ->assertSee('Rp 15.000.000')
        ->assertSee('30%');
});

it('renders public donation detail page with campaign information and bank accounts', function () {
    $user = User::factory()->create();

    $campaign = DonationCampaign::create([
        'title' => 'Bantuan Korban Banjir Bandang',
        'slug' => 'bantuan-korban-banjir-bandang',
        'description' => 'Bantuan logistik dan sembako untuk warga terdampak banjir.',
        'target_amount' => 20000000,
        'collected_amount' => 5000000,
        'start_date' => now()->subDays(2),
        'end_date' => now()->addDays(10),
        'status' => 'active',
        'created_by' => $user->id,
    ]);

    Donation::create([
        'campaign_id' => $campaign->id,
        'order_id' => 'DON-2026-001',
        'donor_name' => 'Hamba Allah',
        'donor_email' => 'donor@example.com',
        'donor_phone' => '08123456789',
        'amount' => 1000000,
        'payment_status' => 'success',
        'is_anonymous' => false,
        'message' => 'Semoga lekas pulih dan bermanfaat untuk warga.',
        'paid_at' => now(),
    ]);

    DonationSetting::firstOrCreate([], [
        'bank_accounts' => [
            ['bank' => 'Bank Nagari', 'account_number' => '2100021012345', 'account_name' => 'Nagari Koto Peduli'],
        ],
        'transfer_instructions' => 'Harap sertakan kode unik atau konfirmasi transfer ke bendahara nagari.',
    ]);

    Livewire::test(DonationDetail::class, ['slug' => $campaign->slug])
        ->assertStatus(200)
        ->assertSee('Bantuan Korban Banjir Bandang')
        ->assertSee('Rp 5.000.000')
        ->assertSee('25%')
        ->assertSee('Cara Berdonasi')
        ->assertSee('Bank Nagari')
        ->assertSee('2100021012345')
        ->assertSee('Nagari Koto Peduli')
        ->assertSee('Harap sertakan kode unik')
        ->assertSee('Hamba Allah')
        ->assertSee('Rp 1.000.000')
        ->assertSee('Semoga lekas pulih');
});
