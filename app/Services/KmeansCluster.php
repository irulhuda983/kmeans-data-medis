<?php
namespace App\Services;

class KmeansCluster {
    
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

        while(true){
            if($i != 0) {
                $iterasi = $this->iterasi($i, $dataset, $centroid);

                $cek = $this->cekPerubahanClass($tmpData, $iterasi['data']);
                $centroid = $iterasi['centroid'];
                $tmpData = $iterasi['data'];

                array_push($dataCluster, [
                    'nama' => 'iterasi ke '.($i + 1),
                    'data_iterasi' => $iterasi['data'],
                ]);

                if(!$cek || $i > 10) {
                    break;
                }

            }else{
                $iterasi = $this->iterasi($i, $dataset, $centroid);

                $centroid = $iterasi['centroid'];
                $tmpData = $iterasi['data'];

                array_push($dataCluster, [
                    'nama' => 'iterasi ke '.($i + 1),
                    'data_iterasi' => $iterasi['data'],
                ]);
            }

            $i++;
        }

        array_push($dataCluster);

        return $dataCluster;
    }

    public function getCentroid($data, $centro)
    {
        $centroid = [];

        if(count($data) == 0 || !$centro) {
            return [];
        }

        $centroid['k1'] = $data[(int) $centro->k1 - 1]['jumlah'];
        $centroid['k2'] = $data[(int) $centro->k2 - 1]['jumlah'];
        $centroid['k3'] = $data[(int) $centro->k3 - 1]['jumlah'];

        return $centroid;
    }

    public function iterasi($no, $data, $centroid)
    {
        $result = [];

        $arrc1 = [];
        $arrc2 = [];
        $arrc3 = [];

        foreach($data as $key => $item) {
            $jumlah = (int) $item['jumlah'];
            $jarak = $this->getJarak($jumlah, $centroid);
            $cluster = $this->getClass($jarak);

            switch ($cluster) {
                case 1:
                    array_push($arrc1, $jumlah);
                    break;
                case 2:
                    array_push($arrc2, $jumlah);
                    break;
                case 3:
                    array_push($arrc3, $jumlah);
                    break;
            }

            array_push($result, [
                'no' => $key + 1,
                'nama' => $item['nama'],
                'jumlah' => $jumlah,
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

        $centroid = [
            'k1' => $this->pembagian(array_sum($arrc1), count($arrc1)),
            'k2' => $this->pembagian(array_sum($arrc2), count($arrc2)),
            'k3' => $this->pembagian(array_sum($arrc3), count($arrc3)),
        ];

        return [
            'nama' => 'Iterasi '.($no + 1),
            'data' => $result,
            'centroid' =>$centroid
        ];
    }

    public function getJarak($jumlah, $centroid)
    {
        $c1 = sqrt( pow( ($jumlah - $centroid['k1']), 2) );
        $c2 = sqrt( pow( ($jumlah - $centroid['k2']), 2) );
        $c3 = sqrt( pow( ($jumlah - $centroid['k3']), 2) );

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
}