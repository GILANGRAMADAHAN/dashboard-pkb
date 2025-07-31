<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Notification;

class AnggotaController extends Controller
{
    public function index()
    {
        $query = Anggota::orderBy('id', 'desc');
        if (request()->filled('nik')) {
            $query->where('nik', 'like', '%' . request('nik') . '%');
        }
        $anggota = $query->paginate(15);
        return view('anggota', compact('anggota'));
    }

    public function create()
    {
        return view('anggota_tambah');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'posisi' => 'required',
            'nik' => 'required|unique:anggotas,nik',
            'telepon' => 'required',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_bergabung' => 'required|date',
            'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        if ($request->hasFile('ktp')) {
            $validated['ktp'] = $request->file('ktp')->store('ktp', 'public');
        }
        
        $anggota = \App\Models\Anggota::create($validated);
        
        // Buat notifikasi untuk super admin
        $user = auth()->user();
        Notification::createNotification(
            'anggota_baru',
            "Data anggota baru ditambahkan oleh {$user->name}: {$anggota->nama} (NIK: {$anggota->nik})",
            [
                'anggota_id' => $anggota->id,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'anggota_nama' => $anggota->nama,
                'anggota_nik' => $anggota->nik,
                'posisi' => $anggota->posisi,
                'status' => $anggota->status
            ]
        );
        
        return redirect()->route('anggota')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function show($id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);
        return view('anggota_lihat', compact('anggota'));
    }

    public function edit($id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);
        return view('anggota_edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required',
            'posisi' => 'required',
            'nik' => 'required|unique:anggotas,nik,' . $anggota->id,
            'telepon' => 'required',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_bergabung' => 'required|date',
            'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        if ($request->hasFile('ktp')) {
            $validated['ktp'] = $request->file('ktp')->store('ktp', 'public');
        }
        $anggota->update($validated);
        return redirect()->route('anggota')->with('success', 'Data anggota berhasil diupdate!');
    }
} 