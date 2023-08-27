<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'nama' => 'Karyawan',
                'username' => 'karyawan',
                'password' => Hash::make('test123'),
                'role' => 'karyawan',
            ],
        ];


        foreach($data as $item) {
            User::create([
                'nama' => $item['nama'],
                'username' => $item['username'],
                'password' => $item['password'],
                'role' => $item['role'],
            ]);
        }
    }
}
