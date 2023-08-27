<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\RekamMedis::factory(100)->create();

        // \App\Models\RekamMedis::factory()->create([
        //     'kode' => fake()->regexify('[A-Z]{5}[0-9]{3}'), 
        //     'nama' => fake()->name(),
        //     'jenis_kelamin' => fake()->randomElements(['l', 'p']),
        //     'tempat_lahir' => fake()->city(),
        //     'tanggal_lahir' => date('Y-m-d', strtotime(fake()->date())),
        //     'umur' => fake()->numberBetween(10, 100),
        //     'penyakit' => fake()->randomElements(['Tifus', 'Demam Biasa', 'Demam Berdarah', 'Maag', 'Diare', 'Hipertensi', 'Asma', 'Tbc', 'Jantung']),
        //     'pelayanan' => fake()->randomElements(['rawat_inap', 'rawat_jalan']),
        //     'tanggal' => date('Y-m-d H:i:s', strtotime(fake()->date())),
        // ]);
        $this->call([
            UserSeeder::class,
            JenisUmurSeeder::class,
            JenisPenyakitSeeder::class,
            CentroidSeeder::class,
        ]);
    }
}
