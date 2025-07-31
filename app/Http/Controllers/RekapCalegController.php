<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caleg;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapCalegController extends Controller
{
    public function index()
    {
        $query = Caleg::orderBy('nama');
        if (request()->filled('q')) {
            $q = request('q');
            $query->where(function($sub) use ($q) {
                $sub->where('nik', 'like', "%$q%")
                    ->orWhere('nama', 'like', "%$q%") ;
            });
        }
        if (request()->filled('dapil')) {
            $query->where('dapil', request('dapil'));
        }
        $caleg = $query->get();
        return view('rekap_caleg', compact('caleg'));
    }

    public function show($id)
    {
        $caleg = \App\Models\Caleg::findOrFail($id);
        return view('rekap_caleg_lihat', compact('caleg'));
    }

    public function edit($id)
    {
        $caleg = \App\Models\Caleg::findOrFail($id);
        return view('rekap_caleg_edit', compact('caleg'));
    }

    public function update(Request $request, $id)
    {
        $caleg = \App\Models\Caleg::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'nomor_kursi' => 'required',
            'dapil' => 'nullable',
            'tps' => 'required',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'alamat' => 'nullable',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'kecamatan' => 'nullable',
            'kelurahan' => 'nullable',
        ]);
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('caleg', 'public');
        }
        $caleg->update($validated);
        return redirect()->route('rekap-caleg')->with('success', 'Data caleg berhasil diupdate!');
    }

    public function destroy($id)
    {
        $caleg = \App\Models\Caleg::findOrFail($id);
        $caleg->delete();
        return redirect()->route('rekap-caleg')->with('success', 'Data caleg berhasil dihapus!');
    }

    public function exportPdf()
    {
        $query = Caleg::orderBy('nama');
        if (request()->filled('q')) {
            $q = request('q');
            $query->where(function($sub) use ($q) {
                $sub->where('nik', 'like', "%$q%")
                    ->orWhere('nama', 'like', "%$q%") ;
            });
        }
        if (request()->filled('dapil')) {
            $query->where('dapil', request('dapil'));
        }
        $caleg = $query->get();
        $pdf = Pdf::loadView('rekap_caleg_pdf', compact('caleg'))->setPaper('a4', 'landscape');
        return $pdf->download('rekap_data_caleg.pdf');
    }
} 