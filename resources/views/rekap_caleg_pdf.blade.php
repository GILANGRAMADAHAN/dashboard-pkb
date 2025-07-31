<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 4px 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Rekap Data Caleg</h3>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>NIK</th>
                <th>Nomor Kursi</th>
                <th>Dapil</th>
                <th>TPS</th>
                <th>Alamat</th>
                <th>RT</th>
                <th>RW</th>
                <th>Kecamatan</th>
                <th>Kelurahan/Desa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($caleg as $c)
            <tr>
                <td>{{ $c->nama }}</td>
                <td>{{ $c->jenis_kelamin == 'L' ? 'Laki-laki' : ($c->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td>
                <td>{{ $c->nik }}</td>
                <td>{{ $c->nomor_kursi }}</td>
                <td>{{ $c->dapil }}</td>
                <td>{{ $c->tps ?? '-' }}</td>
                <td>{{ $c->alamat }}</td>
                <td>{{ $c->rt }}</td>
                <td>{{ $c->rw }}</td>
                <td>{{ $c->kecamatan }}</td>
                <td>{{ $c->kelurahan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 