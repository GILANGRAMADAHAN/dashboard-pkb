<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat superadmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@pkb.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        // Buat beberapa user biasa
        User::create([
            'name' => 'Petugas Lapangan 1',
            'email' => 'petugas1@pkb.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Petugas Lapangan 2',
            'email' => 'petugas2@pkb.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Petugas Lapangan 3',
            'email' => 'petugas3@pkb.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
