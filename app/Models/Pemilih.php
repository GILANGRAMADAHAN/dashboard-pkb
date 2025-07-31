<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemilih extends Model
{
    protected $fillable = [
        'nik', 'nama', 'jenis_kelamin', 'alamat', 'rt', 'rw', 'kecamatan', 'kelurahan', 'tps', 'koordinator', 'petugas_lapangan', 'ktp', 'dapil', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 