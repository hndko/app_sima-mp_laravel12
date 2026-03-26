<?php

namespace Database\Seeders;

use App\Models\Klien;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class KlienSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 5; $i++) {
            Klien::create([
                'nama_klien' => $faker->company,
                'alamat' => $faker->address,
                'no_hp' => $faker->phoneNumber,
                'id_instagram' => '@' . $faker->userName,
                'nama_facebook' => $faker->name,
            ]);
        }
    }
}
