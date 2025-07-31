<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Notification;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::orderBy('tanggal', 'desc')->paginate(15);
        return view('kegiatan', compact('kegiatan'));
    }

    public function create()
    {
        return view('kegiatan_tambah');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'deskripsi' => 'nullable',
        ]);
        
        $kegiatan = \App\Models\Kegiatan::create($validated);
        
        // Buat notifikasi untuk super admin
        $user = auth()->user();
        Notification::createNotification(
            'kegiatan_baru',
            "Kegiatan baru ditambahkan oleh {$user->name}: {$kegiatan->judul}",
            [
                'kegiatan_id' => $kegiatan->id,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'kegiatan_judul' => $kegiatan->judul,
                'tanggal' => $kegiatan->tanggal,
                'waktu' => $kegiatan->waktu
            ]
        );
        
        return redirect()->route('kegiatan')->with('success', 'Kegiatan berhasil ditambahkan!');
    }
} 