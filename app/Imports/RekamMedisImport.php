<?php

namespace App\Imports;

use App\Models\RekamMedis;
use App\Models\JenisUmur;
use App\Models\JenisPenyakit;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RekamMedisImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $jenisUmur = JenisUmur::where([
            ['min', '<=', (int) $row['umur']],
            ['max', '>=', (int) $row['umur']],
        ])->first();

        $jenisPenyakit = JenisPenyakit::firstOrCreate([
            'nama' => Str::lower($row['jenis_penyakit'])
        ]);

        return new RekamMedis([
            'kode' => $row['kode'], 
            'nama' => $row['nama'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            // 'tempat_lahir' => $row['tempat_lahir'],
            // 'tanggal_lahir' => $row['tanggal_lahir'],
            'umur' => $row['umur'],
            'id_jenis_umur' => $jenisUmur->id,
            'id_jenis_penyakit' => $jenisPenyakit->id,
            'pelayanan' => $row['jenis_pelayanan'],
            'tanggal' => date('Y-m-d', strtotime($row['tanggal'])),
        ]);
    }
}