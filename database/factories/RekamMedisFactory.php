<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RekamMedis;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RekamMedis>
 */
class RekamMedisFactory extends Factory
{

    protected $model = RekamMedis::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arrPenyakit = [
            'Tifus', 'Demam Biasa', 'Demam Berdarah', 'Maag', 'Diare', 'Hipertensi', 'Asma', 'Tbc', 'Jantung'
        ];

        return [
            'kode' => fake()->regexify('[A-Z]{5}[0-9]{3}'), 
            'nama' => fake()->name(),
            'jenis_kelamin' => fake()->randomElement(['l', 'p']),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => date('Y-m-d', strtotime(fake()->date())),
            'umur' => fake()->numberBetween(10, 70),
            'penyakit' => fake()->randomElement($arrPenyakit),
            'pelayanan' => fake()->randomElement(['rawat_inap', 'rawat_jalan']),
            'tanggal' => date('Y-m-d H:i:s', strtotime( collect(fake()->dateTimeInInterval('-3 week', '+1 days'))->toArray()['date'] )),
        ];
    }
}
