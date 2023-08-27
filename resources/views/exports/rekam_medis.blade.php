<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <tbody>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>L/P</th>
                <th>Umur</th>
                <th>Kategori Umur</th>
                <th>Penyakit</th>
                <th>Pelayanan</th>
            </tr>
        </tbody>
        <tbody>
            @foreach($rekam as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->tanggal ? date('Y-m-d', strtotime($item->tanggal)) : '' }}</td>
                <td>{{ $item->jenis_kelamin }}</td>
                <td>{{ $item->umur }}</td>
                <td>{{ optional($item->jenisUmur)->nama }}</td>
                <td>{{ optional($item->jenisPenyakit)->nama }}</td>
                <td>{{ $item->pelayanan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>