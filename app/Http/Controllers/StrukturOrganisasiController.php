<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StrukturOrganisasi;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $struktur = StrukturOrganisasi::orderBy('posisi')->get();
        return view('struktur', compact('struktur'));
    }

    public function create()
    {
        return view('struktur_tambah');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'posisi' => 'required',
            'nama_anggota' => 'required',
        ]);
        \App\Models\StrukturOrganisasi::create($validated);
        return redirect()->route('struktur')->with('success', 'Struktur berhasil ditambahkan!');
    }
} 