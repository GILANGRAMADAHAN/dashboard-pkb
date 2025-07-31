<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Kegiatan;
use App\Models\StrukturOrganisasi;
use App\Models\Caleg;
use App\Models\Pemilih;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::where('status', 'Aktif')->count();
        $kegiatanBulanIni = Kegiatan::whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->count();
        $strukturOrganisasi = StrukturOrganisasi::count();

        $kegiatanTerbaru = Kegiatan::orderBy('tanggal', 'desc')->limit(3)->get();
        $anggota = Anggota::orderBy('id')->limit(10)->get();

        // Statistik cepat (dummy)
        $targetKeanggotaan = 1500;
        $kehadiranRapat = 92; // %
        $programSelesai = 15;
        $targetProgram = 20;

        // Distribusi anggota (dummy)
        $distribusi = [
            'Jakarta Pusat' => 324,
            'Jakarta Utara' => 298,
            'Jakarta Selatan' => 356,
            'Jakarta Timur' => 269,
        ];

        $totalCaleg = Caleg::count();
        $totalPemilih = Pemilih::count();
        $jumlahPemilihL = \App\Models\Pemilih::where('jenis_kelamin', 'L')->count();
        $jumlahPemilihP = \App\Models\Pemilih::where('jenis_kelamin', 'P')->count();

        $rekapPetugas = \App\Models\Pemilih::select('petugas_lapangan')
            ->whereNotNull('petugas_lapangan')
            ->groupBy('petugas_lapangan')
            ->selectRaw('petugas_lapangan, COUNT(*) as jumlah')
            ->orderByDesc('jumlah')
            ->get();

        return view('dashboard', compact(
            'totalAnggota', 'anggotaAktif', 'kegiatanBulanIni', 'strukturOrganisasi',
            'kegiatanTerbaru', 'anggota', 'targetKeanggotaan', 'kehadiranRapat', 'programSelesai', 'targetProgram', 'distribusi',
            'totalCaleg', 'totalPemilih', 'jumlahPemilihL', 'jumlahPemilihP', 'rekapPetugas'
        ));
    }
} 