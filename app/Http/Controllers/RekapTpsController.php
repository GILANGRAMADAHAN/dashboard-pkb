<?php

namespace App\Http\Controllers;

use App\Models\Pemilih;
use App\Models\Caleg;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapTpsController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemilih::selectRaw('
            tps,
            kecamatan,
            kelurahan,
            dapil,
            COUNT(*) as jumlah_pemilih
        ')
        ->whereNotNull('tps')
        ->where('tps', '!=', '')
        ->groupBy('tps', 'kecamatan', 'kelurahan', 'dapil');

        // Filter berdasarkan kecamatan
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Filter berdasarkan TPS
        if ($request->filled('tps')) {
            $query->where('tps', 'like', '%' . $request->tps . '%');
        }

        $tpsData = $query->get();

        // Tambahkan data caleg untuk setiap TPS
        foreach ($tpsData as $tps) {
            // Hitung caleg berdasarkan dapil, bukan berdasarkan TPS
            $calegCount = 0;
            if ($tps->dapil) {
                $calegCount = Caleg::where('dapil', $tps->dapil)->count();
            }
            
            $tps->jumlah_caleg = $calegCount;
            $tps->total = $tps->jumlah_pemilih + $calegCount;
        }

        return view('rekap_tps', compact('tpsData'));
    }

    public function detail(Request $request, $tps, $kecamatan)
    {
        // Data pemilih untuk TPS tertentu
        $pemilih = Pemilih::where('tps', $tps)
                         ->where('kecamatan', $kecamatan)
                         ->get();

        // Ambil dapil dari data pemilih
        $dapil = $pemilih->first() ? $pemilih->first()->dapil : null;

        // Data caleg berdasarkan dapil (bukan berdasarkan TPS)
        $caleg = collect();
        if ($dapil) {
            $caleg = Caleg::where('dapil', $dapil)->get();
        }

        // Hitung statistik
        $jumlahPemilih = $pemilih->count();
        $jumlahCaleg = $caleg->count();
        $total = $jumlahPemilih + $jumlahCaleg;

        return view('rekap_tps_detail', compact(
            'tps', 
            'kecamatan', 
            'pemilih', 
            'caleg', 
            'jumlahPemilih', 
            'jumlahCaleg', 
            'total', 
            'dapil'
        ));
    }

    public function exportPdf(Request $request)
    {
        try {
            if ($request->filled('tps') && $request->filled('kecamatan')) {
                // Export detail TPS tertentu
                return $this->exportDetailPdf($request->tps, $request->kecamatan);
            } else {
                // Export semua TPS
                return $this->exportAllPdf($request);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    private function exportAllPdf(Request $request)
    {
        try {
            $query = Pemilih::selectRaw('
                tps,
                kecamatan,
                kelurahan,
                dapil,
                COUNT(*) as jumlah_pemilih
            ')
            ->whereNotNull('tps')
            ->where('tps', '!=', '')
            ->groupBy('tps', 'kecamatan', 'kelurahan', 'dapil');

            // Filter berdasarkan kecamatan
            if ($request->filled('kecamatan')) {
                $query->where('kecamatan', $request->kecamatan);
            }

            // Filter berdasarkan TPS
            if ($request->filled('tps')) {
                $query->where('tps', 'like', '%' . $request->tps . '%');
            }

            $tpsData = $query->get();

            // Tambahkan data caleg untuk setiap TPS
            foreach ($tpsData as $tps) {
                // Hitung caleg berdasarkan dapil, bukan berdasarkan TPS
                $calegCount = 0;
                if ($tps->dapil) {
                    $calegCount = Caleg::where('dapil', $tps->dapil)->count();
                }
                
                $tps->jumlah_caleg = $calegCount;
                $tps->total = $tps->jumlah_pemilih + $calegCount;
            }

            $pdf = Pdf::loadView('rekap_tps_pdf_all', compact('tpsData'));
            return $pdf->download('rekap-tps-' . date('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    private function exportDetailPdf($tps, $kecamatan)
    {
        try {
            // Data pemilih untuk TPS tertentu
            $pemilih = Pemilih::where('tps', $tps)
                             ->where('kecamatan', $kecamatan)
                             ->get();

            // Ambil dapil dari data pemilih
            $dapil = $pemilih->first() ? $pemilih->first()->dapil : null;

            // Data caleg berdasarkan dapil (bukan berdasarkan TPS)
            $caleg = collect();
            if ($dapil) {
                $caleg = Caleg::where('dapil', $dapil)->get();
            }

            // Hitung statistik
            $jumlahPemilih = $pemilih->count();
            $jumlahCaleg = $caleg->count();
            $total = $jumlahPemilih + $jumlahCaleg;

            // Generate PDF dengan view yang lengkap
            $pdf = Pdf::loadView('rekap_tps_pdf', compact(
                'tps', 
                'kecamatan', 
                'pemilih', 
                'caleg', 
                'jumlahPemilih', 
                'jumlahCaleg', 
                'total', 
                'dapil'
            ));
            
            return $pdf->download('rekap-tps-' . $tps . '-' . date('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
} 