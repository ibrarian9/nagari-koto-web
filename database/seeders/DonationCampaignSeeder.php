<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\DonationCampaign;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DonationCampaignSeeder extends Seeder
{
    public function run(): void
    {
        $creator = User::query()->where('role', 'super_admin')->first() ?? User::first();

        $campaigns = [
            [
                'title'         => 'Renovasi Mushalla Nurul Iman',
                'description'   => "Mushalla Nurul Iman di Jorong Koto Tinggi membutuhkan renovasi menyeluruh. Atap yang sudah bocor di beberapa titik, lantai yang mulai retak, serta fasilitas wudhu yang perlu diperbaiki.\n\nDana yang terkumpul akan digunakan untuk:\n- Penggantian atap (Rp 15.000.000)\n- Perbaikan lantai dan dinding (Rp 10.000.000)\n- Renovasi tempat wudhu (Rp 5.000.000)\n- Cat dan finishing (Rp 5.000.000)\n\nMari bersama-sama kita bangun kembali mushalla ini agar tetap menjadi tempat ibadah yang nyaman bagi warga.",
                'target_amount' => 35000000,
                'collected_amount' => 12500000,
                'start_date'    => now()->subDays(15),
                'end_date'      => now()->addDays(45),
                'status'        => 'active',
            ],
            [
                'title'         => 'Beasiswa Anak Nagari 2025',
                'description'   => "Program beasiswa untuk anak-anak nagari berprestasi dari keluarga kurang mampu. Beasiswa mencakup biaya sekolah, seragam, buku, dan perlengkapan belajar.\n\nTarget: 20 anak penerima beasiswa\nJumlah per anak: Rp 2.500.000/tahun\n\nPersyaratan penerima:\n- Warga nagari\n- Prestasi akademik minimal peringkat 10 besar\n- Berasal dari keluarga kurang mampu (diverifikasi)\n- Aktif dalam kegiatan kemasyarakatan",
                'target_amount' => 50000000,
                'collected_amount' => 28750000,
                'start_date'    => now()->subDays(30),
                'end_date'      => now()->addDays(60),
                'status'        => 'active',
            ],
            [
                'title'         => 'Pembangunan Jalan Tani Jorong Padang Laweh',
                'description'   => "Pembangunan jalan tani sepanjang 500 meter menuju area persawahan di Jorong Padang Laweh. Jalan ini akan memudahkan petani dalam mengangkut hasil panen dan sarana produksi pertanian.\n\nSpesifikasi:\n- Panjang: 500 meter\n- Lebar: 3 meter\n- Material: Rabat beton\n- Estimasi pengerjaan: 2 bulan",
                'target_amount' => 75000000,
                'collected_amount' => 5000000,
                'start_date'    => now()->subDays(5),
                'end_date'      => now()->addDays(90),
                'status'        => 'active',
            ],
        ];

        foreach ($campaigns as $data) {
            $campaign = DonationCampaign::create(array_merge($data, [
                'slug'       => Str::slug($data['title']) . '-' . Str::random(5),
                'created_by' => $creator->id,
            ]));

            // Create sample donations for campaigns with collected amount
            if ($campaign->collected_amount > 0) {
                $this->createSampleDonations($campaign);
            }
        }
    }

    private function createSampleDonations(DonationCampaign $campaign): void
    {
        $donors = [
            ['name' => 'Ahmad Fauzi', 'amount' => 500000, 'message' => 'Semoga bermanfaat untuk nagari kita'],
            ['name' => 'Siti Nurhaliza', 'amount' => 250000, 'message' => 'Bismillah, semoga berkah'],
            ['name' => 'Hamba Allah', 'amount' => 1000000, 'message' => null, 'anonymous' => true],
            ['name' => 'Ir. Yusrizal', 'amount' => 2000000, 'message' => 'Untuk kemajuan nagari'],
            ['name' => 'Rina Oktavia', 'amount' => 100000, 'message' => 'Sedikit dari saya'],
            ['name' => 'H. Syamsul Bahri', 'amount' => 5000000, 'message' => 'Semoga segera terwujud'],
            ['name' => 'Hamba Allah', 'amount' => 750000, 'message' => null, 'anonymous' => true],
            ['name' => 'Dian Permata', 'amount' => 150000, 'message' => 'Bismillah'],
        ];

        $remaining = (int) $campaign->collected_amount;

        foreach ($donors as $donor) {
            if ($remaining <= 0) break;

            $amount = min($donor['amount'], $remaining);
            $remaining -= $amount;

            Donation::create([
                'campaign_id'    => $campaign->id,
                'order_id'       => 'DON-SEED-' . strtoupper(Str::random(8)),
                'donor_name'     => $donor['name'],
                'donor_email'    => strtolower(Str::slug($donor['name'])) . '@email.com',
                'amount'         => $amount,
                'message'        => $donor['message'],
                'is_anonymous'   => $donor['anonymous'] ?? false,
                'payment_status' => 'success',
                'payment_type'   => collect(['bank_transfer', 'gopay', 'qris', 'shopeepay'])->random(),
                'paid_at'        => now()->subDays(rand(1, 15))->subHours(rand(1, 12)),
            ]);
        }
    }
}
