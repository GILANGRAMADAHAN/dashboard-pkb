@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Input Data Caleg</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('caleg.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" required>
                @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="nomor_kursi" class="form-label">Nomor Kursi</label>
                <input type="text" class="form-control @error('nomor_kursi') is-invalid @enderror" id="nomor_kursi" name="nomor_kursi" value="{{ old('nomor_kursi') }}" required>
                @error('nomor_kursi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}">
                @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="rt" class="form-label">RT</label>
                    <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" name="rt" value="{{ old('rt') }}">
                    @error('rt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="rw" class="form-label">RW</label>
                    <input type="text" class="form-control @error('rw') is-invalid @enderror" id="rw" name="rw" value="{{ old('rw') }}">
                    @error('rw')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <select class="form-select @error('kecamatan') is-invalid @enderror" id="kecamatan" name="kecamatan" required>
                    <option value="">Pilih Kecamatan</option>
                    <option value="Mempawah Hilir" {{ old('kecamatan')=='Mempawah Hilir' ? 'selected' : '' }}>Mempawah Hilir</option>
                    <option value="Mempawah Timur" {{ old('kecamatan')=='Mempawah Timur' ? 'selected' : '' }}>Mempawah Timur</option>
                    <option value="Sungai Kunyit" {{ old('kecamatan')=='Sungai Kunyit' ? 'selected' : '' }}>Sungai Kunyit</option>
                    <option value="Sungai Pinyuh" {{ old('kecamatan')=='Sungai Pinyuh' ? 'selected' : '' }}>Sungai Pinyuh</option>
                    <option value="Segedong" {{ old('kecamatan')=='Segedong' ? 'selected' : '' }}>Segedong</option>
                    <option value="Anjongan" {{ old('kecamatan')=='Anjongan' ? 'selected' : '' }}>Anjongan</option>
                    <option value="Toho" {{ old('kecamatan')=='Toho' ? 'selected' : '' }}>Toho</option>
                    <option value="Sadaniang" {{ old('kecamatan')=='Sadaniang' ? 'selected' : '' }}>Sadaniang</option>
                    <option value="Jongkat" {{ old('kecamatan')=='Jongkat' ? 'selected' : '' }}>Jongkat</option>
                </select>
                @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="kelurahan" class="form-label">Kelurahan/Desa</label>
                <select class="form-select @error('kelurahan') is-invalid @enderror" id="kelurahan" name="kelurahan" required>
                    <option value="">Pilih Kelurahan/Desa</option>
                </select>
                @error('kelurahan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="tps" class="form-label">TPS</label>
                <input type="text" class="form-control @error('tps') is-invalid @enderror" id="tps" name="tps" value="{{ old('tps') }}" placeholder="Contoh: TPS 001" required>
                @error('tps')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="dapil" class="form-label">Dapil</label>
                <input type="text" class="form-control @error('dapil') is-invalid @enderror" id="dapil" name="dapil" value="{{ old('dapil') }}" readonly>
                <small class="form-text text-muted">Dapil akan diisi otomatis berdasarkan kecamatan yang dipilih</small>
                @error('dapil')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="L" {{ old('jenis_kelamin')=='L' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="jk_l">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="P" {{ old('jenis_kelamin')=='P' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="jk_p">Perempuan</label>
                </div>
                @error('jenis_kelamin')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Upload Foto (jpg, jpeg, png, max 2MB)</label>
                <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept=".jpg,.jpeg,.png">
                @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Data kelurahan per kecamatan (Kabupaten Mempawah) - Data Resmi
const kelurahanData = {
    // Dapil 1
    'Mempawah Hilir': ['Kuala Secapah', 'Malikian', 'Pasir', 'Penibung', 'Sengkubang', 'Tanjung', 'Tengah', 'Terusan'],
    'Mempawah Timur': ['Antibar', 'Parit Banjar', 'Pasir Palembang', 'Pasir Panjang', 'Pasir Wan Salim', 'Pulau Pedalaman', 'Sejegi', 'Sungai Bakau Kecil'],
    
    // Dapil 2
    'Sadaniang': ['Amawang', 'Ansiap', 'Bumbun', 'Pentek', 'Sekabuk', 'Suak Berangan'],
    'Sungai Kunyit': ['Bukit Batu', 'Mendalok', 'Sei Bundung Laut', 'Sei Dungun', 'Sei Duri I', 'Sei Duri II', 'Sei Kunyit Dalam', 'Sei Kunyit Laut', 'Sei Limau', 'Semparong Parit Raden', 'Semudun', 'Sungai Kunyit Hulu'],
    'Toho': ['Benuang', 'Kecurit', 'Pak Laheng', 'Pakutan', 'Sembora', 'Sepang', 'Terap', 'Toho Ilir'],
    
    // Dapil 3
    'Jongkat': ['Jungkat', 'Peniti Luar', 'Sei Nipah', 'Wajo Hilir', 'Wajo Hulu'],
    'Segedong': ['Parit Bugis', 'Peniti Besar', 'Peniti Dalam I', 'Peniti Dalam II', 'Sei Burung', 'Sei Purun Besar'],
    
    // Dapil 4
    'Anjongan': ['Anjungan Dalam', 'Anjungan Melancar', 'Dema', 'Kepayang', 'Pak Bulu'],
    'Sungai Pinyuh': ['Galang', 'Nusapati', 'Peniraman', 'Sei Bakau Besar Darat', 'Sei Bakau Besar Laut', 'Sei.purun Kecil', 'Sungai Batang', 'Sungai Pinyuh', 'Sungai Rasau'],
};

// Data dapil per kecamatan (Kabupaten Mempawah)
const dapilData = {
    'Mempawah Hilir': 'Dapil 1',
    'Mempawah Timur': 'Dapil 1',
    'Sadaniang': 'Dapil 2',
    'Sungai Kunyit': 'Dapil 2',
    'Toho': 'Dapil 2',
    'Jongkat': 'Dapil 3',
    'Segedong': 'Dapil 3',
    'Anjongan': 'Dapil 4',
    'Sungai Pinyuh': 'Dapil 4',
};

const kecamatanSelect = document.getElementById('kecamatan');
const kelurahanSelect = document.getElementById('kelurahan');
const dapilInput = document.getElementById('dapil');

function updateKelurahan() {
    const kec = kecamatanSelect.value;
    kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
    if (kelurahanData[kec]) {
        kelurahanData[kec].forEach(function(kel) {
            const opt = document.createElement('option');
            opt.value = kel;
            opt.textContent = kel;
            if (kel === "{{ old('kelurahan') }}") opt.selected = true;
            kelurahanSelect.appendChild(opt);
        });
    }
}

function updateDapil() {
    const kec = kecamatanSelect.value;
    if (dapilData[kec]) {
        dapilInput.value = dapilData[kec];
    } else {
        dapilInput.value = '';
    }
}

kecamatanSelect.addEventListener('change', function() {
    updateKelurahan();
    updateDapil();
});

document.addEventListener('DOMContentLoaded', function() {
    updateKelurahan();
    updateDapil();
});
</script>
@endpush 