<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caleg extends Model
{
    protected $fillable = [
        'nama', 'nik', 'jenis_kelamin', 'nomor_kursi', 'dapil', 'foto', 'alamat', 'rt', 'rw', 'kecamatan', 'kelurahan', 'tps', 'suara'
    ];
} 