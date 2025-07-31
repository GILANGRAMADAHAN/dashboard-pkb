@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Detail Caleg</h5>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9">{{ $caleg->nama }}</dd>
            <dt class="col-sm-3">NIK</dt>
            <dd class="col-sm-9">{{ $caleg->nik }}</dd>
            <dt class="col-sm-3">Nomor Kursi</dt>
            <dd class="col-sm-9">{{ $caleg->nomor_kursi }}</dd>
            <dt class="col-sm-3">Dapil</dt>
            <dd class="col-sm-9">{{ $caleg->dapil }}</dd>
            <dt class="col-sm-3">TPS</dt>
            <dd class="col-sm-9">{{ $caleg->tps ?? '-' }}</dd>
            <dt class="col-sm-3">Alamat</dt>
            <dd class="col-sm-9">{{ $caleg->alamat }}</dd>
            <dt class="col-sm-3">RT/RW</dt>
            <dd class="col-sm-9">{{ $caleg->rt }}/{{ $caleg->rw }}</dd>
            <dt class="col-sm-3">Kecamatan</dt>
            <dd class="col-sm-9">{{ $caleg->kecamatan }}</dd>
            <dt class="col-sm-3">Kelurahan/Desa</dt>
            <dd class="col-sm-9">{{ $caleg->kelurahan }}</dd>
            <dt class="col-sm-3">Foto</dt>
            <dd class="col-sm-9">
                @if($caleg->foto)
                    <img src="{{ asset('storage/'.$caleg->foto) }}" alt="Foto" style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                @else
                    <span class="text-muted">-</span>
                @endif
            </dd>
        </dl>
        <a href="{{ route('rekap-caleg') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('rekap-caleg.edit', $caleg->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection 