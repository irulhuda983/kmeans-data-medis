<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisUmur;

class JenisUmurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Balita',
                'min' => 0,
                'max' => 5,
            ],
            [
                'nama' => 'Kanak-kanak',
                'min' => 6,
                'max' => 11,
            ],
            [
                'nama' => 'Remaja Awal',
                'min' => 12,
                'max' => 16,
            ],
            [
                'nama' => 'Remaja Akhir',
                'min' => 17,
                'max' => 25,
            ],
            [
                'nama' => 'Dewasa Awal',
                'min' => 26,
                'max' => 35,
            ],
            [
                'nama' => 'Dewasa Akhir',
                'min' => 36,
                'max' => 45,
            ],
            [
                'nama' => 'Lansia Awal',
                'min' => 46,
                'max' => 55,
            ],
            [
                'nama' => 'Lansia Akhir',
                'min' => 56,
                'max' => 65,
            ],
            [
                'nama' => 'Menua',
                'min' => 66,
                'max' => 200,
            ],
        ];

        foreach($data as $item) {
            JenisUmur::create([
                'nama' => $item['nama'],
                'min' => $item['min'],
                'max' => $item['max'],
            ]);
        }
    }
}
