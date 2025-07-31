<html>
<head>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px; 
            margin: 20px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 { 
            color: #0d6efd; 
            margin: 0; 
        }
        .header p { 
            color: #666; 
            margin: 5px 0; 
        }
        .stats { 
            margin-bottom: 20px; 
        }
        .stats table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        .stats td { 
            padding: 8px; 
            border: 1px solid #ddd; 
            text-align: center; 
        }
        .stats .label { 
            background: #f8f9fa; 
            font-weight: bold; 
        }
        .notifications table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        .notifications th, .notifications td { 
            border: 1px solid #333; 
            padding: 6px 8px; 
            text-align: left; 
        }
        .notifications th { 
            background: #eee; 
            font-weight: bold; 
        }
        .status-unread { 
            background: #fff3cd; 
        }
        .status-read { 
            background: #d1edff; 
        }
        .type-icon { 
            font-size: 14px; 
        }
        .footer { 
            margin-top: 30px; 
            text-align: center; 
            font-size: 10px; 
            color: #666; 
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN NOTIFIKASI</h1>
        <p>Dashboard PKB Kabupaten Mempawah</p>
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats">
        <table>
            <tr>
                <td class="label">Total Notifikasi</td>
                <td>{{ $notifications->count() }}</td>
                <td class="label">Belum Dibaca</td>
                <td>{{ $notifications->where('is_read', false)->count() }}</td>
            </tr>
            <tr>
                <td class="label">Sudah Dibaca</td>
                <td>{{ $notifications->where('is_read', true)->count() }}</td>
                <td class="label">7 Hari Terakhir</td>
                <td>{{ $notifications->where('created_at', '>=', now()->subDays(7))->count() }}</td>
            </tr>
        </table>
    </div>

    <div class="notifications">
        <h3>Daftar Notifikasi</h3>
        @if($notifications->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tipe</th>
                        <th>Pesan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $index => $notification)
                    <tr class="{{ $notification->is_read ? 'status-read' : 'status-unread' }}">
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @switch($notification->type)
                                @case('pemilih_baru')
                                    <span class="type-icon">👤</span> Pemilih Baru
                                    @break
                                @case('caleg_baru')
                                    <span class="type-icon">🏛️</span> Caleg Baru
                                    @break
                                @case('anggota_baru')
                                    <span class="type-icon">👥</span> Anggota Baru
                                    @break
                                @case('kegiatan_baru')
                                    <span class="type-icon">📅</span> Kegiatan Baru
                                    @break
                                @default
                                    <span class="type-icon">ℹ️</span> {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                            @endswitch
                        </td>
                        <td>{{ $notification->message }}</td>
                        <td>
                            @if($notification->is_read)
                                <span style="color: green;">✓ Dibaca</span>
                            @else
                                <span style="color: orange;">● Belum Dibaca</span>
                            @endif
                        </td>
                        <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($notification->data)
                                @foreach($notification->data as $key => $value)
                                    <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}<br>
                                @endforeach
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #666; font-style: italic;">Tidak ada notifikasi</p>
        @endif
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat otomatis oleh sistem Dashboard PKB</p>
        <p>© {{ date('Y') }} DPC PKB Kabupaten Mempawah</p>
    </div>
</body>
</html> 