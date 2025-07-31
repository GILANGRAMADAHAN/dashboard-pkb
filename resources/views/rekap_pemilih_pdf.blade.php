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
    <h3 style="text-align:center;">Rekap Data Pemilih</h3>
    <table>
        <thead>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>RT</th>
                <th>RW</th>
                <th>Kecamatan</th>
                <th>Kelurahan/Desa</th>
                <th>TPS</th>
                <th>Dapil</th>
                <th>Koordinator</th>
                <th>Petugas Lapangan</th>
                @if(auth()->user() && auth()->user()->isSuperAdmin())
                <th>Input Oleh</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($pemilih as $p)
            <tr>
                <td>{{ $p->nik }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : ($p->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td>
                <td>{{ $p->alamat }}</td>
                <td>{{ $p->rt }}</td>
                <td>{{ $p->rw }}</td>
                <td>{{ $p->kecamatan }}</td>
                <td>{{ $p->kelurahan }}</td>
                <td>{{ $p->tps ?? '-' }}</td>
                <td>{{ $p->dapil }}</td>
                <td>{{ $p->koordinator }}</td>
                <td>{{ $p->petugas_lapangan }}</td>
                @if(auth()->user() && auth()->user()->isSuperAdmin())
                <td>{{ $p->user ? $p->user->name : '-' }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 