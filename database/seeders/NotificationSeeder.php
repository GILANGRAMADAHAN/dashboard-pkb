<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat beberapa notifikasi test
        Notification::create([
            'type' => 'pemilih_baru',
            'message' => 'Data pemilih baru ditambahkan oleh Petugas Lapangan 1: Ahmad Suryadi (NIK: 1234567890123456)',
            'data' => [
                'pemilih_id' => 1,
                'user_id' => 2,
                'user_name' => 'Petugas Lapangan 1',
                'pemilih_nama' => 'Ahmad Suryadi',
                'pemilih_nik' => '1234567890123456',
                'kecamatan' => 'Mempawah Hilir',
                'kelurahan' => 'Kuala Secapah',
                'tps' => 'TPS 001'
            ],
            'is_read' => false,
        ]);

        Notification::create([
            'type' => 'caleg_baru',
            'message' => 'Data caleg baru ditambahkan oleh Super Admin: Budi Santoso (NIK: 9876543210987654)',
            'data' => [
                'caleg_id' => 1,
                'user_id' => 1,
                'user_name' => 'Super Admin',
                'caleg_nama' => 'Budi Santoso',
                'caleg_nik' => '9876543210987654',
                'nomor_kursi' => '1',
                'dapil' => 'Dapil 1',
                'kecamatan' => 'Mempawah Timur',
                'kelurahan' => 'Antibar',
                'tps' => 'TPS 002'
            ],
            'is_read' => false,
        ]);

        Notification::create([
            'type' => 'anggota_baru',
            'message' => 'Data anggota baru ditambahkan oleh Super Admin: Siti Nurhaliza (NIK: 1122334455667788)',
            'data' => [
                'anggota_id' => 1,
                'user_id' => 1,
                'user_name' => 'Super Admin',
                'anggota_nama' => 'Siti Nurhaliza',
                'anggota_nik' => '1122334455667788',
                'posisi' => 'Ketua',
                'status' => 'Aktif'
            ],
            'is_read' => true,
            'read_at' => now(),
        ]);

        Notification::create([
            'type' => 'kegiatan_baru',
            'message' => 'Kegiatan baru ditambahkan oleh Super Admin: Rapat Koordinasi Bulanan',
            'data' => [
                'kegiatan_id' => 1,
                'user_id' => 1,
                'user_name' => 'Super Admin',
                'kegiatan_judul' => 'Rapat Koordinasi Bulanan',
                'tanggal' => '2025-08-15',
                'waktu' => '09:00'
            ],
            'is_read' => false,
        ]);
    }
}
