@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Tambah Struktur Organisasi</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('struktur.store') }}">
            @csrf
            <div class="mb-3">
                <label for="posisi" class="form-label">Posisi</label>
                <input type="text" class="form-control @error('posisi') is-invalid @enderror" id="posisi" name="posisi" value="{{ old('posisi') }}" required>
                @error('posisi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="nama_anggota" class="form-label">Nama Anggota</label>
                <input type="text" class="form-control @error('nama_anggota') is-invalid @enderror" id="nama_anggota" name="nama_anggota" value="{{ old('nama_anggota') }}" required>
                @error('nama_anggota')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('struktur') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection 