<?php

namespace Database\Seeders;

use App\Models\PpidBerkala;
use App\Models\PpidDikecualikan;
use App\Models\PpidPermohonan;
use App\Models\PpidSetiapSaat;
use App\Models\PpidSertaMerta;
use Illuminate\Database\Seeder;

class PpidSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Informasi Berkala ──────────────────────────────
        $berkala = [
            ['title' => 'APBDes Tahun Anggaran 2025', 'category' => 'apbdes', 'year' => 2025, 'description' => 'Anggaran Pendapatan dan Belanja Desa Tahun Anggaran 2025 yang telah disahkan dalam Musyawarah Desa.'],
            ['title' => 'APBDes Tahun Anggaran 2024', 'category' => 'apbdes', 'year' => 2024, 'description' => 'Anggaran Pendapatan dan Belanja Desa Tahun Anggaran 2024.'],
            ['title' => 'RPJMDes Tahun 2025-2030', 'category' => 'rpjmdes', 'year' => 2025, 'description' => 'Rencana Pembangunan Jangka Menengah Desa periode 2025-2030, meliputi visi, misi, dan program prioritas pembangunan nagari.'],
            ['title' => 'RKPDes Tahun 2025', 'category' => 'rkpdes', 'year' => 2025, 'description' => 'Rencana Kerja Pemerintah Desa Tahun 2025 sebagai penjabaran dari RPJMDes.'],
            ['title' => 'Peraturan Desa No. 1 Tahun 2025 tentang Pengelolaan Aset Desa', 'category' => 'perdes', 'year' => 2025, 'description' => 'Peraturan Desa yang mengatur tata cara pengelolaan, pemanfaatan, dan pemeliharaan aset milik desa.'],
            ['title' => 'Peraturan Desa No. 2 Tahun 2024 tentang BUMDes', 'category' => 'perdes', 'year' => 2024, 'description' => 'Peraturan Desa tentang pendirian dan pengelolaan Badan Usaha Milik Desa.'],
            ['title' => 'Laporan Pertanggungjawaban APBDes TA 2024', 'category' => 'laporan_pertanggungjawaban', 'year' => 2024, 'description' => 'Laporan realisasi pelaksanaan APBDes Tahun Anggaran 2024 yang disampaikan kepada BPD.'],
            ['title' => 'Laporan Pertanggungjawaban APBDes TA 2023', 'category' => 'laporan_pertanggungjawaban', 'year' => 2023, 'description' => 'Laporan realisasi pelaksanaan APBDes Tahun Anggaran 2023.'],
        ];

        foreach ($berkala as $item) {
            PpidBerkala::create(array_merge($item, [
                'file_path' => 'ppid/berkala/sample.pdf',
                'file_name' => str()->slug($item['title']) . '.pdf',
                'file_size' => rand(200000, 5000000),
                'download_count' => rand(0, 50),
                'is_published' => true,
                'published_at' => now()->subDays(rand(1, 180)),
            ]));
        }

        // ─── Informasi Setiap Saat ─────────────────────────
        $setiapSaat = [
            ['title' => 'Daftar Informasi Publik (DIP) Nagari Tahun 2025', 'category' => 'dip', 'year' => 2025, 'description' => 'Daftar seluruh informasi publik yang dikelola oleh Pemerintah Nagari beserta klasifikasinya.'],
            ['title' => 'Statistik Kependudukan Nagari 2025', 'category' => 'statistik_desa', 'year' => 2025, 'description' => 'Data statistik jumlah penduduk, komposisi usia, jenis kelamin, pendidikan, dan mata pencaharian.'],
            ['title' => 'Prosedur Pelayanan Administrasi Kependudukan', 'category' => 'prosedur', 'year' => 2025, 'description' => 'Standar Operasional Prosedur (SOP) pengurusan surat-surat kependudukan di kantor nagari.'],
            ['title' => 'Prosedur Permohonan Informasi Publik', 'category' => 'prosedur', 'year' => 2025, 'description' => 'Tata cara mengajukan permohonan informasi publik melalui PPID Nagari.'],
            ['title' => 'Perjanjian Kerjasama Nagari dengan Dinas Kehutanan', 'category' => 'perjanjian', 'year' => 2024, 'description' => 'Naskah perjanjian kerjasama pengelolaan hutan nagari antara pemerintah nagari dengan Dinas Kehutanan Provinsi.'],
            ['title' => 'Data Potensi Ekonomi Nagari 2024', 'category' => 'statistik_desa', 'year' => 2024, 'description' => 'Pemetaan potensi ekonomi desa meliputi pertanian, perkebunan, UMKM, dan pariwisata.'],
        ];

        foreach ($setiapSaat as $item) {
            PpidSetiapSaat::create(array_merge($item, [
                'file_path' => 'ppid/setiap-saat/sample.pdf',
                'file_name' => str()->slug($item['title']) . '.pdf',
                'file_size' => rand(150000, 3000000),
                'download_count' => rand(0, 30),
                'is_published' => true,
                'published_at' => now()->subDays(rand(1, 120)),
            ]));
        }

        // ─── Informasi Serta Merta ─────────────────────────
        $sertaMerta = [
            [
                'title' => 'Peringatan Cuaca Ekstrem — Hujan Lebat dan Angin Kencang',
                'content' => '<p>Berdasarkan informasi dari BMKG, wilayah nagari dan sekitarnya diperkirakan akan mengalami <strong>hujan lebat disertai angin kencang</strong> dalam 3 hari ke depan.</p><h4>Himbauan:</h4><ul><li>Waspada terhadap potensi banjir dan longsor</li><li>Hindari aktivitas di luar rumah saat hujan lebat</li><li>Pastikan saluran air di sekitar rumah tidak tersumbat</li><li>Hubungi posko darurat di nomor <strong>0751-XXXXXXX</strong> jika membutuhkan bantuan</li></ul>',
                'urgency' => 'tinggi',
                'is_active' => true,
            ],
            [
                'title' => 'Jadwal Fogging DBD di Jorong Koto Tinggi',
                'content' => '<p>Dinas Kesehatan Kabupaten bersama Puskesmas akan melaksanakan <strong>fogging (pengasapan) nyamuk demam berdarah</strong> di wilayah Jorong Koto Tinggi.</p><h4>Detail:</h4><ul><li><strong>Tanggal:</strong> 25-26 Mei 2026</li><li><strong>Waktu:</strong> 07:00 - 10:00 WIB</li><li><strong>Area:</strong> RT 01 - RT 05 Jorong Koto Tinggi</li></ul><p>Warga diminta untuk <strong>menutup makanan dan minuman</strong> serta <strong>mengungsikan hewan peliharaan</strong> selama proses fogging berlangsung.</p>',
                'urgency' => 'sedang',
                'is_active' => true,
            ],
            [
                'title' => 'Pengumuman Pemadaman Listrik Bergilir',
                'content' => '<p>PLN Area Solok memberitahukan akan dilakukan <strong>pemadaman listrik terencana</strong> untuk pemeliharaan jaringan.</p><ul><li><strong>Tanggal:</strong> 20 Mei 2026</li><li><strong>Pukul:</strong> 09:00 - 15:00 WIB</li><li><strong>Wilayah:</strong> Seluruh nagari</li></ul><p>Mohon maaf atas ketidaknyamanan ini. Warga diminta mempersiapkan kebutuhan selama pemadaman.</p>',
                'urgency' => 'rendah',
                'is_active' => false,
            ],
        ];

        foreach ($sertaMerta as $item) {
            PpidSertaMerta::create(array_merge($item, [
                'published_at' => now()->subDays(rand(1, 30)),
            ]));
        }

        // ─── Informasi Dikecualikan (default content) ──────
        PpidDikecualikan::getContent(); // Creates default record if not exists

        // ─── Permohonan (sample) ───────────────────────────
        $permohonan = [
            [
                'nama_pemohon' => 'Ahmad Rizki',
                'nik' => '1304012345678901',
                'no_telepon' => '081234567890',
                'email' => 'ahmad.rizki@email.com',
                'alamat' => 'Jorong Koto Tinggi, RT 02/RW 01, Nagari Duo Koto',
                'informasi_diminta' => 'Data realisasi APBDes tahun 2024, khususnya alokasi dana untuk pembangunan infrastruktur jalan dan irigasi.',
                'tujuan_penggunaan' => 'Untuk bahan penelitian tugas akhir program studi Administrasi Publik.',
                'format_informasi' => 'softcopy',
                'cara_mendapatkan' => 'email',
                'status' => 'selesai',
                'catatan_petugas' => 'Data telah disiapkan dan dikirim via email pada tanggal 10 Mei 2026.',
                'tanggal_selesai' => now()->subDays(15),
            ],
            [
                'nama_pemohon' => 'Siti Nurhaliza',
                'nik' => '1304019876543210',
                'no_telepon' => '082198765432',
                'email' => null,
                'alamat' => 'Jorong Koto Rendah, RT 03/RW 02, Nagari Duo Koto',
                'informasi_diminta' => 'Prosedur dan persyaratan pengurusan surat keterangan domisili untuk keperluan pendaftaran sekolah anak.',
                'tujuan_penggunaan' => 'Untuk melengkapi persyaratan pendaftaran sekolah anak di kota.',
                'format_informasi' => 'hardcopy',
                'cara_mendapatkan' => 'mengambil_langsung',
                'status' => 'diproses',
                'catatan_petugas' => 'Sedang disiapkan, dapat diambil hari Jumat.',
            ],
            [
                'nama_pemohon' => 'Budi Santoso',
                'nik' => '1304015566778899',
                'no_telepon' => '085377889900',
                'email' => 'budi.s@email.com',
                'alamat' => 'Jorong Padang Laweh, Nagari Duo Koto',
                'informasi_diminta' => 'Data statistik kependudukan nagari tahun 2024-2025, meliputi jumlah KK, penduduk per jorong, dan komposisi usia.',
                'tujuan_penggunaan' => 'Untuk keperluan proposal program CSR perusahaan.',
                'format_informasi' => 'keduanya',
                'cara_mendapatkan' => 'email',
                'status' => 'menunggu',
            ],
        ];

        foreach ($permohonan as $item) {
            PpidPermohonan::create(array_merge($item, [
                'nomor_permohonan' => PpidPermohonan::generateNomorPermohonan(),
            ]));
        }
    }
}
