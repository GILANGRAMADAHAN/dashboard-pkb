@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Detail Anggota</h5>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9">{{ $anggota->nama }}</dd>
            <dt class="col-sm-3">Posisi</dt>
            <dd class="col-sm-9">{{ $anggota->posisi }}</dd>
            <dt class="col-sm-3">NIK</dt>
            <dd class="col-sm-9">{{ $anggota->nik }}</dd>
            <dt class="col-sm-3">Telepon</dt>
            <dd class="col-sm-9">{{ $anggota->telepon }}</dd>
            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge {{ $anggota->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">{{ $anggota->status }}</span>
            </dd>
            <dt class="col-sm-3">Tanggal Bergabung</dt>
            <dd class="col-sm-9">{{ $anggota->tanggal_bergabung }}</dd>
            <dt class="col-sm-3">KTP</dt>
            <dd class="col-sm-9">
                @if($anggota->ktp)
                    <a href="{{ asset('storage/'.$anggota->ktp) }}" target="_blank">Lihat File KTP</a>
                @else
                    <span class="text-muted">Belum diupload</span>
                @endif
            </dd>
        </dl>
        <a href="{{ route('anggota') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection 