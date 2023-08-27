<?php
namespace App\Services;

class KmeansNama {
    
    public function cluster($data, $centro)
    {
        /* ==============
        tentukan jumlah cluster
        */

        /*================
        load data
        */
        $dataset = $data;
        // init data kmeans
        $dataCluster = [];

        /* ============
        menentukan centroid
        default centroid ambil data dari db
        */
        $centroid = $this->getCentroid($dataset, $centro);

        /* ============
        generate iteasi dengan rumus ecluendistancing
        */
        $i = 0;
        $tmpData = [];
        $tmpCentroid = [];

        while(true){
            if($i != 0) {
                // break;
                $iterasi = $this->iterasi($i, $dataset, $centroid);

                $cek = $this->cekPerubahanClass($tmpData, $iterasi['data']);

                array_push($dataCluster, [
                    'nama' => 'iterasi ke '.($i + 1),
                    'data_iterasi' => $iterasi['data'],
                    'centroid' => $centroid
                ]);

                $centroid = $iterasi['centroid'];
                $tmpData = $iterasi['data'];

                if(!$cek || $i >= 9) {
                    break;
                }

            }else{
                $iterasi = $this->iterasi($i, $dataset, $centroid);

                array_push($dataCluster, [
                    'nama' => 'iterasi ke '.($i + 1),
                    'data_iterasi' => $iterasi['data'],
                    'centroid' => $centroid
                ]);

                $centroid = $iterasi['centroid'];
                $tmpData = $iterasi['data'];
            }

            $i++;
        }

        $last_iterasi = array_pop($dataCluster);
        $collect = collect($last_iterasi['data_iterasi']);

        $jumlahc1 = $collect->where('cluster', 1)->count();
        $jumlahc2 = $collect->where('cluster', 2)->count();
        $jumlahc3 = $collect->where('cluster', 3)->count();

        $chartScatter = $this->getChartScatter($last_iterasi['data_iterasi']);

        return [
            'data_chart' => $chartScatter,
            'data_awal' => $data,
            'data_cluster' => $dataCluster,
            'last_cluster' => $last_iterasi['data_iterasi'],
            'last_centroid' => $last_iterasi['centroid'],
            'jumlah_cluster' => [
                'total_data' => $collect->count(),
                'c1' => $jumlahc1,
                'c2' => $jumlahc2,
                'c3' => $jumlahc3,
            ]
        ];
    }

    public function getCentroid($data, $centro)
    {
        $centroid = [];

        if(count($data) == 0 || !$centro) {
            return [];
        }

        $centroid['umur']['k1'] = $data[(int) $centro->k1 - 1]['jenis_umur'];
        $centroid['umur']['k2'] = $data[(int) $centro->k2 - 1]['jenis_umur'];
        $centroid['umur']['k3'] = $data[(int) $centro->k3 - 1]['jenis_umur'];

        $centroid['penyakit']['k1'] = $data[(int) $centro->k1 - 1]['jenis_penyakit'];
        $centroid['penyakit']['k2'] = $data[(int) $centro->k2 - 1]['jenis_penyakit'];
        $centroid['penyakit']['k3'] = $data[(int) $centro->k3 - 1]['jenis_penyakit'];

        $centroid['pelayanan']['k1'] = $data[(int) $centro->k1 - 1]['jenis_pelayanan'];
        $centroid['pelayanan']['k2'] = $data[(int) $centro->k2 - 1]['jenis_pelayanan'];
        $centroid['pelayanan']['k3'] = $data[(int) $centro->k3 - 1]['jenis_pelayanan'];

        return $centroid;
    }

