<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => 'admin123',
                'role_id' => 1, // role admin
                'remember_token' => Str::random(10),
            ]);
    }
}
