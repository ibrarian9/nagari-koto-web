<?php

namespace Database\Seeders;

use App\Models\ForestryRecord;
use Illuminate\Database\Seeder;

class ForestryRecordSeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            // Hutan Lindung
            [
                'title'       => 'Hutan Lindung Bukit Barisan',
                'category'    => 'hutan_lindung',
                'area_ha'     => 450.50,
                'location'    => 'Jorong Koto Tinggi',
                'description' => 'Kawasan hutan lindung yang berada di lereng Bukit Barisan. Berfungsi sebagai perlindungan sistem penyangga kehidupan, pengatur tata air, dan pencegah banjir serta erosi. Keanekaragaman hayati tinggi dengan berbagai jenis flora dan fauna endemik.',
                'status'      => 'aktif',
                'year'        => 2024,
            ],
            [
                'title'       => 'Hutan Lindung Rimba Panti',
                'category'    => 'hutan_lindung',
                'area_ha'     => 320.00,
                'location'    => 'Jorong Lubuk Gadang',
                'description' => 'Kawasan hutan lindung yang menjadi sumber mata air utama untuk irigasi pertanian dan kebutuhan air bersih warga. Terdapat beberapa titik mata air yang dialirkan ke pemukiman penduduk.',
                'status'      => 'aktif',
                'year'        => 2024,
            ],

            // Hutan Produksi
            [
                'title'       => 'Hutan Produksi Terbatas Batang Kapas',
                'category'    => 'hutan_produksi',
                'area_ha'     => 180.75,
                'location'    => 'Jorong Padang Laweh',
                'description' => 'Hutan produksi terbatas yang dikelola secara berkelanjutan. Hasil hutan berupa kayu olahan, rotan, dan hasil hutan bukan kayu lainnya. Penebangan dilakukan secara selektif dengan sistem tebang pilih.',
                'status'      => 'aktif',
                'year'        => 2024,
            ],
            [
                'title'       => 'Hutan Produksi Nagari',
                'category'    => 'hutan_produksi',
                'area_ha'     => 95.30,
                'location'    => 'Jorong Koto Baru',
                'description' => 'Kawasan hutan produksi yang dikelola oleh masyarakat nagari secara partisipatif. Menghasilkan kayu sengon, mahoni, dan jati untuk kebutuhan konstruksi lokal.',
                'status'      => 'aktif',
                'year'        => 2024,
            ],

            // Hutan Rakyat
            [
                'title'       => 'Hutan Rakyat Kampung Dalam',
                'category'    => 'hutan_rakyat',
                'area_ha'     => 75.00,
                'location'    => 'Jorong Kampung Dalam',
                'description' => 'Hutan yang ditanam dan dikelola oleh masyarakat di tanah milik. Jenis tanaman utama: kayu manis (cassia vera), karet, dan durian. Menjadi sumber pendapatan utama bagi 45 kepala keluarga.',
                'status'      => 'aktif',
                'year'        => 2025,
            ],
            [
                'title'       => 'Kebun Hutan Rakyat Sungai Batang',
                'category'    => 'hutan_rakyat',
                'area_ha'     => 52.40,
                'location'    => 'Jorong Sungai Batang',
                'description' => 'Agroforestri berbasis karet dan kopi Arabika. Dikelola oleh kelompok tani hutan dengan pola tanam tumpang sari untuk optimalisasi lahan.',
                'status'      => 'aktif',
                'year'        => 2025,
            ],

            // Lahan Kritis
            [
                'title'       => 'Lahan Kritis Bukik Tapian',
                'category'    => 'lahan_kritis',
                'area_ha'     => 35.20,
                'location'    => 'Jorong Koto Tinggi',
                'description' => 'Lahan kritis akibat pembukaan lahan tidak terkendali pada tahun 2018-2020. Tingkat erosi tinggi, vegetasi penutup tanah kurang dari 30%. Rawan longsor pada musim hujan.',
                'status'      => 'kritis',
                'year'        => 2024,
            ],
            [
                'title'       => 'Lahan Kritis Bekas Galian C',
                'category'    => 'lahan_kritis',
                'area_ha'     => 12.80,
                'location'    => 'Jorong Padang Laweh',
                'description' => 'Bekas area penambangan galian C yang belum direhabilitasi sepenuhnya. Tutupan tanah sangat rendah dan struktur tanah tidak stabil.',
                'status'      => 'kritis',
                'year'        => 2024,
            ],

            // Rehabilitasi
            [
                'title'       => 'Rehabilitasi Hutan DAS Batang Duo Koto',
                'category'    => 'rehabilitasi',
                'area_ha'     => 28.50,
                'location'    => 'Jorong Lubuk Gadang',
                'description' => 'Program rehabilitasi Daerah Aliran Sungai (DAS) melalui penanaman 10.000 bibit pohon (sengon, mahoni, dan trembesi). Kerjasama dengan Dinas Kehutanan Kabupaten dan kelompok tani hutan. Target selesai 2026.',
                'status'      => 'dalam_pemulihan',
                'year'        => 2025,
            ],
            [
                'title'       => 'Rehabilitasi Lahan Kritis Bukit Sago',
                'category'    => 'rehabilitasi',
                'area_ha'     => 18.60,
                'location'    => 'Jorong Koto Tinggi',
                'description' => 'Upaya pemulihan lahan kritis dengan metode terasering dan penanaman tanaman penutup tanah. Sudah berjalan 2 tahun dengan tingkat keberhasilan tumbuh 78%. Didanai dari Dana Desa 2023-2025.',
                'status'      => 'dalam_pemulihan',
                'year'        => 2025,
            ],
        ];

        foreach ($records as $record) {
            ForestryRecord::create($record);
        }
    }
}
