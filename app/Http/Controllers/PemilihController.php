<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilih;
use App\Models\Notification;

class PemilihController extends Controller
{
    public function create()
    {
        return view('pemilih_input');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nik' => 'required|unique:pemilihs,nik',
                'nama' => 'required',
                'jenis_kelamin' => 'required|in:L,P',
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
                $pemilih = \App\Models\Pemilih::where('nik', $nik)->first();
                
                $msg = 'NIK sudah digunakan';
                if ($pemilih) {
                    $msg .= ' untuk ' . $pemilih->nama . ' dan sudah diinput oleh:';
                    if ($pemilih->petugas_lapangan) {
                        $msg .= ' Petugas Lapangan: ' . $pemilih->petugas_lapangan;
                    }
                    if ($pemilih->koordinator) {
                        $msg .= ($pemilih->petugas_lapangan ? ', ' : ' ') . 'Koordinator: ' . $pemilih->koordinator;
                    }
                    if ($pemilih->user) {
                        $msg .= ($pemilih->petugas_lapangan || $pemilih->koordinator ? ', ' : ' ') . 'User: ' . $pemilih->user->name;
                    }
                    
                    // Tambahkan informasi lokasi
                    $msg .= ' | Lokasi: ' . $pemilih->kecamatan . ', ' . $pemilih->kelurahan;
                    if ($pemilih->tps) {
                        $msg .= ', ' . $pemilih->tps;
                    }
                }
                return back()->withInput()->withErrors(['nik' => $msg]);
            }
            throw $e;
        }
        if ($request->hasFile('ktp')) {
            $validated['ktp'] = $request->file('ktp')->store('pemilih_ktp', 'public');
        }
        
        // Tambahkan user_id dari user yang sedang login
        $validated['user_id'] = auth()->id();
        
        $pemilih = Pemilih::create($validated);
        
        // Buat notifikasi untuk super admin
        $user = auth()->user();
        Notification::createNotification(
            'pemilih_baru',
            "Data pemilih baru ditambahkan oleh {$user->name}: {$pemilih->nama} (NIK: {$pemilih->nik})",
            [
                'pemilih_id' => $pemilih->id,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'pemilih_nama' => $pemilih->nama,
                'pemilih_nik' => $pemilih->nik,
                'kecamatan' => $pemilih->kecamatan,
                'kelurahan' => $pemilih->kelurahan,
                'tps' => $pemilih->tps
            ]
        );
        
        return redirect()->route('pemilih.create')->with('success', 'Data pemilih berhasil disimpan!');
    }
} 