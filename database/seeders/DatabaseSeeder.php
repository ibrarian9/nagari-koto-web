<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\BudgetStat;
use App\Models\Category;
use App\Models\Contact;
use App\Models\GovernmentMember;
use App\Models\IdmStat;
use App\Models\PopulationStat;
use App\Models\Post;
use App\Models\Potential;
use App\Models\Product;
use App\Models\User;
use App\Models\VillageProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Users ──────────────────────────────────────────
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@nagari-koto.desa.id',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Operator Desa',
            'email' => 'operator@nagari-koto.desa.id',
            'password' => Hash::make('password'),
            'role' => 'operator',
            'is_active' => true,
        ]);

        $warga = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'is_active' => true,
        ]);

        // ─── Village Profile ────────────────────────────────
        VillageProfile::create([
            'name' => 'Nagari Duo Koto',
            'tagline' => 'Adat basandi syarak, syarak basandi Kitabullah',
            'history' => '<p>Nagari Duo Koto merupakan salah satu nagari di Kecamatan Tanjung Raya, Kabupaten Agam, Provinsi Sumatera Barat. Nagari ini memiliki masyarakat yang menjunjung tinggi nilai-nilai Islam dan adat Minangkabau. Terdiri dari 5 jorong yaitu Koto Tinggi, Mudiak, Pasar Ahad, Railia, dan Tanjuang Batuang. Nagari ini memiliki potensi wisata seperti Linggai Park, Batu Gadang, dan Air Terjun Kacau.</p>',
            'vision' => '<p>Terwujudnya Nagari Duo Koto yang maju, mandiri, dan berkeadilan berdasarkan nilai-nilai adat dan agama.</p>',
            'mission' => '<ol><li>Meningkatkan kualitas pelayanan publik berbasis teknologi</li><li>Mendorong pembangunan ekonomi lokal yang berkelanjutan</li><li>Melestarikan budaya dan adat istiadat Minangkabau</li><li>Mewujudkan pemerintahan nagari yang transparan dan akuntabel</li><li>Meningkatkan kualitas sumber daya manusia</li></ol>',
            'address' => 'Jorong Pasar Ahad, Nagari Duo Koto, Kec. Tanjung Raya, Kab. Agam, Sumatera Barat 26471',
            'province' => 'Sumatera Barat',
            'regency' => 'Kabupaten Agam',
            'district' => 'Tanjung Raya',
            'village_code' => '1306032007',
            'area_ha' => 1169,
            'established_year' => 1820,
            'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15959.35!2d100.35!3d-0.31!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sBukittinggi!5e0!3m2!1sid!2sid!4v1700000000000',
        ]);

        // ─── Government Members ─────────────────────────────
        $positions = [
            ['name' => 'H. Syafrizal, S.Pd', 'position' => 'Wali Nagari', 'order' => 1],
            ['name' => 'Drs. Andi Rahman', 'position' => 'Sekretaris Nagari', 'order' => 2],
            ['name' => 'Yuliana, S.E', 'position' => 'Kaur Keuangan', 'order' => 3],
            ['name' => 'Rudi Hartono', 'position' => 'Kaur Umum', 'order' => 4],
            ['name' => 'Siti Aminah, S.Sos', 'position' => 'Kasi Pemerintahan', 'order' => 5],
            ['name' => 'Eko Prasetyo', 'position' => 'Kasi Kesejahteraan', 'order' => 6],
            ['name' => 'Nur Hasanah', 'position' => 'Kasi Pelayanan', 'order' => 7],
            ['name' => 'Bambang Widodo', 'position' => 'Kepala Jorong Koto', 'order' => 8],
        ];
        foreach ($positions as $p) {
            GovernmentMember::create(array_merge($p, ['is_active' => true]));
        }

        // ─── Categories ─────────────────────────────────────
        $categories = [];
        foreach (['Pengumuman', 'Pembangunan', 'Kegiatan', 'Pendidikan', 'Kesehatan'] as $name) {
            $categories[] = Category::create(['name' => $name, 'slug' => Str::slug($name), 'type' => 'berita']);
        }

        // ─── Posts (8 berita) ────────────────────────────────
        $posts = [
            ['title' => 'Pembangunan Jalan Baru Jorong Koto Tinggi Selesai Tepat Waktu', 'excerpt' => 'Proyek pembangunan jalan sepanjang 2 km di Jorong Koto Tinggi telah rampung.', 'body' => '<p>Pembangunan jalan baru di Jorong Koto Tinggi yang menghubungkan kawasan permukiman dengan area pertanian telah resmi selesai. Proyek senilai Rp 450 juta ini didanai dari Dana Desa tahun anggaran 2024.</p><p>Wali Nagari H. Syafrizal menyatakan bahwa infrastruktur jalan ini akan mempermudah akses warga ke lahan pertanian dan pasar tradisional.</p>'],
            ['title' => 'Pelatihan Keterampilan Digital untuk Pemuda Nagari', 'excerpt' => 'Program pelatihan literasi digital diikuti oleh 50 pemuda dari berbagai jorong.', 'body' => '<p>Pemerintah Nagari Duo Koto bekerja sama dengan Dinas Kominfo Kabupaten Agam menyelenggarakan pelatihan keterampilan digital selama 3 hari. Pelatihan ini mencakup desain grafis, pemasaran digital, dan pengelolaan media sosial.</p>'],
            ['title' => 'Posyandu Balita dan Lansia Jadwal Bulan Ini', 'excerpt' => 'Jadwal pelaksanaan posyandu di seluruh jorong bulan ini telah dirilis.', 'body' => '<p>Posyandu rutin bulan ini akan dilaksanakan serentak di seluruh jorong pada tanggal 15-20. Setiap posyandu menyediakan layanan pemeriksaan kesehatan, pemberian vitamin, dan imunisasi dasar lengkap.</p>'],
            ['title' => 'Renovasi Surau Bersejarah di Jorong Mudiak Dimulai', 'excerpt' => 'Surau tua peninggalan abad ke-19 di Jorong Mudiak mulai direnovasi dengan anggaran Rp 200 juta.', 'body' => '<p>Pemerintah Nagari Duo Koto memulai renovasi surau bersejarah di Jorong Mudiak yang diperkirakan telah berusia lebih dari 150 tahun. Renovasi ini bertujuan melestarikan warisan budaya sekaligus menjadikannya pusat edukasi keagamaan bagi generasi muda.</p><p>Dana renovasi berasal dari gabungan Dana Desa dan swadaya masyarakat.</p>'],
            ['title' => 'Penyaluran Bantuan Sosial Tahap II Tahun 2024', 'excerpt' => 'Sebanyak 120 KPM di Nagari Duo Koto menerima bantuan PKH dan BPNT.', 'body' => '<p>Penyaluran bantuan sosial tahap kedua tahun 2024 telah dilaksanakan di Kantor Wali Nagari Duo Koto. Total 120 Keluarga Penerima Manfaat (KPM) menerima bantuan melalui program PKH dan BPNT.</p><p>Wali Nagari memastikan distribusi berjalan transparan dan tepat sasaran.</p>'],
            ['title' => 'Linggai Park Raih Penghargaan Desa Wisata Tingkat Kabupaten', 'excerpt' => 'Objek wisata Linggai Park berhasil meraih penghargaan sebagai desa wisata terbaik di Kabupaten Agam.', 'body' => '<p>Linggai Park yang terletak di Nagari Duo Koto berhasil meraih penghargaan Desa Wisata Terbaik tingkat Kabupaten Agam tahun 2024. Penghargaan ini diberikan atas keberhasilan mengelola potensi wisata alam dengan konsep ekowisata berbasis masyarakat.</p>'],
            ['title' => 'Musyawarah Nagari Tetapkan Prioritas Pembangunan 2025', 'excerpt' => 'Musyawarah nagari menetapkan 5 program prioritas pembangunan untuk tahun 2025.', 'body' => '<p>Musyawarah Nagari (Musnag) Duo Koto yang dihadiri seluruh unsur masyarakat telah menetapkan lima program prioritas pembangunan tahun 2025, meliputi: (1) pembangunan drainase Jorong Railia, (2) rehabilitasi jalan usaha tani, (3) pengadaan alat pertanian modern, (4) pembangunan PAUD di Jorong Tanjuang Batuang, dan (5) pengembangan kawasan wisata Air Terjun Kacau.</p>'],
            ['title' => 'Vaksinasi Hewan Ternak Gratis di Seluruh Jorong', 'excerpt' => 'Dinas Peternakan Kab. Agam melaksanakan vaksinasi gratis untuk ternak sapi dan kerbau.', 'body' => '<p>Dinas Peternakan Kabupaten Agam bersama Pemerintah Nagari Duo Koto melaksanakan program vaksinasi hewan ternak gratis di seluruh jorong. Program ini menargetkan 500 ekor sapi dan kerbau milik warga untuk pencegahan penyakit mulut dan kuku (PMK).</p>'],
        ];
        foreach ($posts as $i => $p) {
            Post::create(array_merge($p, [
                'category_id' => $categories[$i % count($categories)]->id,
                'user_id' => 1,
                'slug' => Str::slug($p['title']),
                'status' => 'published',
                'published_at' => now()->subDays($i * 4),
                'views' => rand(80, 800),
            ]));
        }

        // ─── Potentials (6 potensi) ─────────────────────────
        $potentials = [
            ['category' => 'agriculture', 'title' => 'Padi Organik Duo Koto', 'slug' => 'padi-organik-duo-koto', 'description' => '<p>Hasil panen padi organik dengan kualitas premium yang dibudidayakan secara tradisional oleh petani lokal. Lahan persawahan di Jorong Mudiak dan Jorong Railia menjadi sentra utama produksi.</p>'],
            ['category' => 'tourism', 'title' => 'Air Terjun Kacau', 'slug' => 'air-terjun-kacau', 'description' => '<p>Air terjun alami yang tersembunyi di kawasan hutan Nagari Duo Koto. Dengan ketinggian sekitar 25 meter, air terjun ini menjadi destinasi favorit bagi wisatawan lokal maupun luar daerah.</p>'],
            ['category' => 'tourism', 'title' => 'Linggai Park & Batu Gadang', 'slug' => 'linggai-park-batu-gadang', 'description' => '<p>Taman wisata berbasis alam yang menawarkan pemandangan perbukitan Agam. Batu Gadang yang ikonik menjadi spot foto populer. Dikelola secara swadaya oleh pemuda nagari.</p>'],
            ['category' => 'creative', 'title' => 'Tenun Songket Tradisional', 'slug' => 'tenun-songket-tradisional', 'description' => '<p>Kerajinan tenun songket khas Minangkabau dengan motif tradisional yang telah diwariskan turun-temurun oleh pengrajin di Jorong Pasar Ahad.</p>'],
            ['category' => 'agriculture', 'title' => 'Kopi Robusta Tanjung Raya', 'slug' => 'kopi-robusta-tanjung-raya', 'description' => '<p>Perkebunan kopi robusta di dataran tinggi nagari menghasilkan biji kopi berkualitas. Petani lokal mengolah kopi secara tradisional dari panen hingga penyangraian.</p>'],
            ['category' => 'creative', 'title' => 'Sulaman Bayangan Minangkabau', 'slug' => 'sulaman-bayangan-minangkabau', 'description' => '<p>Sulaman bayangan (shadow embroidery) merupakan kerajinan khas Minangkabau yang dikembangkan ibu-ibu PKK Nagari Duo Koto. Produk ini dipasarkan hingga ke luar provinsi.</p>'],
        ];
        foreach ($potentials as $pot) {
            Potential::create($pot);
        }

        // ─── Products / UMKM (6 usaha) ─────────────────────
        $products = [
            ['owner_name' => 'Pak Udin', 'business_name' => 'Rendang Duo Koto', 'category' => 'Kuliner', 'description' => 'Rendang khas Minangkabau dengan resep turun-temurun dari Jorong Koto Tinggi.', 'address' => 'Jorong Koto Tinggi, Nagari Duo Koto', 'whatsapp' => '081234567890', 'is_active' => true],
            ['owner_name' => 'Ibu Ratna', 'business_name' => 'Keripik Sanjai Ratna', 'category' => 'Makanan Ringan', 'description' => 'Keripik balado dan sanjai khas Bukittinggi, diproduksi di Jorong Pasar Ahad.', 'address' => 'Jorong Pasar Ahad, Nagari Duo Koto', 'whatsapp' => '081234567891', 'is_active' => true],
            ['owner_name' => 'Pak Joni', 'business_name' => 'Bordir Minang Jaya', 'category' => 'Kerajinan', 'description' => 'Produk bordir dan sulaman motif Minangkabau berkualitas ekspor.', 'address' => 'Jorong Mudiak, Nagari Duo Koto', 'whatsapp' => '081234567892', 'is_active' => true],
            ['owner_name' => 'Ibu Fitri', 'business_name' => 'Kopi Rang Duo Koto', 'category' => 'Minuman', 'description' => 'Kopi bubuk robusta asli dari perkebunan Nagari Duo Koto, disangrai secara tradisional.', 'address' => 'Jorong Railia, Nagari Duo Koto', 'whatsapp' => '081234567893', 'is_active' => true],
            ['owner_name' => 'Pak Hendra', 'business_name' => 'Madu Tanjung Raya', 'category' => 'Hasil Alam', 'description' => 'Madu hutan asli dari lebah liar di kawasan perbukitan Tanjung Raya.', 'address' => 'Jorong Tanjuang Batuang, Nagari Duo Koto', 'whatsapp' => '081234567894', 'is_active' => true],
            ['owner_name' => 'Ibu Neli', 'business_name' => 'Songket Duo Koto', 'category' => 'Kerajinan', 'description' => 'Tenun songket dan sulaman bayangan khas Minangkabau, hasil karya ibu-ibu PKK nagari.', 'address' => 'Jorong Pasar Ahad, Nagari Duo Koto', 'whatsapp' => '081234567895', 'is_active' => true],
        ];
        foreach ($products as $prod) {
            Product::create($prod);
        }

        // ─── Contacts ───────────────────────────────────────
        Contact::create(['label' => 'Kantor Wali Nagari', 'phone' => '0752-123456', 'category' => 'government', 'order' => 1]);
        Contact::create(['label' => 'Puskesmas Tanjung Raya', 'phone' => '0752-654321', 'category' => 'health', 'order' => 1]);
        Contact::create(['label' => 'Polsek Tanjung Raya', 'phone' => '0752-112233', 'category' => 'emergency', 'order' => 1]);
        Contact::create(['label' => 'PKK Nagari Duo Koto', 'phone' => '0752-445566', 'category' => 'social', 'order' => 1]);

        // ─── Agendas (8 kegiatan) ───────────────────────────
        $agendas = [
            ['title' => 'Musyawarah Nagari Rencana Pembangunan 2025', 'description' => 'Musyawarah perencanaan pembangunan tahunan nagari bersama seluruh unsur masyarakat.', 'location' => 'Balai Adat Nagari', 'start_date' => now()->addDays(14), 'end_date' => now()->addDays(14)->addHours(4), 'is_public' => true],
            ['title' => 'Gotong Royong Bersih Nagari', 'description' => 'Kegiatan gotong royong membersihkan lingkungan di seluruh jorong.', 'location' => 'Seluruh Jorong', 'start_date' => now()->addDays(7), 'is_public' => true],
            ['title' => 'Peringatan Isra Miraj 1446 H', 'description' => 'Peringatan Isra Miraj Nabi Muhammad SAW dengan ceramah agama dan doa bersama.', 'location' => 'Masjid Raya Duo Koto', 'start_date' => now()->addDays(21), 'is_public' => true],
            ['title' => 'Lomba Pacu Jawi Antar Jorong', 'description' => 'Lomba tradisional pacu jawi yang menjadi ajang silaturahmi antar warga.', 'location' => 'Sawah Jorong Mudiak', 'start_date' => now()->addDays(30), 'is_public' => true],
            ['title' => 'Posyandu Balita Bulan Mei', 'description' => 'Pemeriksaan kesehatan dan imunisasi rutin balita di seluruh jorong.', 'location' => 'Posyandu Masing-masing Jorong', 'start_date' => now()->addDays(10), 'is_public' => true],
            ['title' => 'Pelatihan Pengolahan Kopi untuk Petani', 'description' => 'Pelatihan teknik pascapanen dan penyangraian kopi bersama Dinas Pertanian.', 'location' => 'Kantor Wali Nagari', 'start_date' => now()->addDays(18), 'end_date' => now()->addDays(19), 'is_public' => true],
            ['title' => 'Rapat Koordinasi BPD dan Perangkat Nagari', 'description' => 'Rapat evaluasi pelaksanaan program semester I tahun 2025.', 'location' => 'Kantor Wali Nagari', 'start_date' => now()->addDays(25), 'is_public' => false],
            ['title' => 'Festival Kuliner Duo Koto', 'description' => 'Festival makanan tradisional khas nagari untuk memperkenalkan UMKM kuliner lokal.', 'location' => 'Lapangan Jorong Pasar Ahad', 'start_date' => now()->addDays(45), 'end_date' => now()->addDays(46), 'is_public' => true],
        ];
        foreach ($agendas as $agenda) {
            Agenda::create($agenda);
        }

        // ─── Population Stats ───────────────────────────────
        PopulationStat::create([
            'year' => 2024, 'total_population' => 5842, 'male' => 2951, 'female' => 2891, 'total_families' => 1523,
            'age_group_data' => json_encode(['0-14' => 1245, '15-24' => 980, '25-44' => 1650, '45-64' => 1200, '65+' => 767]),
            'education_data' => json_encode(['SD' => 1200, 'SMP' => 980, 'SMA' => 1400, 'D3' => 320, 'S1' => 680, 'S2+' => 120]),
            'occupation_data' => json_encode(['Petani' => 1500, 'Pedagang' => 800, 'PNS' => 320, 'Wiraswasta' => 650, 'Buruh' => 400, 'Lainnya' => 1172]),
        ]);
        PopulationStat::create([
            'year' => 2023, 'total_population' => 5720, 'male' => 2890, 'female' => 2830, 'total_families' => 1490,
            'age_group_data' => json_encode(['0-14' => 1220, '15-24' => 960, '25-44' => 1620, '45-64' => 1180, '65+' => 740]),
            'education_data' => json_encode(['SD' => 1220, 'SMP' => 960, 'SMA' => 1380, 'D3' => 300, 'S1' => 650, 'S2+' => 110]),
            'occupation_data' => json_encode(['Petani' => 1520, 'Pedagang' => 780, 'PNS' => 310, 'Wiraswasta' => 620, 'Buruh' => 420, 'Lainnya' => 1070]),
        ]);

        // ─── IDM Stats ──────────────────────────────────────
        IdmStat::create(['year' => 2024, 'score' => 0.742, 'status' => 'maju', 'social_score' => 0.785, 'economic_score' => 0.692, 'environment_score' => 0.750]);
        IdmStat::create(['year' => 2023, 'score' => 0.714, 'status' => 'maju', 'social_score' => 0.756, 'economic_score' => 0.671, 'environment_score' => 0.715]);
        IdmStat::create(['year' => 2022, 'score' => 0.685, 'status' => 'berkembang', 'social_score' => 0.720, 'economic_score' => 0.640, 'environment_score' => 0.695]);

        // ─── Budget Stats ───────────────────────────────────
        BudgetStat::create([
            'year' => 2024, 'total_income' => 2150000000, 'total_expenditure' => 1980000000, 'realization_pct' => 92.09,
            'apbdes_data' => json_encode([
                'Dana Desa' => 1200000000,
                'Alokasi Dana Desa (ADD)' => 450000000,
                'Pendapatan Asli Desa (PAD)' => 180000000,
                'Bagi Hasil Pajak' => 120000000,
                'Bantuan Provinsi' => 200000000,
            ]),
        ]);
        BudgetStat::create([
            'year' => 2023, 'total_income' => 1950000000, 'total_expenditure' => 1820000000, 'realization_pct' => 93.33,
            'apbdes_data' => json_encode([
                'Dana Desa' => 1100000000,
                'Alokasi Dana Desa (ADD)' => 400000000,
                'Pendapatan Asli Desa (PAD)' => 150000000,
                'Bagi Hasil Pajak' => 110000000,
                'Bantuan Provinsi' => 190000000,
            ]),
        ]);
        BudgetStat::create([
            'year' => 2022, 'total_income' => 1780000000, 'total_expenditure' => 1650000000, 'realization_pct' => 89.50,
            'apbdes_data' => json_encode([
                'Dana Desa' => 1000000000,
                'Alokasi Dana Desa (ADD)' => 380000000,
                'Pendapatan Asli Desa (PAD)' => 120000000,
                'Bagi Hasil Pajak' => 100000000,
                'Bantuan Provinsi' => 180000000,
            ]),
        ]);
    }
}

