@extends('layouts.app')

@section('content')
<style>
    .dashboard-header {
        background: #0d6efd;
        color: #fff;
        border-radius: 1rem;
        padding: 1.3rem 1.2rem 1.1rem 1.2rem;
        margin-bottom: 1.2rem;
        box-shadow: 0 2px 8px rgba(13,110,253,0.08);
    }
    .dashboard-header h5 {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 0.3rem;
    }
    .dashboard-header span {
        font-size: 0.98rem;
        color: #cfe2ff;
    }
    .stat-card {
        border-radius: 0.8rem;
        box-shadow: 0 2px 8px rgba(13,110,253,0.06);
        min-height: 80px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1rem 0.8rem 1rem;
        margin-bottom: 0.8rem;
    }
    .stat-card .icon {
        background: #e7f1ff;
        color: #0d6efd;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .stat-card .stat-title {
        font-size: 0.95rem;
        color: #6c757d;
        margin-bottom: 0.1rem;
    }
    .stat-card .stat-value {
        font-size: 1.25rem;
        font-weight: 700;
    }
    .stat-card .stat-trend {
        font-size: 0.85rem;
        color: #198754;
    }
    @media (max-width: 991.98px) {
        .stat-card { flex-direction: column; align-items: flex-start; }
        .stat-card .icon { margin-bottom: 0.4rem; }
    }
</style>
<div class="dashboard-header mb-4">
    <h5>Selamat Datang di Sistem Database DPC PKB</h5>
    <span>Kelola data anggota, struktur organisasi, dan kegiatan partai dengan mudah dan efisien.</span>
</div>
<div class="row mb-4 g-3">
    <div class="col-md-2 col-6">
        <div class="stat-card bg-white">
            <div>
                <div class="stat-title">Total Caleg</div>
                <div class="stat-value">{{ $totalCaleg }}</div>
                <div class="stat-trend">
                    @php
                        $totalCalegBulanLalu = $totalCalegBulanLalu ?? 0;
                        $growthCaleg = $totalCalegBulanLalu > 0 ? round((($totalCaleg - $totalCalegBulanLalu) / $totalCalegBulanLalu) * 100) : 0;
                    @endphp
                    <i class="bi bi-arrow-up"></i> {{ $growthCaleg }}% dari bulan lalu
                </div>
            </div>
            <div class="icon"><i class="bi bi-person-badge"></i></div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="stat-card bg-white">
            <div>
                <div class="stat-title">Total Pemilih</div>
                <div class="stat-value">{{ $totalPemilih }}</div>
                <div class="stat-trend">
                    @php
                        $totalPemilihBulanLalu = $totalPemilihBulanLalu ?? 0;
                        $growthPemilih = $totalPemilihBulanLalu > 0 ? round((($totalPemilih - $totalPemilihBulanLalu) / $totalPemilihBulanLalu) * 100) : 0;
                    @endphp
                    <i class="bi bi-arrow-up"></i> {{ $growthPemilih }}% dari bulan lalu
                </div>
            </div>
            <div class="icon"><i class="bi bi-person-vcard"></i></div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="stat-card bg-white">
            <div>
                <div class="stat-title">Total Anggota</div>
                <div class="stat-value">{{ $totalAnggota }}</div>
                <div class="stat-trend">
                    @php
                        $totalAnggotaBulanLalu = $totalAnggotaBulanLalu ?? 0;
                        $growth = $totalAnggotaBulanLalu > 0 ? round((($totalAnggota - $totalAnggotaBulanLalu) / $totalAnggotaBulanLalu) * 100) : 0;
                    @endphp
                    <i class="bi bi-arrow-up"></i> {{ $growth }}% dari bulan lalu
                </div>
            </div>
            <div class="icon"><i class="bi bi-people"></i></div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="stat-card bg-white">
            <div>
                <div class="stat-title">Anggota Aktif</div>
                <div class="stat-value">{{ $anggotaAktif }}</div>
                <div class="stat-trend"><i class="bi bi-arrow-up"></i> +8% dari bulan lalu</div>
            </div>
            <div class="icon"><i class="bi bi-person-check"></i></div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="stat-card bg-white">
            <div>
                <div class="stat-title">Kegiatan Bulan Ini</div>
                <div class="stat-value">{{ $kegiatanBulanIni }}</div>
                <div class="stat-trend"><i class="bi bi-arrow-up"></i> +5 kegiatan</div>
            </div>
            <div class="icon"><i class="bi bi-calendar-event"></i></div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="stat-card bg-white">
            <div>
                <div class="stat-title">Struktur Organisasi</div>
                <div class="stat-value">{{ $strukturOrganisasi }}</div>
                <div class="stat-trend"><i class="bi bi-arrow-up"></i> 45 Posisi terisi</div>
            </div>
            <div class="icon"><i class="bi bi-diagram-3"></i></div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Chart Anggota</div>
            <div class="card-body p-2">
                <canvas id="anggotaChart" height="100" style="max-width:100%;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">Perbandingan Pemilih Laki-laki & Perempuan</div>
            <div class="card-body">
                <canvas id="pemilihGenderChart" height="120"></canvas>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Rekap Input Petugas Lapangan</div>
            <ul class="list-group list-group-flush">
                @forelse($rekapPetugas as $petugas)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $petugas->petugas_lapangan }}
                    <span class="badge bg-success rounded-pill">{{ $petugas->jumlah }}</span>
                </li>
                @empty
                <li class="list-group-item text-muted">Belum ada data</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('anggotaChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Aktif', 'Tidak Aktif'],
            datasets: [{
                label: 'Jumlah Anggota',
                data: [{{ $anggotaAktif }}, {{ $totalAnggota - $anggotaAktif }}],
                backgroundColor: ['#198754', '#adb5bd'],
                borderRadius: 6,
                maxBarThickness: 40
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                x: { beginAtZero: true }
            }
        }
    });

    // Chart batang perbandingan pemilih laki-laki dan perempuan
    const ctxGender = document.getElementById('pemilihGenderChart').getContext('2d');
    new Chart(ctxGender, {
        type: 'bar',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                label: 'Jumlah Pemilih',
                data: [{{ $jumlahPemilihL }}, {{ $jumlahPemilihP }}],
                backgroundColor: ['#0d6efd', '#fb7185'],
                borderRadius: 6,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush 