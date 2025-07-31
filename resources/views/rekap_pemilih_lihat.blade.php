@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Detail Pemilih</h5>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">NIK</dt>
            <dd class="col-sm-9">{{ $pemilih->nik }}</dd>
            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9">{{ $pemilih->nama }}</dd>
            <dt class="col-sm-3">Alamat</dt>
            <dd class="col-sm-9">{{ $pemilih->alamat }}</dd>
            <dt class="col-sm-3">RT/RW</dt>
            <dd class="col-sm-9">{{ $pemilih->rt }}/{{ $pemilih->rw }}</dd>
            <dt class="col-sm-3">Kecamatan</dt>
            <dd class="col-sm-9">{{ $pemilih->kecamatan }}</dd>
            <dt class="col-sm-3">Kelurahan/Desa</dt>
            <dd class="col-sm-9">{{ $pemilih->kelurahan }}</dd>
            <dt class="col-sm-3">TPS</dt>
            <dd class="col-sm-9">{{ $pemilih->tps ?? '-' }}</dd>
            <dt class="col-sm-3">Dapil</dt>
            <dd class="col-sm-9">{{ $pemilih->dapil }}</dd>
            <dt class="col-sm-3">Koordinator</dt>
            <dd class="col-sm-9">{{ $pemilih->koordinator }}</dd>
            <dt class="col-sm-3">Petugas Lapangan</dt>
            <dd class="col-sm-9">{{ $pemilih->petugas_lapangan }}</dd>
            <dt class="col-sm-3">KTP</dt>
            <dd class="col-sm-9">
                @if($pemilih->ktp)
                    <a href="{{ asset('storage/'.$pemilih->ktp) }}" target="_blank">Lihat File KTP</a>
                @else
                    <span class="text-muted">-</span>
                @endif
            </dd>
            @if(auth()->user() && auth()->user()->isSuperAdmin())
            <dt class="col-sm-3">Input Oleh</dt>
            <dd class="col-sm-9">{{ $pemilih->user ? $pemilih->user->name : '-' }}</dd>
            @endif
        </dl>
        <a href="{{ route('rekap-pemilih') }}" class="btn btn-secondary">Kembali</a>
        @if(auth()->user() && (auth()->user()->isSuperAdmin() || $pemilih->user_id === auth()->id()))
        <a href="{{ route('rekap-pemilih.edit', $pemilih->id) }}" class="btn btn-warning">Edit</a>
        @endif
    </div>
</div>
@endsection 