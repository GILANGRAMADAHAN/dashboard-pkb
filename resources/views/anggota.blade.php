@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Anggota</h5>
        <a href="{{ route('anggota.create') }}" class="btn btn-primary btn-sm">Tambah Anggota</a>
    </div>
    <div class="card-body">
        <form class="row g-2 mb-3" method="GET" action="{{ route('anggota') }}">
            <div class="col-auto">
                <input type="text" name="nik" class="form-control" placeholder="Cari NIK..." value="{{ request('nik') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
            @if(request('nik'))
            <div class="col-auto align-self-center">
                <a href="{{ route('anggota') }}" class="btn btn-link">Reset</a>
            </div>
            @endif
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th>NIK</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($anggota as $a)
                    <tr>
                        <td>{{ str_pad($a->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $a->nama }}</td>
                        <td>{{ $a->posisi }}</td>
                        <td>{{ $a->nik }}</td>
                        <td>{{ $a->telepon }}</td>
                        <td>
                            <span class="badge {{ $a->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">{{ $a->status }}</span>
                        </td>
                        <td>{{ $a->tanggal_bergabung }}</td>
                        <td>
                            <a href="{{ route('anggota.show', $a->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('anggota.edit', $a->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="#" method="POST" style="display:inline;">
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
        <div class="mt-3">
            {{ $anggota->links() }}
        </div>
    </div>
</div>
@endsection 