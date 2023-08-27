<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';

    protected $guarded = ['id'];

    public function jenisPenyakit()
    {
        return $this->belongsTo(JenisPenyakit::class, 'id_jenis_penyakit');
    }

    public function jenisUmur()
    {
        return $this->belongsTo(JenisUmur::class, 'id_jenis_umur');
    }

    public function scopeSearch($query, $search)
    {
        if($search) {
            $query->where('nama', 'like', '%'.$search.'%');
        }

        return $query;
    }

    public function scopePelayanan($query, $pelayanan)
    {
        if($pelayanan) {
            $query->where('pelayanan', $pelayanan);
        }

        return $query;
    }

    public function scopeTanggal($query, $tanggal)
    {
        if($tanggal) {
            $tgl = date('Y-m-d', strtotime($tanggal) );

            $query->whereDate('tanggal', $tgl);
        }

        return $query;
    }

    public function scopeRange($query, $range = [])
    {
        if($range && count($range) > 0) {
            list($awal, $akhir) = $range;
            $start = date('Y-m-d', strtotime($awal) );
            $end = date('Y-m-d', strtotime($akhir) );
            $query->whereBetween('tanggal', [$start, $end]);
        }

        return $query;
    }
}
