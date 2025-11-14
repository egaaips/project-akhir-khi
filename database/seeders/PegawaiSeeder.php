<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pegawai::factory(10)->create();
        
        // $faker = Faker::create('id_ID');

        // for ($i = 0; $i < 10; $i++) {
        //     Pegawai::create([
        //         'nama' => $faker->name(),
        //         'nik' => $faker->randomNumber(9),
        //         'alamat' => $faker->address(),
        //         'no_hp' => $faker->phoneNumber(),
        //         'tanggal_lahir' => $faker->date(),
        //         'jenis_kelamin' => $faker->randomElement(['laki-laki', 'perempuan']),
        //     ]);
        // }
    }
}
