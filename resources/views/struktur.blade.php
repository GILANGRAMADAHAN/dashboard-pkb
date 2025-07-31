@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Struktur Organisasi</h5>
        <a href="{{ route('struktur.create') }}" class="btn btn-primary btn-sm">Tambah Struktur</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Posisi</th>
                        <th>Nama Anggota</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($struktur as $s)
                    <tr>
                        <td>{{ $s->posisi }}</td>
                        <td>{{ $s->nama_anggota }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 