@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Rekap Data Caleg</h5>
    </div>
    <div class="card-body">
        <div class="row g-2 mb-3 align-items-center">
            <div class="col-auto">
                <form class="d-flex" method="GET" action="{{ route('rekap-caleg') }}">
                    <input type="text" name="q" class="form-control me-2" placeholder="Cari NIK atau Nama..." value="{{ request('q') }}">
                    <select name="dapil" class="form-select me-2">
                        <option value="">Semua Dapil</option>
                        <option value="1" {{ request('dapil')=='1' ? 'selected' : '' }}>Dapil 1</option>
                        <option value="2" {{ request('dapil')=='2' ? 'selected' : '' }}>Dapil 2</option>
                        <option value="3" {{ request('dapil')=='3' ? 'selected' : '' }}>Dapil 3</option>
                        <option value="4" {{ request('dapil')=='4' ? 'selected' : '' }}>Dapil 4</option>
                    </select>
                    <button type="submit" class="btn btn-primary me-2">Cari</button>
                    @if(request('q') || request('dapil'))
                        <a href="{{ route('rekap-caleg') }}" class="btn btn-link me-2">Reset</a>
                    @endif
                </form>
            </div>
            <div class="col text-end">
                <a href="{{ route('rekap-caleg.export.pdf', array_filter(['q'=>request('q'), 'dapil'=>request('dapil')])) }}" class="btn btn-danger btn-sm" target="_blank"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
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
                        <th>Foto</th>
                        <th>Aksi</th>
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
                        <td>
                            @if($c->foto)
                                <a href="{{ asset('storage/'.$c->foto) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$c->foto) }}" alt="Foto" style="width:40px;height:40px;object-fit:cover;border-radius:6px;">
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('rekap-caleg.show', $c->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('rekap-caleg.edit', $c->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('rekap-caleg.destroy', $c->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 