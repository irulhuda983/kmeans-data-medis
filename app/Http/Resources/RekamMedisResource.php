<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RekamMedisResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode' => $this->kode,
            'nama' => $this->nama,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => date('d-M-Y', strtotime($this->tanggal_lahir)),
            'umur' => $this->umur,
            'jenisUmur' => $this->jenisUmur,
            'penyakit' => $this->id_jenis_penyakit,
            'jenis_penyakit' => $this->jenisPenyakit,
            'pelayanan' => $this->pelayanan,
            'tanggal' => date('d-m-Y', strtotime($this->tanggal)),
        ];
    }
}
