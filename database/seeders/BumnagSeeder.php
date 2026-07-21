<?php

namespace Database\Seeders;

use App\Models\BumnagBudget;
use App\Models\BumnagMember;
use App\Models\BumnagProfile;
use App\Models\BumnagProgram;
use Illuminate\Database\Seeder;

class BumnagSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Profil BUMNag ─────────────────────────────────
        BumnagProfile::updateOrCreate(['id' => 1], [
            'name' => 'BUMNag Duo Koto Mandiri',
            'description' => 'BUMNag Duo Koto Mandiri merupakan Badan Usaha Milik Nagari yang didirikan sebagai motor penggerak ekonomi masyarakat Nagari Duo Koto. BUMNag ini bertujuan untuk mengoptimalkan potensi lokal, menciptakan lapangan kerja, dan meningkatkan Pendapatan Asli Nagari melalui pengelolaan unit-unit usaha yang profesional dan berkelanjutan.',
            'sejarah' => "BUMNag Duo Koto Mandiri didirikan pada tahun 2019 berdasarkan hasil Musyawarah Nagari yang dihadiri oleh seluruh unsur masyarakat. Pendirian ini dilatarbelakangi oleh kesadaran kolektif untuk mengoptimalkan potensi sumber daya alam dan manusia di Nagari Duo Koto.\n\nPada awal berdiri, BUMNag hanya mengelola satu unit usaha yaitu pengelolaan wisata Linggai Park. Seiring berjalannya waktu, melihat antusiasme masyarakat dan potensi yang besar, BUMNag kemudian mengembangkan unit usaha lainnya seperti Simpan Pinjam, Pengelolaan Pasar Nagari, dan Pertanian Organik.\n\nPada tahun 2022, BUMNag Duo Koto Mandiri mendapat penghargaan sebagai BUMDes berprestasi tingkat Kabupaten Agam atas keberhasilan mengelola ekowisata dan pemberdayaan masyarakat. Capaian ini semakin memperkuat komitmen BUMNag untuk terus berkontribusi bagi kemajuan nagari.",
            'visi' => 'Menjadi Badan Usaha Milik Nagari yang mandiri, profesional, dan berdaya saing dalam menggerakkan perekonomian masyarakat Nagari Duo Koto.',
            'misi' => "1. Mengembangkan unit-unit usaha yang berbasis potensi lokal nagari\n2. Meningkatkan Pendapatan Asli Nagari melalui pengelolaan aset desa yang produktif\n3. Menciptakan lapangan kerja dan pemberdayaan ekonomi masyarakat\n4. Menerapkan tata kelola usaha yang transparan, akuntabel, dan berkelanjutan\n5. Menjalin kemitraan strategis dengan pihak swasta, pemerintah, dan akademisi",
            'alamat' => 'Jorong Pasar Ahad, Nagari Duo Koto, Kec. Tanjung Raya, Kab. Agam',
            'telepon' => '0752-123789',
            'email' => 'bumnag@duokoto.desa.id',
            'sk_pendirian' => 'No. 188.45/24/KPTS-WN/2019',
            'tanggal_pendirian' => '2019-06-15',
            'unit_usaha' => [
                ['nama' => 'Pengelolaan Wisata (Linggai Park)', 'deskripsi' => 'Mengelola kawasan ekowisata Linggai Park dan Batu Gadang, termasuk tiket masuk, parkir, dan fasilitas wisata.'],
                ['nama' => 'Simpan Pinjam', 'deskripsi' => 'Layanan keuangan mikro untuk masyarakat nagari dengan bunga rendah dan proses mudah.'],
                ['nama' => 'Pengelolaan Pasar Nagari', 'deskripsi' => 'Mengelola Pasar Ahad termasuk retribusi pedagang, kebersihan, dan penataan kios.'],
                ['nama' => 'Pertanian Organik', 'deskripsi' => 'Budidaya dan pemasaran produk pertanian organik seperti padi, sayuran, dan kopi.'],
                ['nama' => 'Jasa Pengolahan Sampah', 'deskripsi' => 'Pengelolaan sampah terpadu di tingkat nagari melalui bank sampah dan daur ulang.'],
            ],
        ]);

        // ─── Anggota / Struktur Organisasi ──────────────────
        $pengurus = [
            ['name' => 'Ir. Ronal Fitrah', 'position' => 'Direktur', 'role_type' => 'pengurus', 'period' => '2024-2029', 'order' => 0],
            ['name' => 'Rina Safitri, S.E.', 'position' => 'Sekretaris', 'role_type' => 'pengurus', 'period' => '2024-2029', 'order' => 1],
            ['name' => 'Hj. Nurlaila, A.Md.', 'position' => 'Bendahara', 'role_type' => 'pengurus', 'period' => '2024-2029', 'order' => 2],
            ['name' => 'Dodi Saputra', 'position' => 'Kepala Unit Wisata', 'role_type' => 'pengurus', 'period' => '2024-2029', 'order' => 3],
            ['name' => 'Siti Rahmah', 'position' => 'Kepala Unit Simpan Pinjam', 'role_type' => 'pengurus', 'period' => '2024-2029', 'order' => 4],
            ['name' => 'Ahmad Zaki', 'position' => 'Kepala Unit Pasar Nagari', 'role_type' => 'pengurus', 'period' => '2024-2029', 'order' => 5],
            ['name' => 'Yeni Marlina', 'position' => 'Kepala Unit Pertanian', 'role_type' => 'pengurus', 'period' => '2024-2029', 'order' => 6],
        ];

        $pengawas = [
            ['name' => 'H. Syamsul Bahri, S.H.', 'position' => 'Ketua Pengawas', 'role_type' => 'pengawas', 'period' => '2024-2029', 'order' => 0],
            ['name' => 'Drs. Mardianto', 'position' => 'Anggota Pengawas', 'role_type' => 'pengawas', 'period' => '2024-2029', 'order' => 1],
            ['name' => 'Hj. Yusnidar', 'position' => 'Anggota Pengawas', 'role_type' => 'pengawas', 'period' => '2024-2029', 'order' => 2],
        ];

        foreach (array_merge($pengurus, $pengawas) as $member) {
            BumnagMember::create(array_merge($member, ['is_active' => true]));
        }

        // ─── Anggaran BUMNag ───────────────────────────────
        BumnagBudget::create([
            'year' => 2024,
            'total_income' => 485000000,
            'total_expenditure' => 420000000,
            'realization_pct' => 86.60,
            'apbdes_data' => [
                'Pendapatan Unit Wisata' => 180000000,
                'Pendapatan Simpan Pinjam' => 95000000,
                'Pendapatan Pasar Nagari' => 120000000,
                'Pendapatan Pertanian Organik' => 55000000,
                'Pendapatan Jasa Sampah' => 35000000,
            ],
            'keterangan' => "Pada tahun 2024, BUMNag Duo Koto Mandiri mencatatkan total pendapatan Rp 485 juta dengan realisasi belanja sebesar Rp 420 juta (86,60%).\n\nPendapatan terbesar berasal dari Unit Wisata (Linggai Park) yang menyumbang 37% dari total pendapatan berkat kenaikan jumlah pengunjung pasca-perbaikan fasilitas. Unit Pasar Nagari menjadi kontributor kedua terbesar (25%) setelah optimalisasi retribusi dan penataan kios.\n\nDari sisi belanja, sebagian besar dialokasikan untuk operasional unit usaha (40%), pemeliharaan aset (25%), gaji pengurus (20%), dan sisanya untuk pengembangan usaha baru serta dana cadangan.",
        ]);

        BumnagBudget::create([
            'year' => 2023,
            'total_income' => 380000000,
            'total_expenditure' => 340000000,
            'realization_pct' => 89.47,
            'apbdes_data' => [
                'Pendapatan Unit Wisata' => 145000000,
                'Pendapatan Simpan Pinjam' => 80000000,
                'Pendapatan Pasar Nagari' => 95000000,
                'Pendapatan Pertanian Organik' => 40000000,
                'Pendapatan Jasa Sampah' => 20000000,
            ],
            'keterangan' => "Tahun 2023 menjadi tahun konsolidasi bagi BUMNag setelah dampak pandemi. Pendapatan tumbuh 15% dibandingkan tahun sebelumnya, didorong oleh pulihnya sektor wisata dan dimulainya unit usaha pengelolaan sampah. Belanja operasional dioptimalkan melalui efisiensi penggunaan sumber daya dan digitalisasi administrasi keuangan.",
        ]);

        // ─── Program Kerja ──────────────────────────────────
        $programs = [
            [
                'nama_kegiatan' => 'Pengembangan Ekowisata Linggai Park',
                'kepala_unit_usaha' => 'Dodi Saputra',
                'keterangan' => 'Program peningkatan fasilitas dan daya tarik wisata Linggai Park meliputi pembangunan toilet umum, gazebo, spot foto baru, serta penataan jalur trekking menuju Air Terjun Kacau.',
                'output_program' => 'Penambahan 5 spot foto baru, 3 gazebo, 2 toilet umum, dan jalur trekking sepanjang 800m. Target kenaikan pengunjung 30%.',
                'kendala' => 'Akses jalan menuju lokasi masih belum seluruhnya beraspal, sehingga menyulitkan kendaraan roda empat saat musim hujan.',
                'penerima_manfaat' => 'Masyarakat Nagari Duo Koto, pelaku usaha wisata, dan pemuda karang taruna',
                'tahun' => 2024,
                'order' => 0,
            ],
            [
                'nama_kegiatan' => 'Penguatan Modal Simpan Pinjam',
                'kepala_unit_usaha' => 'Siti Rahmah',
                'keterangan' => 'Penambahan modal kerja unit simpan pinjam melalui alokasi dana BUMNag dan kerjasama dengan lembaga keuangan mikro untuk memperluas jangkauan layanan kredit bagi masyarakat.',
                'output_program' => 'Penambahan modal Rp 50 juta, peningkatan nasabah aktif dari 120 menjadi 180 orang, dan penurunan NPL di bawah 3%.',
                'kendala' => 'Masih terdapat beberapa nasabah yang menunggak pembayaran cicilan.',
                'penerima_manfaat' => 'Pelaku UMKM dan petani di Nagari Duo Koto',
                'tahun' => 2024,
                'order' => 1,
            ],
            [
                'nama_kegiatan' => 'Revitalisasi Pasar Nagari',
                'kepala_unit_usaha' => 'Ahmad Zaki',
                'keterangan' => 'Renovasi dan penataan kembali Pasar Ahad agar lebih bersih, nyaman, dan teratur. Termasuk pembuatan sistem retribusi digital dan penyediaan cold storage untuk pedagang ikan dan daging.',
                'output_program' => 'Penataan 45 kios, 1 unit cold storage, sistem retribusi digital, dan peningkatan pendapatan retribusi 20%.',
                'kendala' => 'Sebagian pedagang masih enggan untuk berpindah ke kios yang telah ditata ulang karena kebiasaan lokasi lama.',
                'penerima_manfaat' => 'Pedagang Pasar Ahad dan masyarakat pembeli',
                'tahun' => 2024,
                'order' => 2,
            ],
            [
                'nama_kegiatan' => 'Budidaya Padi Organik Bersertifikat',
                'kepala_unit_usaha' => 'Yeni Marlina',
                'keterangan' => 'Pengembangan pertanian padi organik bersertifikat melalui pendampingan teknis kepada kelompok tani, penyediaan pupuk organik, dan pemasaran produk dengan label "Beras Organik Duo Koto".',
                'output_program' => 'Sertifikasi organik untuk 10 ha lahan, peningkatan hasil panen 15%, dan peluncuran brand beras kemasan premium.',
                'kendala' => 'Proses sertifikasi organik membutuhkan waktu lama dan biaya yang cukup besar.',
                'penerima_manfaat' => 'Kelompok tani di Jorong Mudiak dan Jorong Railia',
                'tahun' => 2024,
                'order' => 3,
            ],
            [
                'nama_kegiatan' => 'Program Bank Sampah Nagari',
                'kepala_unit_usaha' => 'Ir. Ronal Fitrah',
                'keterangan' => 'Pengelolaan sampah terpadu melalui pembentukan bank sampah di setiap jorong. Masyarakat diedukasi untuk memilah sampah dan menyetorkan ke bank sampah untuk ditabung atau dijual ke pengepul.',
                'output_program' => 'Pembentukan 5 bank sampah jorong, pengurangan volume sampah ke TPA sebesar 40%, dan penciptaan pendapatan tambahan bagi rumah tangga.',
                'kendala' => 'Tingkat kesadaran masyarakat untuk memilah sampah masih belum merata di semua jorong.',
                'penerima_manfaat' => 'Seluruh masyarakat Nagari Duo Koto',
                'tahun' => 2024,
                'order' => 4,
            ],
            [
                'nama_kegiatan' => 'Pelatihan Kewirausahaan Pemuda',
                'kepala_unit_usaha' => 'Dodi Saputra',
                'keterangan' => 'Pelatihan kewirausahaan bagi pemuda nagari meliputi manajemen bisnis, pemasaran digital, dan pengelolaan keuangan usaha. Diselenggarakan bekerjasama dengan Dinas Koperasi dan UMKM Kabupaten Agam.',
                'output_program' => 'Terlatihnya 30 pemuda dalam kewirausahaan, terbentuknya 10 usaha baru, dan terhubungnya produk lokal ke marketplace digital.',
                'kendala' => null,
                'penerima_manfaat' => 'Pemuda usia 18-35 tahun di Nagari Duo Koto',
                'tahun' => 2024,
                'order' => 5,
            ],
        ];

        foreach ($programs as $program) {
            BumnagProgram::create(array_merge($program, ['is_active' => true]));
        }
    }
}
