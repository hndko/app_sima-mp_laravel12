<?php

namespace Database\Seeders;

use App\Models\RiwayatStok;
use App\Models\Stok;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RiwayatStokSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $stokIds = Stok::pluck('id')->toArray();

        if (empty($stokIds)) return;

        for ($i = 0; $i < 10; $i++) {
            $tipe = $faker->randomElement(['masuk', 'keluar']);
            RiwayatStok::create([
                'stok_id' => $faker->randomElement($stokIds),
                'tanggal' => $faker->dateTimeBetween('-1 month', 'now'),
                'tipe' => $tipe,
                'jumlah' => $faker->numberBetween(5, 50),
                'keterangan' => $tipe == 'masuk' ? 'Pembelian Restock' : 'Penggunaan Proyek',
            ]);
        }
    }
}
