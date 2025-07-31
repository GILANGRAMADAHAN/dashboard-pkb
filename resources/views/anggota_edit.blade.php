@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Edit Anggota</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('anggota.update', $anggota->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $anggota->nama) }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="posisi" class="form-label">Posisi</label>
                <input type="text" class="form-control @error('posisi') is-invalid @enderror" id="posisi" name="posisi" value="{{ old('posisi', $anggota->posisi) }}" required>
                @error('posisi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $anggota->nik) }}" required>
                @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', $anggota->telepon) }}" required>
                @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Pilih Status</option>
                    <option value="Aktif" {{ old('status', $anggota->status)=='Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ old('status', $anggota->status)=='Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                <input type="date" class="form-control @error('tanggal_bergabung') is-invalid @enderror" id="tanggal_bergabung" name="tanggal_bergabung" value="{{ old('tanggal_bergabung', $anggota->tanggal_bergabung) }}" required>
                @error('tanggal_bergabung')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="ktp" class="form-label">Upload KTP (jpg, jpeg, png, pdf, max 2MB)</label>
                @if($anggota->ktp)
                    <div class="mb-2">
                        <a href="{{ asset('storage/'.$anggota->ktp) }}" target="_blank">Lihat KTP Saat Ini</a>
                    </div>
                @endif
                <input type="file" class="form-control @error('ktp') is-invalid @enderror" id="ktp" name="ktp" accept=".jpg,.jpeg,.png,.pdf">
                @error('ktp')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('anggota') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection 