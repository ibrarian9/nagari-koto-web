<?php

namespace Database\Seeders;

use App\Models\PpidContent;
use Illuminate\Database\Seeder;

class PpidContentSeeder extends Seeder
{
    public function run(): void
    {
        PpidContent::firstOrCreate(['type' => 'profil'], [
            'title'   => 'Profil Singkat PPID',
            'content' => "Pejabat Pengelola Informasi dan Dokumentasi (PPID) Nagari Duo Koto dibentuk berdasarkan amanat Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik dan Peraturan Pemerintah Nomor 61 Tahun 2010 tentang Pelaksanaan UU KIP.\n\nPPID Nagari Duo Koto bertanggung jawab dalam pengelolaan informasi dan dokumentasi di lingkungan Pemerintah Nagari Duo Koto, Kecamatan Tanjung Raya, Kabupaten Agam, Provinsi Sumatera Barat.\n\nPPID Nagari berperan sebagai penghubung antara masyarakat dengan pemerintah nagari dalam hal penyediaan dan pelayanan informasi publik, serta menjamin hak setiap warga negara untuk memperoleh informasi sesuai ketentuan perundang-undangan yang berlaku.",
        ]);

        PpidContent::firstOrCreate(['type' => 'visi_misi'], [
            'title'   => 'Visi & Misi PPID',
            'content' => "VISI\nMewujudkan pelayanan informasi publik yang transparan, akuntabel, dan mudah diakses oleh seluruh masyarakat Nagari Duo Koto.\n\nMISI\n1. Menyelenggarakan pengelolaan informasi dan dokumentasi yang tertib, teratur, dan dapat dipertanggungjawabkan.\n2. Menyediakan akses informasi publik yang mudah, cepat, dan tepat waktu kepada setiap pemohon informasi.\n3. Meningkatkan partisipasi masyarakat dalam pengawasan penyelenggaraan pemerintahan nagari.\n4. Mengembangkan sistem informasi berbasis teknologi untuk mendukung keterbukaan informasi publik.\n5. Melindungi informasi yang dikecualikan sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.",
        ]);

        PpidContent::firstOrCreate(['type' => 'tugas_fungsi'], [
            'title'   => 'Tugas & Fungsi PPID',
            'content' => "TUGAS PPID\nPPID Nagari Duo Koto bertugas mengelola dan memberikan pelayanan informasi publik di lingkungan Pemerintah Nagari sesuai amanat UU No. 14 Tahun 2008.\n\nFUNGSI PPID\n1. Perencanaan — Menyusun kebijakan dan rencana kerja terkait pengelolaan informasi dan dokumentasi.\n2. Pengumpulan — Mengumpulkan, menyimpan, dan mendokumentasikan seluruh informasi publik.\n3. Penyediaan — Menyediakan dan memberikan pelayanan informasi publik kepada pemohon informasi.\n4. Pengklasifikasian — Mengklasifikasikan informasi publik menjadi informasi berkala, setiap saat, serta merta, dan dikecualikan.\n5. Pemeliharaan — Memelihara dan memperbarui Daftar Informasi Publik (DIP) secara berkala.",
        ]);

        PpidContent::firstOrCreate(['type' => 'struktur'], [
            'title'        => 'Struktur Organisasi PPID',
            'content'      => 'Susunan organisasi PPID Nagari Duo Koto ditetapkan berdasarkan Surat Keputusan Wali Nagari.',
            'members_data' => [
                ['name' => 'H. Syafrizal, S.Pd', 'position' => 'Atasan PPID', 'role' => 'Wali Nagari Duo Koto', 'desc' => 'Bertanggung jawab atas kebijakan pengelolaan informasi publik', 'is_leader' => true],
                ['name' => 'Drs. Andi Rahman', 'position' => 'PPID Utama', 'role' => 'Sekretaris Nagari', 'desc' => 'Mengoordinasikan pengelolaan dan pelayanan informasi publik', 'is_leader' => false],
                ['name' => 'Siti Aminah, S.Sos', 'position' => 'PPID Pelaksana', 'role' => 'Kasi Pemerintahan', 'desc' => 'Melaksanakan pelayanan informasi publik', 'is_leader' => false],
                ['name' => 'Rudi Hartono', 'position' => 'Bidang Dokumentasi', 'role' => 'Kaur Umum', 'desc' => 'Mengelola arsip dan dokumentasi', 'is_leader' => false],
                ['name' => 'Nur Hasanah', 'position' => 'Bidang Pelayanan', 'role' => 'Kasi Pelayanan', 'desc' => 'Menerima dan memproses permohonan informasi', 'is_leader' => false],
                ['name' => 'Yuliana, S.E', 'position' => 'Bidang Penyelesaian Sengketa', 'role' => 'Kaur Keuangan', 'desc' => 'Menangani keberatan dan sengketa informasi', 'is_leader' => false],
            ],
        ]);

        // New content types
        PpidContent::firstOrCreate(['type' => 'dikecualikan'], [
            'title'   => 'Informasi yang Dikecualikan',
            'content' => "Berdasarkan UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik, Pasal 17, berikut kategori informasi yang dikecualikan:\n\n1. Informasi yang dapat menghambat proses penegakan hukum\n2. Informasi yang dapat mengganggu kepentingan perlindungan hak atas kekayaan intelektual\n3. Informasi yang dapat membahayakan pertahanan dan keamanan negara\n4. Informasi yang dapat mengungkap kekayaan alam Indonesia\n5. Informasi yang dapat merugikan ketahanan ekonomi nasional\n6. Memorandum atau surat-surat antar badan publik yang bersifat rahasia\n7. Informasi yang tidak boleh diungkap berdasarkan undang-undang\n\nPengecualian informasi dilakukan melalui uji konsekuensi.",
        ]);

        PpidContent::firstOrCreate(['type' => 'alur_informasi'], [
            'title'   => 'Alur Permohonan Informasi',
            'content' => "1. Pemohon mengajukan permohonan informasi melalui formulir online atau datang langsung ke kantor PPID.\n2. PPID menerima, mencatat, dan memberikan tanda bukti penerimaan permohonan.\n3. PPID memproses permohonan dalam waktu paling lambat 10 hari kerja.\n4. PPID dapat memperpanjang waktu paling lambat 7 hari kerja.\n5. PPID memberikan jawaban tertulis kepada pemohon.\n6. Jika ditolak, PPID menyampaikan alasan penolakan secara tertulis.",
        ]);

        PpidContent::firstOrCreate(['type' => 'alur_keberatan'], [
            'title'   => 'Alur Pengajuan Keberatan',
            'content' => "1. Pemohon yang tidak puas atas jawaban PPID dapat mengajukan keberatan kepada Atasan PPID.\n2. Keberatan diajukan dalam waktu paling lambat 30 hari kerja setelah ditemukannya alasan keberatan.\n3. Atasan PPID memberikan tanggapan dalam waktu paling lambat 30 hari kerja.\n4. Jika pemohon tidak puas atas tanggapan Atasan PPID, dapat mengajukan penyelesaian sengketa ke Komisi Informasi.",
        ]);

        PpidContent::firstOrCreate(['type' => 'alur_sengketa'], [
            'title'   => 'Alur Penyelesaian Sengketa',
            'content' => "1. Pemohon mengajukan permohonan penyelesaian sengketa ke Komisi Informasi paling lambat 14 hari kerja setelah tanggapan Atasan PPID.\n2. Komisi Informasi melakukan mediasi dan/atau ajudikasi.\n3. Putusan Komisi Informasi bersifat final dan mengikat.\n4. Pihak yang tidak puas dapat mengajukan gugatan ke Pengadilan Tata Usaha Negara.",
        ]);

        PpidContent::firstOrCreate(['type' => 'maklumat'], [
            'title'   => 'Maklumat Pelayanan',
            'content' => "Dengan ini kami menyatakan, PPID Nagari Duo Koto sanggup menyelenggarakan pelayanan informasi publik sesuai dengan standar pelayanan yang telah ditetapkan dan apabila tidak menepati janji ini, kami siap menerima sanksi sesuai peraturan perundang-undangan yang berlaku.\n\nStandar Pelayanan:\n1. Pelayanan informasi diberikan secara cepat, tepat, dan sederhana.\n2. Biaya perolehan informasi dibebankan kepada pemohon berdasarkan biaya riil.\n3. Waktu penyelesaian permohonan paling lambat 10 hari kerja.\n4. Pelayanan informasi dilaksanakan pada hari dan jam kerja.",
        ]);

        PpidContent::firstOrCreate(['type' => 'jadwal_biaya'], [
            'title'   => 'Jadwal & Biaya Pelayanan Informasi',
            'content' => "JADWAL PELAYANAN\nSenin – Jumat : 08.00 – 16.00 WIB\nSabtu – Minggu : Libur\n\nBIAYA PELAYANAN\nPerolehan informasi publik dikenakan biaya sesuai dengan biaya riil yang dikeluarkan untuk penggandaan dan/atau pengiriman informasi.\n\nInformasi yang diakses melalui website resmi tidak dikenakan biaya.",
        ]);

        PpidContent::firstOrCreate(['type' => 'dasar_hukum'], [
            'title'   => 'Dasar Hukum',
            'content' => "1. UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik\n2. PP No. 61 Tahun 2010 tentang Pelaksanaan UU KIP\n3. Peraturan Komisi Informasi No. 1 Tahun 2010 tentang Standar Layanan Informasi Publik\n4. Permendagri No. 35 Tahun 2010 tentang Pedoman Pengelolaan Pelayanan Informasi dan Dokumentasi di Lingkungan Kementerian Dalam Negeri dan Pemerintah Daerah",
        ]);

        PpidContent::firstOrCreate(['type' => 'sop'], [
            'title'   => 'SOP PPID',
            'content' => "Standar Operasional Prosedur (SOP) Pelayanan Informasi Publik PPID Nagari Duo Koto mengatur tata cara pengelolaan dan pelayanan informasi publik di lingkungan Pemerintah Nagari Duo Koto.\n\nSOP ini mencakup:\n1. Prosedur penerimaan permohonan informasi\n2. Prosedur pencatatan dan pendokumentasian\n3. Prosedur pengujian konsekuensi\n4. Prosedur penyampaian informasi\n5. Prosedur penanganan keberatan\n6. Prosedur pelaporan",
        ]);
    }
}
