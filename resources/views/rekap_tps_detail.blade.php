@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Detail TPS: {{ $tps }}</h5>
        <small class="text-muted">Kecamatan: {{ $kecamatan }}</small>
        @if($dapil)
        <div class="mt-2">
            <div class="alert alert-info mb-0">
                <i class="bi bi-info-circle"></i>
                <strong>Informasi:</strong> Data caleg yang ditampilkan adalah semua caleg dari {{ $dapil }} yang sama dengan dapil TPS ini.
            </div>
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h4>{{ $jumlahPemilih }}</h4>
                        <p class="mb-0">Jumlah Pemilih</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h4>{{ $jumlahCaleg }}</h4>
                        <p class="mb-0">Jumlah Caleg</p>
                        <small>{{ $dapil ?? 'Dapil tidak tersedia' }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h4>{{ $total }}</h4>
                        <p class="mb-0">Total</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h4>{{ $dapil ?? '-' }}</h4>
                        <p class="mb-0">Dapil</p>
                        <small>Berdasarkan TPS {{ $tps }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Pemilih -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Data Pemilih TPS {{ $tps }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
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
                
                @if($pemilih->isEmpty())
                <div class="text-center py-3">
                    <p class="text-muted">Tidak ada data pemilih untuk TPS ini.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Data Caleg -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Data Caleg {{ $dapil }}</h6>
                <small class="text-muted">Caleg yang ditampilkan berdasarkan dapil yang sama dengan TPS {{ $tps }}</small>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
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
                                <th>Foto</th>
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
                                <td>
                                    @if($c->foto)
                                        <a href="{{ asset('storage/'.$c->foto) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$c->foto) }}" alt="Foto" style="width:40px;height:40px;object-fit:cover;border-radius:6px;">
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($caleg->isEmpty())
                <div class="text-center py-3">
                    <p class="text-muted">Tidak ada data caleg untuk TPS ini.</p>
                </div>
                @endif
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('rekap-tps') }}" class="btn btn-secondary">Kembali</a>
        </div>
        
        @if($dapil)
        <div class="mt-4">
            <div class="alert alert-light border">
                <h6><i class="bi bi-lightbulb"></i> Cara Kerja Sistem:</h6>
                <ul class="mb-0">
                    <li>Data pemilih diambil dari TPS <strong>{{ $tps }}</strong> di Kecamatan <strong>{{ $kecamatan }}</strong></li>
                    <li>Dapil ditentukan berdasarkan data pemilih: <strong>{{ $dapil }}</strong></li>
                    <li>Data caleg ditampilkan berdasarkan dapil yang sama: <strong>{{ $dapil }}</strong></li>
                    <li>Total = Jumlah Pemilih + Jumlah Caleg dari dapil yang sama</li>
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 