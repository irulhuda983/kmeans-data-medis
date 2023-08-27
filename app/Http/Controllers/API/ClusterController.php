<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RekamMedis;
use App\Models\Centroid;
use App\Services\KmeansCluster;
use App\Services\KmeansNama;

class ClusterController extends Controller
{
    
    public function getClusterByTanggal(Request $request)
    {
        $kmeans = new KmeansCluster();

        $dataRawatInap = [];
        $dataRawatJalan = [];

        // cek ada data atau tidak
        if(RekamMedis::count() == 0) {
            return response()->json([
                'data' => []
            ], 200);
        }

        // cek range
        if($request->range){
            list($awal, $akhir) = $request->range;

            $start = date('Y-m-d', strtotime($awal) );
            $end = date('Y-m-d', strtotime($akhir) );
        }else{
            $start = date('Y-m-01');
            $end = date('Y-m-d');
        }
        // end cek range

        switch($request->type) {
            case 'pertanggal' :
                $getData = $this->pertanggal($start, $end);
                $dataRawatInap = $getData['rawat_inap'];
                $dataRawatJalan = $getData['rawat_jalan'];
                break;
            case 'perbulan' :
                $getData = $this->perbulan($request->tahun ?? date('Y'));
                $dataRawatInap = $getData['rawat_inap'];
                $dataRawatJalan = $getData['rawat_jalan'];
                break;
            default:
                $getData = $this->pertanggal($start, $end);
                $dataRawatInap = $getData['rawat_inap'];
                $dataRawatJalan = $getData['rawat_jalan'];
        }

        $centroRawatJalan = Centroid::where('nama', 'rawat_jalan')->first();
        $centroRawatInap = Centroid::where('nama', 'rawat_inap')->first();

        $clusterRawatJalan = $kmeans->cluster($dataRawatJalan, $centroRawatJalan);
        $clusterRawatInap = $kmeans->cluster($dataRawatInap, $centroRawatInap);

        return response()->json([
            'rawat_inap' => $clusterRawatInap,
            'rawat_jalan' => $clusterRawatJalan,
        ], 200);
    }

    public function getClusterByNamaPasien(Request $request)
    {
        $centro = Centroid::orderBy('created_at', 'asc')->first();

        if(RekamMedis::count() == 0) {
            return response()->json(['data' => []], 200);
        }

        $dataMedis = [];
        $query = RekamMedis::all();

        foreach($query as $item) {
            array_push($dataMedis, [
                'kode' => $item->kode,
                'nama' => $item->nama,
                'umur' => $item->umur,
                'nama_penyakit' => $item->jenisPenyakit->nama,
                'nama_pelayanan' => $item->pelayanan,
                'jenis_umur' => $item->id_jenis_umur,
                'jenis_penyakit' => $item->id_jenis_penyakit,
                'jenis_pelayanan' => $item->pelayanan == 'rawat_jalan' ? 1 : 2,
            ]);
        }

        $kmeans = new KmeansNama();
        $cluster = $kmeans->cluster($dataMedis, $centro);

        return response()->json($cluster, 200);
    }
    // fungsi bantu
    public function pertanggal($start, $end)
    {
        $arrRawatInap = [];
        $arrRawatJalan = [];

        $tanggal = [];

        while($start <= $end){
            array_push($tanggal, $start);

            $start = date('Y-m-d', strtotime('+1 days',strtotime($start)));
        }

        foreach($tanggal as $tgl){
            $rawatInap = RekamMedis::where('pelayanan', 'rawat_inap')->whereDate('tanggal', date('Y-m-d', strtotime($tgl)))->count();

            $rawatJalan = RekamMedis::where('pelayanan', 'rawat_jalan')->whereDate('tanggal', date('Y-m-d', strtotime($tgl)))->count();

            if($rawatInap > 0) {
                array_push($arrRawatInap, [
                    'nama' => $tgl,
                    'jumlah' => $rawatInap
                ]);
            }

            if($rawatJalan > 0) {
                array_push($arrRawatJalan, [
                    'nama' => $tgl,
                    'jumlah' => $rawatJalan
                ]);
            }

        }

        return [
            'rawat_inap' => $arrRawatInap,
            'rawat_jalan' => $arrRawatJalan,
        ];
    }

    public function perbulan($tahun)
    {
        $arrRawatInap = [];
        $arrRawatJalan = [];

        $bulan = [
            ['name' => 'januari', 'value' => '01'],
            ['name' => 'februari', 'value' => '02'],
            ['name' => 'maret', 'value' => '03'],
            ['name' => 'april', 'value' => '04'],
            ['name' => 'mei', 'value' => '05'],
            ['name' => 'juni', 'value' => '06'],
            ['name' => 'juli', 'value' => '07'],
            ['name' => 'agustus', 'value' => '08'],
            ['name' => 'september', 'value' => '09'],
            ['name' => 'oktober', 'value' => '10'],
            ['name' => 'november', 'value' => '11'],
            ['name' => 'desember', 'value' => '12'],
        ];

        foreach($bulan as $bln) {
            $rawatInap = RekamMedis::where('pelayanan', 'rawat_inap')->whereYear('tanggal', '=', $tahun)->whereMonth('tanggal', '=', $bln['value'])->count();

            $rawatJalan = RekamMedis::where('pelayanan', 'rawat_jalan')->whereYear('tanggal', '=', $tahun)->whereMonth('tanggal', '=', $bln['value'])->count();

            if($rawatInap > 0) {
                array_push($arrRawatInap, [
                    'nama' => $bln['name'].' '.$tahun,
                    'jumlah' => $rawatInap
                ]);
            }

            if($rawatJalan > 0) {
                array_push($arrRawatJalan, [
                    'nama' => $bln['name'].' '.$tahun,
                    'jumlah' => $rawatJalan
                ]);
            }
        }

        return [
            'rawat_inap' => $arrRawatInap,
            'rawat_jalan' => $arrRawatJalan,
        ];
    }
}
