<?php

namespace Database\Seeders;

use App\Models\Departemen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departemen = ['pemasaran', 'keuangan', 'hr', 'it', 'legal'];

        foreach ($departemen as $item) {
            Departemen::create([
                'nama_departemen' => $item
            ]);
        }
    }
}
