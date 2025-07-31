@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Kegiatan</h5>
        <a href="{{ route('kegiatan.create') }}" class="btn btn-primary btn-sm">Tambah Kegiatan</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kegiatan as $k)
                    <tr>
                        <td>{{ $k->judul }}</td>
                        <td>{{ $k->tanggal }}</td>
                        <td>{{ $k->waktu }}</td>
                        <td>{{ $k->deskripsi }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $kegiatan->links() }}
        </div>
    </div>
</div>
@endsection 