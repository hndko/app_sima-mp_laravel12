<?php

namespace Database\Seeders;

use App\Models\Stok;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StokSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $bahanNames = ['Semen Tiga Roda', 'Besi Beton 10mm', 'Batu Bata Merah', 'Pasir Lumajang', 'Cat Tembok Putih 25kg', 'Keramik Lantai 40x40', 'Genteng Tanah Liat', 'Kabel Roll 50m'];
        $satuans = ['Sak', 'Batang', 'Biji', 'Truk', 'Pail', 'Dus', 'Biji', 'Roll'];

        for ($i = 0; $i < count($bahanNames); $i++) {
            $hargaBeli = $faker->numberBetween(10, 100) * 1000;
            Stok::create([
                'id_barang' => 'BRG-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nama_bahan' => $bahanNames[$i],
                'harga_perolehan' => $hargaBeli,
                'harga_penjualan' => $hargaBeli + ($hargaBeli * 0.2), // 20% margin
                'stok' => $faker->numberBetween(50, 500),
                'satuan' => $satuans[$i],
            ]);
        }
    }
}
