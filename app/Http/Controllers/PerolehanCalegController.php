<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caleg;

class PerolehanCalegController extends Controller
{
    public function index()
    {
        $calegs = \App\Models\Caleg::orderBy('nama')->get();
        $pemilih = \App\Models\Pemilih::all();
        // Hitung suara berdasarkan koordinator = nama caleg
        foreach ($calegs as $caleg) {
            $caleg->suara = $pemilih->where('koordinator', $caleg->nama)->count();
        }
        return view('perolehan_caleg', compact('calegs'));
    }

    public function update(Request $request)
    {
        // Tidak perlu update manual, karena suara dihitung otomatis dari pemilih
        return redirect()->route('perolehan-caleg')->with('success', 'Perolehan suara dihitung otomatis dari data pemilih!');
    }
} 