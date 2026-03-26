<?php

namespace Database\Seeders;

use App\Models\HutangPiutang;
use App\Models\Karyawan;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class HutangPiutangSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $karyawanIds = Karyawan::pluck('id')->toArray();

        if (empty($karyawanIds)) return;

        for ($i = 0; $i < 5; $i++) {
            $isKasbon = $faker->boolean;
            $keterangan = $isKasbon ? 'Kasbon keperluan keluarga' : 'Pembayaran Gaji/Upah Mingguan';
            
            HutangPiutang::create([
                'karyawan_id' => $faker->randomElement($karyawanIds),
                'tanggal' => $faker->dateTimeBetween('-1 month', 'now'),
                'pengambilan' => $isKasbon ? $faker->numberBetween(1, 5) * 500000 : 0,
                'upah' => !$isKasbon ? $faker->numberBetween(1, 5) * 500000 : 0,
                'keterangan' => $keterangan,
            ]);
        }
    }
}
