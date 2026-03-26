<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\HutangPiutangSeeder;
use Database\Seeders\KaryawanSeeder;
use Database\Seeders\KeuanganSeeder;
use Database\Seeders\KlienSeeder;
use Database\Seeders\ProyekSeeder;
use Database\Seeders\RiwayatStokSeeder;
use Database\Seeders\StokSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
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
