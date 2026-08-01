<?php

namespace Database\Seeders;

use App\Models\HeroSetting;
use Illuminate\Database\Seeder;

class HeroSettingSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['page_slug' => 'beranda', 'page_label' => 'Beranda (Halaman Utama)'],
            ['page_slug' => 'profil', 'page_label' => 'Profil Nagari'],
            ['page_slug' => 'berita', 'page_label' => 'Berita & Artikel'],
            ['page_slug' => 'umkm', 'page_label' => 'UMKM & Produk Desa'],
            ['page_slug' => 'potensi', 'page_label' => 'Potensi Desa'],
            ['page_slug' => 'agenda', 'page_label' => 'Agenda Kegiatan'],
            ['page_slug' => 'lembaga', 'page_label' => 'Lembaga Nagari'],
            ['page_slug' => 'bamus', 'page_label' => 'Badan Musyawarah Nagari'],
            ['page_slug' => 'bansos', 'page_label' => 'Cek Bansos'],
            ['page_slug' => 'donasi', 'page_label' => 'Donasi Nagari'],
            ['page_slug' => 'kehutanan', 'page_label' => 'Data Kehutanan'],
            ['page_slug' => 'ppid', 'page_label' => 'Portal PPID'],
            ['page_slug' => 'bumnag', 'page_label' => 'Portal BUMNag'],
            ['page_slug' => 'infografis', 'page_label' => 'Infografis Kependudukan'],
            ['page_slug' => 'anggaran', 'page_label' => 'Transparansi Anggaran'],
            ['page_slug' => 'idm', 'page_label' => 'Indeks Desa Membangun (IDM)'],
            ['page_slug' => 'surat', 'page_label' => 'Layanan Permohonan Surat'],
            ['page_slug' => 'produk-hukum', 'page_label' => 'Produk Hukum Nagari'],
            ['page_slug' => 'kontak', 'page_label' => 'Kontak Nagari'],
        ];

        foreach ($pages as $page) {
            HeroSetting::updateOrCreate(
                ['page_slug' => $page['page_slug']],
                ['page_label' => $page['page_label']]
            );
        }
    }
}
