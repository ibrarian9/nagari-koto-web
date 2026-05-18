<?php

namespace Database\Seeders;

use App\Models\BamusMember;
use Illuminate\Database\Seeder;

class BamusMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['name' => 'H. Syamsul Bahri, S.H.', 'position' => 'Ketua BAMUS', 'period' => '2024-2029', 'order' => 0],
            ['name' => 'Ir. Yusrizal', 'position' => 'Wakil Ketua BAMUS', 'period' => '2024-2029', 'order' => 1],
            ['name' => 'Rahmawati, S.Pd.', 'position' => 'Sekretaris', 'period' => '2024-2029', 'order' => 2],
            ['name' => 'Dt. Rajo Basa', 'position' => 'Anggota (Unsur Adat)', 'period' => '2024-2029', 'order' => 3],
            ['name' => 'H. Zulkifli', 'position' => 'Anggota (Unsur Agama)', 'period' => '2024-2029', 'order' => 4],
            ['name' => 'Drs. Afrianto', 'position' => 'Anggota (Unsur Cerdik Pandai)', 'period' => '2024-2029', 'order' => 5],
            ['name' => 'Nurhayati, A.Md.', 'position' => 'Anggota (Unsur Perempuan)', 'period' => '2024-2029', 'order' => 6],
            ['name' => 'Muhammad Iqbal', 'position' => 'Anggota (Unsur Pemuda)', 'period' => '2024-2029', 'order' => 7],
        ];

        foreach ($members as $member) {
            BamusMember::create(array_merge($member, ['is_active' => true]));
        }
    }
}
