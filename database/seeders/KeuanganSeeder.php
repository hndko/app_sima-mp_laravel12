<?php

namespace Database\Seeders;

use App\Models\Keuangan;
use App\Models\KasRekening;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class KeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Seed Keuangan Umum
        for ($i = 0; $i < 10; $i++) {
            $isPemasukan = $faker->boolean;
            Keuangan::create([
                'tanggal' => $faker->dateTimeBetween('-1 month', 'now'),
                'kategori' => $isPemasukan ? 'Pendapatan Proyek' : 'Biaya Operasional',
                'sumber_dana' => $faker->randomElement(['Kas Kecil', 'Bank BCA', 'Bank Mandiri']),
                'uraian' => $faker->sentence,
                'pemasukan' => $isPemasukan ? $faker->numberBetween(1, 10) * 1000000 : 0,
                'pengeluaran' => !$isPemasukan ? $faker->numberBetween(1, 5) * 1000000 : 0,
            ]);
        }

        // Seed Kas Rekening Bank
        for ($i = 0; $i < 5; $i++) {
            $isMasuk = $faker->boolean;
            KasRekening::create([
                'tanggal' => $faker->dateTimeBetween('-1 month', 'now'),
                'keterangan' => 'Mutasi ' . $faker->sentence,
                'nominal_masuk' => $isMasuk ? $faker->numberBetween(10, 50) * 1000000 : 0,
                'nominal_keluar' => !$isMasuk ? $faker->numberBetween(5, 20) * 1000000 : 0,
            ]);
        }
    }
}
