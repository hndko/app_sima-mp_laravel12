<?php

namespace Database\Seeders;

use App\Models\Proyek;
use App\Models\RincianProyek;
use App\Models\Klien;
use App\Models\Stok;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProyekSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $klienIds = Klien::pluck('id')->toArray();
        $stokIds = Stok::pluck('id')->toArray();

        if (empty($klienIds) || empty($stokIds)) {
            return;
        }

        for ($i = 1; $i <= 3; $i++) {
            $proyek = Proyek::create([
                'kode_proyek' => 'PRJ-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'klien_id' => $faker->randomElement($klienIds),
                'uraian' => 'Pembangunan ' . $faker->randomElement(['Rumah', 'Ruko', 'Pagar', 'Gedung']),
                'ukuran' => $faker->numberBetween(5, 20) . 'x' . $faker->numberBetween(5, 20),
                'satuan' => 'Meter',
                'tanggal_mulai' => $faker->dateTimeBetween('-1 month', 'now'),
                'tanggal_selesai' => null,
                'dana_proyek' => $faker->numberBetween(50, 500) * 1000000, // 50-500 juta
                'status' => 'berjalan',
            ]);

            // Tambahkan rincian proyek
            for ($j = 0; $j < $faker->numberBetween(2, 5); $j++) {
                $stok = Stok::find($faker->randomElement($stokIds));
                $jumlah = $faker->numberBetween(5, 50);
                
                RincianProyek::create([
                    'proyek_id' => $proyek->id,
                    'stok_id' => $stok->id,
                    'bahan' => $stok->nama_bahan,
                    'jumlah' => $jumlah,
                    'satuan' => $stok->satuan,
                    'harga' => $stok->harga_penjualan,
                    'total' => $jumlah * $stok->harga_penjualan,
                ]);
            }
        }
    }
}
