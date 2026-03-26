<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 5; $i++) {
            Karyawan::create([
                'id_karyawan' => 'KAR-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_karyawan' => $faker->name,
                'bidang' => $faker->randomElement(['Tukang', 'Mandor', 'Administrasi', 'Gudang']),
                'alamat' => $faker->address,
                'no_hp' => $faker->phoneNumber,
            ]);
        }
    }
}
