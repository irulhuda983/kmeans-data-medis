<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Centroid;

class CentroidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Centroid::create([
            'nama' => 'rawat_inap',
            'k1' => 2,
            'k2' => 4,
            'k3' => 6
        ]);

        Centroid::create([
            'nama' => 'rawat_jalan',
            'k1' => 2,
            'k2' => 4,
            'k3' => 6
        ]);
    }
}
