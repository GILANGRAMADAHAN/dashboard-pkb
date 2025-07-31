<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilih;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapPemilihController extends Controller
{
    public function index()
    {
        $query = \App\Models\Pemilih::orderBy('nama');
        
        // Filter berdasarkan user yang login (kecuali superadmin)
        if (auth()->check() && !auth()->user()->isSuperAdmin()) {
            $query->where('user_id', auth()->id());
        }
        
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
        $pemilih = $query->get();
        return view('rekap_pemilih', compact('pemilih'));
    }

    public function show($id)
    {
        $pemilih = \App\Models\Pemilih::findOrFail($id);
        
        // Pastikan user hanya bisa melihat data yang mereka buat (kecuali superadmin)
        if (auth()->check() && !auth()->user()->isSuperAdmin() && $pemilih->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat data ini.');
        }
        
        return view('rekap_pemilih_lihat', compact('pemilih'));
    }

    public function edit($id)
    {
        $pemilih = \App\Models\Pemilih::findOrFail($id);
        
        // Pastikan user hanya bisa mengedit data yang mereka buat (kecuali superadmin)
        if (auth()->check() && !auth()->user()->isSuperAdmin() && $pemilih->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit data ini.');
        }
        
        return view('rekap_pemilih_edit', compact('pemilih'));
    }

    public function update(Request $request, $id)
    {
        $pemilih = \App\Models\Pemilih::findOrFail($id);
        
        // Pastikan user hanya bisa mengupdate data yang mereka buat (kecuali superadmin)
        if (auth()->check() && !auth()->user()->isSuperAdmin() && $pemilih->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate data ini.');
        }
        
        try {
            $validated = $request->validate([
                'nik' => 'required|unique:pemilihs,nik,' . $pemilih->id,
                'nama' => 'required',
                'alamat' => 'nullable',
                'rt' => 'nullable',
                'rw' => 'nullable',
                'kecamatan' => 'required',
                'kelurahan' => 'required',
                'tps' => 'required',
                'koordinator' => 'nullable',
                'petugas_lapangan' => 'nullable',
                'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'dapil' => 'nullable',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($e->validator->errors()->has('nik')) {
                $nik = $request->input('nik');
                $existingPemilih = \App\Models\Pemilih::where('nik', $nik)->where('id', '!=', $pemilih->id)->first();
                
                $msg = 'NIK sudah digunakan';
                if ($existingPemilih) {
                    $msg .= ' dan sudah diinput oleh:';
                    if ($existingPemilih->petugas_lapangan) {
                        $msg .= ' Petugas Lapangan: ' . $existingPemilih->petugas_lapangan;
                    }
                    if ($existingPemilih->koordinator) {
                        $msg .= ($existingPemilih->petugas_lapangan ? ', ' : ' ') . 'Koordinator: ' . $existingPemilih->koordinator;
                    }
                    if ($existingPemilih->user) {
                        $msg .= ($existingPemilih->petugas_lapangan || $existingPemilih->koordinator ? ', ' : ' ') . 'User: ' . $existingPemilih->user->name;
                    }
                    
                    // Tambahkan informasi lokasi
                    $msg .= ' | Lokasi: ' . $existingPemilih->kecamatan . ', ' . $existingPemilih->kelurahan;
                    if ($existingPemilih->tps) {
                        $msg .= ', ' . $existingPemilih->tps;
                    }
                }
                return back()->withInput()->withErrors(['nik' => $msg]);
            }
            throw $e;
        }
        
        if ($request->hasFile('ktp')) {
            $validated['ktp'] = $request->file('ktp')->store('pemilih_ktp', 'public');
        }
        $pemilih->update($validated);
        return redirect()->route('rekap-pemilih')->with('success', 'Data pemilih berhasil diupdate!');
    }

    public function destroy($id)
    {
        $pemilih = \App\Models\Pemilih::findOrFail($id);
        
        // Pastikan user hanya bisa menghapus data yang mereka buat (kecuali superadmin)
        if (auth()->check() && !auth()->user()->isSuperAdmin() && $pemilih->user_id !== auth()->id()) {
            return redirect()->route('rekap-pemilih')->with('error', 'Anda tidak memiliki akses untuk menghapus data ini. Silakan hubungi admin.');
        }
        
        $pemilih->delete();
        return redirect()->route('rekap-pemilih')->with('success', 'Data pemilih berhasil dihapus!');
    }

    public function exportPdf()
    {
        $query = \App\Models\Pemilih::orderBy('nama');
        
        // Filter berdasarkan user yang login (kecuali superadmin)
        if (auth()->check() && !auth()->user()->isSuperAdmin()) {
            $query->where('user_id', auth()->id());
        }
        
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
        $pemilih = $query->get();
        $pdf = Pdf::loadView('rekap_pemilih_pdf', compact('pemilih'))->setPaper('a4', 'landscape');
        return $pdf->download('rekap_data_pemilih.pdf');
    }
} 