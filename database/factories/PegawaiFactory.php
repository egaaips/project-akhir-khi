<?php

namespace Database\Factories;

use App\Models\Departemen;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nik = $this->faker->numerify('##########');

        return [
            'nama' => $this->faker->name(),
            'departemen_id' => $this->faker->numberBetween(1, 5),
            'nik' => $nik,
            'alamat' => $this->faker->address(),
            'no_hp' => $this->faker->phoneNumber(),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['laki-laki', 'perempuan']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($pegawai) {
            $nik = $pegawai->nik;

            // Buat user setelah pegawai dibuat
            $user = User::create([
                'name' => $pegawai->nama,
                'email' => $this->faker->unique()->safeEmail(),
                'password' => Hash::make($nik),
                'role_id' => 2, // role karyawan
                'pegawai_id' => $pegawai->id, // hubungkan ke pegawai
                'remember_token' => Str::random(10),
            ]);
        });

        
        // return [
        //     'nama' => $this->faker->name(),
        //     'departemen_id' => $this->faker->numberBetween(1, 5),
        //     'email' => $this->faker->unique()->safeEmail(),
        //     'role_id' => $this->faker->numberBetween(1, 3),
        //     'nik' => $this->faker->randomNumber(8),
        //     'alamat' => $this->faker->address(),
        //     'no_hp' => $this->faker->phoneNumber(),
        //     'tanggal_lahir' => $this->faker->date(),
        //     'jenis_kelamin' => $this->faker->randomElement(['laki-laki', 'perempuan']),
        // ];
    }
}
