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
            'k1' => 6,
            'k2' => 12,
            'k3' => 18
        ]);

        Centroid::create([
            'nama' => 'rawat_jalan',
            'k1' => 6,
            'k2' => 12,
            'k3' => 18
        ]);
    }
}
