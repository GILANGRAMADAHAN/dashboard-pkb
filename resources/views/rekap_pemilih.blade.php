@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Rekap Data Pemilih</h5>
        @if(auth()->user() && !auth()->user()->isSuperAdmin())
        <small class="text-muted">Anda hanya melihat data pemilih yang Anda input sendiri</small>
        @endif
    </div>
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row g-2 mb-3 align-items-center">
            <div class="col-auto">
                <form class="d-flex" method="GET" action="{{ route('rekap-pemilih') }}">
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
                        <a href="{{ route('rekap-pemilih') }}" class="btn btn-link me-2">Reset</a>
                    @endif
                </form>
            </div>
            <div class="col text-end">
                <a href="{{ route('rekap-pemilih.export.pdf', array_filter(['q'=>request('q'), 'dapil'=>request('dapil')])) }}" class="btn btn-danger btn-sm" target="_blank"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
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
                        <th>KTP</th>
                        @if(auth()->user() && auth()->user()->isSuperAdmin())
                        <th>Input Oleh</th>
                        @endif
                        <th>Aksi</th>
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
                        <td>
                            @if($p->ktp)
                                <a href="{{ asset('storage/'.$p->ktp) }}" target="_blank">Lihat KTP</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        @if(auth()->user() && auth()->user()->isSuperAdmin())
                        <td>{{ $p->user ? $p->user->name : '-' }}</td>
                        @endif
                        <td>
                            <a href="{{ route('rekap-pemilih.show', $p->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            @if(auth()->user() && (auth()->user()->isSuperAdmin() || $p->user_id === auth()->id()))
                            <a href="{{ route('rekap-pemilih.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            @endif
                            @if(auth()->user() && (auth()->user()->isSuperAdmin() || $p->user_id === auth()->id()))
                            <form action="{{ route('rekap-pemilih.destroy', $p->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 