<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 4px 6px; text-align: left; }
        th { background: #eee; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h3>Rekap Data Per TPS</h3>
        <p>Kabupaten Mempawah</p>
        <p><small>Jumlah caleg dihitung berdasarkan dapil yang sama dengan TPS tersebut</small></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>TPS</th>
                <th>Kecamatan</th>
                <th>Kelurahan/Desa</th>
                <th>Dapil</th>
                <th>Jumlah Pemilih</th>
                <th>Jumlah Caleg</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tpsData as $index => $tps)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $tps->tps }}</td>
                <td>{{ $tps->kecamatan }}</td>
                <td>{{ $tps->kelurahan }}</td>
                <td>{{ $tps->dapil ?? '-' }}</td>
                <td>{{ $tps->jumlah_pemilih }}</td>
                <td>{{ $tps->jumlah_caleg }}</td>
                <td>{{ $tps->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 