<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@nagari-koto.desa.id'],
            [
                'name'      => 'Super Admin',
                'password'  => Hash::make('password'),
                'role'      => 'super_admin',
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'operator@nagari-koto.desa.id'],
            [
                'name'      => 'Operator Desa',
                'password'  => Hash::make('password'),
                'role'      => 'operator',
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'budi@example.com'],
            [
                'name'      => 'Budi Santoso',
                'password'  => Hash::make('password'),
                'role'      => 'warga',
                'is_active' => true,
            ]
        );
    }
}
