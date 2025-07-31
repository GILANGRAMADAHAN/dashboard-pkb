<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 4px 6px; text-align: left; }
        th { background: #eee; }
        .header { text-align: center; margin-bottom: 20px; }
        .summary { margin-bottom: 20px; }
        .summary-card { 
            display: inline-block; 
            width: 22%; 
            margin: 0 1%; 
            padding: 10px; 
            text-align: center; 
            border: 1px solid #333; 
            background: #f8f9fa; 
        }
        .section { margin-top: 20px; }
        .section-title { 
            background: #eee; 
            padding: 8px; 
            font-weight: bold; 
            margin-bottom: 10px; 
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>Rekap Data Per TPS</h3>
        <p>Kabupaten Mempawah</p>
        <p><strong>TPS:</strong> {{ $tps }} | <strong>Kecamatan:</strong> {{ $kecamatan }}</p>
        @if($dapil)
        <p><small><strong>Informasi:</strong> Data caleg yang ditampilkan adalah semua caleg dari {{ $dapil }} yang sama dengan dapil TPS ini.</small></p>
        @endif
    </div>

    <div class="summary">
        <div class="summary-card">
            <h4>{{ $jumlahPemilih }}</h4>
            <p>Jumlah Pemilih</p>
        </div>
        <div class="summary-card">
            <h4>{{ $jumlahCaleg }}</h4>
            <p>Jumlah Caleg</p>
        </div>
        <div class="summary-card">
            <h4>{{ $total }}</h4>
            <p>Total</p>
        </div>
        <div class="summary-card">
            <h4>{{ $dapil }}</h4>
            <p>Dapil</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Data Pemilih TPS {{ $tps }}</div>
        <table>
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>RT/RW</th>
                    <th>Kelurahan/Desa</th>
                    <th>Koordinator</th>
                    <th>Petugas Lapangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemilih as $p)
                <tr>
                    <td>{{ $p->nik }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $p->alamat }}</td>
                    <td>{{ $p->rt }}/{{ $p->rw }}</td>
                    <td>{{ $p->kelurahan }}</td>
                    <td>{{ $p->koordinator }}</td>
                    <td>{{ $p->petugas_lapangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Data Caleg -->
    <div class="section">
        <div class="section-title">Data Caleg {{ $dapil }}</div>
        <p><small>Caleg yang ditampilkan berdasarkan dapil yang sama dengan TPS {{ $tps }}</small></p>
        <table>
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Nomor Kursi</th>
                    <th>Dapil</th>
                    <th>Alamat</th>
                    <th>RT/RW</th>
                    <th>Kelurahan/Desa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($caleg as $c)
                <tr>
                    <td>{{ $c->nik }}</td>
                    <td>{{ $c->nama }}</td>
                    <td>{{ $c->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $c->nomor_kursi }}</td>
                    <td>{{ $c->dapil }}</td>
                    <td>{{ $c->alamat }}</td>
                    <td>{{ $c->rt }}/{{ $c->rw }}</td>
                    <td>{{ $c->kelurahan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html> 