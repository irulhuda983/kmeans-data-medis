<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisPenyakit;

class JenisPenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'tifus'],
            ['nama' => 'demam biasa'],
            ['nama' => 'demam berdarah'],
            ['nama' => 'maag'],
            ['nama' => 'diare'],
            ['nama' => 'hipertensi'],
            ['nama' => 'asma'],
            ['nama' => 'tbc'],
            ['nama' => 'jantung'],
            ['nama' => 'ginjal'],
            ['nama' => 'sakit kepala'],
            ['nama' => 'diabetes'],
        ];

        foreach($data as $item) {
            JenisPenyakit::create([
                'nama' => $item['nama']
            ]);
        }
    }
}
