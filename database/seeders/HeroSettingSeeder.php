<?php

namespace Database\Seeders;

use App\Models\HeroSetting;
use Illuminate\Database\Seeder;

class HeroSettingSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['page_slug' => 'agenda', 'page_label' => 'Agenda Kegiatan'],
            ['page_slug' => 'bamus', 'page_label' => 'Badan Musyawarah Nagari'],
            ['page_slug' => 'bansos', 'page_label' => 'Cek Bansos'],
            ['page_slug' => 'donasi', 'page_label' => 'Donasi'],
            ['page_slug' => 'kehutanan', 'page_label' => 'Data Kehutanan'],
            ['page_slug' => 'lembaga', 'page_label' => 'Lembaga Nagari'],
            ['page_slug' => 'berita', 'page_label' => 'Berita & Artikel'],
            ['page_slug' => 'umkm', 'page_label' => 'UMKM & Produk Desa'],
            ['page_slug' => 'potensi', 'page_label' => 'Potensi Desa'],
        ];

        foreach ($pages as $page) {
            HeroSetting::firstOrCreate(
                ['page_slug' => $page['page_slug']],
                $page
            );
        }
    }
}
