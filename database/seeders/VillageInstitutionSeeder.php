<?php

namespace Database\Seeders;

use App\Models\VillageInstitution;
use Illuminate\Database\Seeder;

class VillageInstitutionSeeder extends Seeder
{
    public function run(): void
    {
        $institutions = [
            [
                'name'             => 'Kerapatan Adat Nagari (KAN)',
                'type'             => 'adat',
                'head_name'        => 'Dt. Mangkuto Alam',
                'description'      => 'Lembaga adat tertinggi di nagari yang bertugas memelihara dan mengembangkan adat istiadat Minangkabau. KAN menyelesaikan sengketa adat, melestarikan budaya, dan menjadi penasehat pemerintahan nagari.',
                'established_year' => 1985,
                'order'            => 0,
            ],
            [
                'name'             => 'Tim Penggerak PKK',
                'type'             => 'perempuan',
                'head_name'        => 'Hj. Srimuliani',
                'description'      => 'Organisasi kemasyarakatan yang memberdayakan perempuan untuk meningkatkan kesejahteraan keluarga. Program utama meliputi 10 program pokok PKK: penghayatan Pancasila, gotong royong, pangan, sandang, perumahan, pendidikan, kesehatan, koperasi, kelestarian lingkungan, dan perencanaan sehat.',
                'contact'          => '081234567890',
                'established_year' => 1990,
                'order'            => 1,
            ],
            [
                'name'             => 'Karang Taruna',
                'type'             => 'kepemudaan',
                'head_name'        => 'Reza Fadillah',
                'description'      => 'Organisasi kepemudaan yang bergerak di bidang kesejahteraan sosial, pemberdayaan pemuda, dan pengembangan potensi generasi muda. Aktif menyelenggarakan kegiatan olahraga, seni budaya, dan pelatihan kewirausahaan.',
                'contact'          => '085678901234',
                'established_year' => 2005,
                'order'            => 2,
            ],
            [
                'name'             => 'LPMN (Lembaga Pemberdayaan Masyarakat Nagari)',
                'type'             => 'sosial',
                'head_name'        => 'Ir. Harmanto',
                'description'      => 'Lembaga yang bertugas menyusun rencana pembangunan secara partisipatif, menggerakkan swadaya gotong royong, dan melaksanakan pengendalian pembangunan di tingkat nagari.',
                'established_year' => 2000,
                'order'            => 3,
            ],
            [
                'name'             => 'Majelis Ulama Nagari',
                'type'             => 'keagamaan',
                'head_name'        => 'H. Abdul Rahman, Lc.',
                'description'      => 'Lembaga keagamaan yang memberikan bimbingan dan pembinaan kehidupan beragama. Mengelola kegiatan pengajian rutin, peringatan hari besar Islam, dan koordinasi imam masjid/mushalla di seluruh jorong.',
                'established_year' => 1995,
                'order'            => 4,
            ],
            [
                'name'             => 'Bundo Kanduang',
                'type'             => 'adat',
                'head_name'        => 'Hj. Nurbaiti',
                'description'      => 'Lembaga adat yang mewakili kaum perempuan dalam sistem matrilineal Minangkabau. Berperan dalam pelestarian adat, penyelesaian masalah rumah gadang, dan pembinaan generasi muda dari sisi adat istiadat.',
                'established_year' => 1988,
                'order'            => 5,
            ],
            [
                'name'             => 'Remaja Masjid Al-Ikhlas',
                'type'             => 'keagamaan',
                'head_name'        => 'Ahmad Fauzi',
                'description'      => 'Organisasi pemuda masjid yang aktif dalam kegiatan dakwah, tahfidz Al-Quran, dan pembinaan akhlak remaja. Menyelenggarakan pesantren kilat Ramadhan dan lomba keagamaan tingkat nagari.',
                'established_year' => 2010,
                'order'            => 6,
            ],
            [
                'name'             => 'Kelompok Sadar Wisata (Pokdarwis)',
                'type'             => 'sosial',
                'head_name'        => 'Indra Pratama',
                'description'      => 'Kelompok masyarakat yang berperan dalam pengembangan dan pengelolaan potensi wisata nagari. Aktif mempromosikan destinasi wisata lokal dan mengelola homestay desa.',
                'established_year' => 2018,
                'order'            => 7,
            ],
        ];

        foreach ($institutions as $inst) {
            VillageInstitution::create(array_merge($inst, ['is_active' => true]));
        }
    }
}
