@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Rekap Data Per TPS</h5>
        <small class="text-muted">Jumlah caleg dihitung berdasarkan dapil yang sama dengan TPS tersebut</small>
    </div>
    <div class="card-body">
        <div class="row g-2 mb-3 align-items-center">
            <div class="col-auto">
                <form class="d-flex" method="GET" action="{{ route('rekap-tps') }}">
                    <select name="kecamatan" class="form-select me-2">
                        <option value="">Semua Kecamatan</option>
                        <option value="Mempawah Hilir" {{ request('kecamatan')=='Mempawah Hilir' ? 'selected' : '' }}>Mempawah Hilir</option>
                        <option value="Mempawah Timur" {{ request('kecamatan')=='Mempawah Timur' ? 'selected' : '' }}>Mempawah Timur</option>
                        <option value="Sungai Kunyit" {{ request('kecamatan')=='Sungai Kunyit' ? 'selected' : '' }}>Sungai Kunyit</option>
                        <option value="Sungai Pinyuh" {{ request('kecamatan')=='Sungai Pinyuh' ? 'selected' : '' }}>Sungai Pinyuh</option>
                        <option value="Segedong" {{ request('kecamatan')=='Segedong' ? 'selected' : '' }}>Segedong</option>
                        <option value="Anjongan" {{ request('kecamatan')=='Anjongan' ? 'selected' : '' }}>Anjongan</option>
                        <option value="Toho" {{ request('kecamatan')=='Toho' ? 'selected' : '' }}>Toho</option>
                        <option value="Sadaniang" {{ request('kecamatan')=='Sadaniang' ? 'selected' : '' }}>Sadaniang</option>
                        <option value="Jongkat" {{ request('kecamatan')=='Jongkat' ? 'selected' : '' }}>Jongkat</option>
                    </select>
                    <input type="text" name="tps" class="form-control me-2" placeholder="Cari TPS..." value="{{ request('tps') }}">
                    <button type="submit" class="btn btn-primary me-2">Cari</button>
                    @if(request('kecamatan') || request('tps'))
                        <a href="{{ route('rekap-tps') }}" class="btn btn-link me-2">Reset</a>
                    @endif
                </form>
            </div>

        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>TPS</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan/Desa</th>
                        <th>Dapil</th>
                        <th>Jumlah Pemilih</th>
                        <th>Jumlah Caleg</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tpsData as $index => $tps)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $tps->tps }}</td>
                        <td>{{ $tps->kecamatan }}</td>
                        <td>{{ $tps->kelurahan }}</td>
                        <td>{{ $tps->dapil ?? '-' }}</td>
                        <td>{{ $tps->jumlah_pemilih }}</td>
                        <td>{{ $tps->jumlah_caleg }}</td>
                        <td>{{ $tps->total }}</td>
                        <td>
                            @if($tps->tps && $tps->kecamatan)
                                <a href="{{ route('rekap-tps.detail', ['tps' => $tps->tps, 'kecamatan' => $tps->kecamatan]) }}" class="btn btn-sm btn-info">Detail</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($tpsData->isEmpty())
        <div class="text-center py-4">
            <p class="text-muted">Tidak ada data TPS yang ditemukan.</p>
        </div>
        @endif
    </div>
</div>
@endsection 