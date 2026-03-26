<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Manajer Proyek',
            'email' => 'manajer@example.com',
            'password' => Hash::make('password'),
            'role' => 'manajer',
        ]);

        User::create([
            'name' => 'Staff Keuangan',
            'email' => 'keuangan@example.com',
            'password' => Hash::make('password'),
            'role' => 'keuangan',
        ]);

        $this->call([
            KaryawanSeeder::class,
            KlienSeeder::class,
            StokSeeder::class,
            ProyekSeeder::class,
            KeuanganSeeder::class,
            HutangPiutangSeeder::class,
            RiwayatStokSeeder::class,
        ]);
    }
}
