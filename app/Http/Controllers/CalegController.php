<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caleg;
use App\Models\Notification;

class CalegController extends Controller
{
    public function create()
    {
        return view('caleg_input');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'nomor_kursi' => 'required',
            'dapil' => 'nullable',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'alamat' => 'nullable',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'kecamatan' => 'nullable',
            'kelurahan' => 'nullable',
            'tps' => 'required',
        ]);
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('caleg', 'public');
        }
        
        $caleg = Caleg::create($validated);
        
        // Buat notifikasi untuk super admin
        $user = auth()->user();
        Notification::createNotification(
            'caleg_baru',
            "Data caleg baru ditambahkan oleh {$user->name}: {$caleg->nama} (NIK: {$caleg->nik})",
            [
                'caleg_id' => $caleg->id,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'caleg_nama' => $caleg->nama,
                'caleg_nik' => $caleg->nik,
                'nomor_kursi' => $caleg->nomor_kursi,
                'dapil' => $caleg->dapil,
                'kecamatan' => $caleg->kecamatan,
                'kelurahan' => $caleg->kelurahan,
                'tps' => $caleg->tps
            ]
        );
        
        return redirect()->route('caleg.create')->with('success', 'Data caleg berhasil disimpan!');
    }
} 