    public function iterasi($no, $data, $centroid)
    {
        $result = [];

        $arrc1umur = [];
        $arrc1penyakit = [];
        $arrc1pelayanan = [];

        $arrc2umur = [];
        $arrc2penyakit = [];
        $arrc2pelayanan = [];

        $arrc3umur = [];
        $arrc3penyakit = [];
        $arrc3pelayanan = [];

        foreach($data as $key => $item) {
            $jarak = $this->getJarak($item, $centroid);
            $cluster = $this->getClass($jarak);

            switch ($cluster) {
                case 1:
                    array_push($arrc1umur, $item['jenis_umur']);
                    array_push($arrc1penyakit, $item['jenis_penyakit']);
                    array_push($arrc1pelayanan, $item['jenis_pelayanan']);
                    break;
                case 2:
                    array_push($arrc2umur, $item['jenis_umur']);
                    array_push($arrc2penyakit, $item['jenis_penyakit']);
                    array_push($arrc2pelayanan, $item['jenis_pelayanan']);
                    break;
                case 3:
                    array_push($arrc3umur, $item['jenis_umur']);
                    array_push($arrc3penyakit, $item['jenis_penyakit']);
                    array_push($arrc3pelayanan, $item['jenis_pelayanan']);
                    break;
            }

            array_push($result, [
                'no' => $key + 1,
                'nama' => $item['nama'],
                'jenis_umur' => $item['jenis_umur'],
                'jenis_penyakit' => $item['jenis_penyakit'],
                'jenis_pelayanan' => $item['jenis_pelayanan'],
                'c1' => $jarak['c1'],
                'c2' => $jarak['c2'],
                'c3' => $jarak['c3'],
                'min' => min($jarak),
                'cluster' => $cluster,
                'k1' => $cluster == 1 ? true : false,
                'k2' => $cluster == 2 ? true : false,
                'k3' => $cluster == 3 ? true : false,
            ]);
        }

        $centro = [
            'umur' => [
                'k1' => $this->pembagian(array_sum($arrc1umur), count($arrc1umur)),
                'k2' => $this->pembagian(array_sum($arrc2umur), count($arrc2umur)),
                'k3' => $this->pembagian(array_sum($arrc3umur), count($arrc3umur))
            ],
            'penyakit' => [
                'k1' => $this->pembagian(array_sum($arrc1penyakit), count($arrc1penyakit)),
                'k2' => $this->pembagian(array_sum($arrc2penyakit), count($arrc2penyakit)),
                'k3' => $this->pembagian(array_sum($arrc3penyakit), count($arrc3penyakit))
            ],
            'pelayanan' => [
                'k1' => $this->pembagian(array_sum($arrc1pelayanan), count($arrc1pelayanan)),
                'k2' => $this->pembagian(array_sum($arrc2pelayanan), count($arrc2pelayanan)),
                'k3' => $this->pembagian(array_sum($arrc3pelayanan), count($arrc3pelayanan))
            ],
        ];

        return [
            'nama' => 'Iterasi '.($no + 1),
            'data' => $result,
            'centroid' => $centro
        ];
    }

    public function getJarak($data, $centroid)
    {
        $c1 = $this->rumus(
            $data['jenis_umur'],
            $data['jenis_penyakit'],
            $data['jenis_pelayanan'],
            $centroid['umur']['k1'],
            $centroid['penyakit']['k1'],
            $centroid['pelayanan']['k1']
        );

        $c2 = $this->rumus($data['jenis_umur'], $data['jenis_penyakit'], $data['jenis_pelayanan'], $centroid['umur']['k2'], $centroid['penyakit']['k2'], $centroid['pelayanan']['k2']);
        $c3 = $this->rumus($data['jenis_umur'], $data['jenis_penyakit'], $data['jenis_pelayanan'], $centroid['umur']['k3'], $centroid['penyakit']['k3'], $centroid['pelayanan']['k3']);

        return [
            'c1' => $c1,
            'c2' => $c2,
            'c3' => $c3,
        ];
    }

    public function getClass($arr)
    {
        $k1 = $arr['c1'];
        $k2 = $arr['c2'];
        $k3 = $arr['c3'];
        $min = min($arr);

        if($k1 == $min) {
            return 1;
        }

        if($k2 == $min) {
            return 2;
        }

        if($k3 == $min) {
            return 3;
        }
    }

    public function rumus($x, $y, $z, $cx, $cy, $cz)
    {        
        $hasilX = $x - $cx;
        $hasilY = $y - $cy;
        $hasilZ = $z - $cz;

        $pangkatX = pow($hasilX, 2);
        $pangkatY = pow($hasilY, 2);
        $pangkatZ = pow($hasilZ, 2);

        $hasil = sqrt($pangkatX + $pangkatY + $pangkatZ);

        return $hasil;
    }

    public function pembagian($nilai1, $nilai2)
    {
        return ($nilai1 != 0 ? ($nilai1 / $nilai2 ) : 0);
    }

    public function cekPerubahanClass($oldData, $newData) {
        $tmpArray = [];

        foreach($oldData as $key => $value) {
            if($oldData[$key]['cluster'] == $newData[$key]['cluster']) {
                array_push($tmpArray, 0);
            }else{
                array_push($tmpArray, 1);
            }
        }

        if(array_sum($tmpArray) > 0) {
            return true;
        }

        return false;
    }

    public function getChartScatter($data)
    {
        $c1 = [];
        $c2 = [];
        $c3 = [];

        foreach($data as $item){
            if($item['cluster'] == 1){
                array_push($c1, [ round($item['c1'], 2), round($item['c2'], 2), round($item['c3'], 2)]);
            }else if($item['cluster'] == 2){
                array_push($c2, [ round($item['c2'], 2), round($item['c3'], 2), round($item['c1'], 2)]);
            }else if($item['cluster'] == 3){
                array_push($c3, [ round($item['c3'], 2), round($item['c1'], 2), round($item['c2'], 2)]);
            }
        }

        return [
            [
                'name' => 'Claster 1',
                'data' => $c1
            ],
            [
                'name' => 'Claster 2',
                'data' => $c2
            ],
            [
                'name' => 'Claster 3',
                'data' => $c3
            ],
        ];
    }
}