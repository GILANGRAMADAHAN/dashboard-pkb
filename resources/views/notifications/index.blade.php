@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-bell"></i> Notifikasi
        </h5>
        <div>
            <button class="btn btn-sm btn-outline-success me-2" onclick="testNotificationSounds()">
                <i class="bi bi-volume-up"></i> Test Suara
            </button>
            <button class="btn btn-sm btn-outline-primary me-2" onclick="markAllAsRead()">
                <i class="bi bi-check-all"></i> Tandai Semua Dibaca
            </button>
            <div class="btn-group me-2" role="group">
                <button class="btn btn-sm btn-outline-warning" onclick="clearReadNotifications()" title="Hapus Notifikasi yang Sudah Dibaca">
                    <i class="bi bi-trash"></i> Hapus Dibaca
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="clearAllNotifications()" title="Hapus Semua Notifikasi">
                    <i class="bi bi-trash-fill"></i> Hapus Semua
                </button>
            </div>
            <a href="{{ route('notifications.export.pdf', request()->query()) }}" class="btn btn-sm btn-outline-info" title="Export ke PDF">
                <i class="bi bi-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Statistik Notifikasi -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $notifications->total() }}</h5>
                        <p class="card-text">Total Notifikasi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $notifications->where('is_read', false)->count() }}</h5>
                        <p class="card-text">Belum Dibaca</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $notifications->where('is_read', true)->count() }}</h5>
                        <p class="card-text">Sudah Dibaca</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $notifications->where('created_at', '>=', now()->subDays(7))->count() }}</h5>
                        <p class="card-text">7 Hari Terakhir</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Notifikasi -->
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('notifications.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="type" class="form-label">Tipe</label>
                                <select name="type" id="type" class="form-select">
                                    <option value="">Semua Tipe</option>
                                    <option value="pemilih_baru" {{ request('type') == 'pemilih_baru' ? 'selected' : '' }}>Pemilih Baru</option>
                                    <option value="caleg_baru" {{ request('type') == 'caleg_baru' ? 'selected' : '' }}>Caleg Baru</option>
                                    <option value="anggota_baru" {{ request('type') == 'anggota_baru' ? 'selected' : '' }}>Anggota Baru</option>
                                    <option value="kegiatan_baru" {{ request('type') == 'kegiatan_baru' ? 'selected' : '' }}>Kegiatan Baru</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i> Filter
                                    </button>
                                    <a href="{{ route('notifications.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-clockwise"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($notifications->count() > 0)
            <div class="list-group">
                @foreach($notifications as $notification)
                <div class="list-group-item list-group-item-action {{ $notification->is_read ? '' : 'list-group-item-warning' }}" 
                     id="notification-{{ $notification->id }}">
                    <div class="d-flex w-100 justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                @if($notification->type === 'pemilih_baru')
                                    <i class="bi bi-person-plus text-primary me-2"></i>
                                @elseif($notification->type === 'caleg_baru')
                                    <i class="bi bi-person-badge text-success me-2"></i>
                                @elseif($notification->type === 'anggota_baru')
                                    <i class="bi bi-people text-info me-2"></i>
                                @elseif($notification->type === 'kegiatan_baru')
                                    <i class="bi bi-calendar-event text-warning me-2"></i>
                                @else
                                    <i class="bi bi-info-circle text-info me-2"></i>
                                @endif
                                <h6 class="mb-0">{{ $notification->message }}</h6>
                                @if(!$notification->is_read)
                                    <span class="badge bg-danger ms-2">Baru</span>
                                @endif
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> {{ $notification->created_at->diffForHumans() }}
                            </small>
                            @if($notification->data)
                                <div class="mt-2">
                                    @if(isset($notification->data['kecamatan']))
                                        <span class="badge bg-secondary me-1">{{ $notification->data['kecamatan'] }}</span>
                                    @endif
                                    @if(isset($notification->data['kelurahan']))
                                        <span class="badge bg-secondary me-1">{{ $notification->data['kelurahan'] }}</span>
                                    @endif
                                    @if(isset($notification->data['tps']))
                                        <span class="badge bg-secondary me-1">{{ $notification->data['tps'] }}</span>
                                    @endif
                                    @if(isset($notification->data['dapil']))
                                        <span class="badge bg-secondary me-1">{{ $notification->data['dapil'] }}</span>
                                    @endif
                                    @if(isset($notification->data['posisi']))
                                        <span class="badge bg-info me-1">{{ $notification->data['posisi'] }}</span>
                                    @endif
                                    @if(isset($notification->data['status']))
                                        <span class="badge {{ $notification->data['status'] === 'Aktif' ? 'bg-success' : 'bg-danger' }} me-1">{{ $notification->data['status'] }}</span>
                                    @endif
                                    @if(isset($notification->data['tanggal']))
                                        <span class="badge bg-warning me-1">{{ \Carbon\Carbon::parse($notification->data['tanggal'])->format('d/m/Y') }}</span>
                                    @endif
                                    @if(isset($notification->data['waktu']))
                                        <span class="badge bg-warning me-1">{{ $notification->data['waktu'] }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="ms-3">
                            @if(!$notification->is_read)
                                <button class="btn btn-sm btn-outline-success me-1" onclick="markAsRead({{ $notification->id }})" title="Tandai Dibaca">
                                    <i class="bi bi-check"></i>
                                </button>
                            @endif
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteNotification({{ $notification->id }})" title="Hapus Notifikasi">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-bell-slash" style="font-size: 3rem; color: #6c757d;"></i>
                <h5 class="mt-3 text-muted">Tidak ada notifikasi</h5>
                <p class="text-muted">Belum ada notifikasi yang masuk.</p>
            </div>
        @endif
    </div>
</div>

<script>
function markAsRead(id) {
    fetch(`/notifications/${id}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notificationElement = document.getElementById(`notification-${id}`);
            notificationElement.classList.remove('list-group-item-warning');
            notificationElement.querySelector('.badge').remove();
            notificationElement.querySelector('.btn').remove();
            updateNotificationBadge();
        }
    })
    .catch(error => console.error('Error marking notification as read:', error));
}

function deleteNotification(id) {
    if (!confirm('Hapus notifikasi ini? Tindakan ini tidak dapat dibatalkan.')) {
        return;
    }
    
    fetch(`/notifications/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hapus elemen notifikasi dari DOM
            const notificationElement = document.getElementById(`notification-${id}`);
            if (notificationElement) {
                notificationElement.remove();
                
                // Periksa apakah masih ada notifikasi
                const remainingNotifications = document.querySelectorAll('.list-group-item');
                if (remainingNotifications.length === 0) {
                    // Reload halaman jika tidak ada notifikasi tersisa
                    location.reload();
                }
            }
            
            // Update badge notifikasi
            updateNotificationBadge();
        }
    })
    .catch(error => {
        console.error('Error deleting notification:', error);
        alert('Terjadi kesalahan saat menghapus notifikasi');
    });
}

function markAllAsRead() {
    if (!confirm('Tandai semua notifikasi sebagai dibaca?')) {
        return;
    }
    
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error marking all notifications as read:', error));
}

function testNotificationSounds() {
    if (window.NotificationSound) {
        const notificationSound = new NotificationSound();
        
        // Test semua jenis suara notifikasi
        const sounds = [
            { type: 'default', name: 'Default' },
            { type: 'pemilih_baru', name: 'Pemilih Baru' },
            { type: 'caleg_baru', name: 'Caleg Baru' },
            { type: 'kegiatan_baru', name: 'Kegiatan Baru' },
            { type: 'urgent', name: 'Urgent' }
        ];
        
        let currentIndex = 0;
        
        function playNextSound() {
            if (currentIndex < sounds.length) {
                const sound = sounds[currentIndex];
                console.log(`Playing ${sound.name} sound...`);
                notificationSound.playCustomSound(sound.type);
                currentIndex++;
                setTimeout(playNextSound, 1000); // Delay 1 detik antara suara
            }
        }
        
        playNextSound();
    } else {
        alert('Notification sound system tidak tersedia');
    }
}

function clearReadNotifications() {
    if (!confirm('Hapus semua notifikasi yang sudah dibaca? Tindakan ini tidak dapat dibatalkan.')) {
        return;
    }
    
    fetch('/notifications/clear-read', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload halaman untuk memperbarui tampilan
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error clearing read notifications:', error);
        alert('Terjadi kesalahan saat menghapus notifikasi');
    });
}

function clearAllNotifications() {
    if (!confirm('HAPUS SEMUA NOTIFIKASI? Tindakan ini akan menghapus semua notifikasi dan tidak dapat dibatalkan!')) {
        return;
    }
    
    // Konfirmasi kedua untuk keamanan
    if (!confirm('Anda yakin ingin menghapus SEMUA notifikasi? Tindakan ini tidak dapat dibatalkan!')) {
        return;
    }
    
    fetch('/notifications/clear-all', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload halaman untuk memperbarui tampilan
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error clearing all notifications:', error);
        alert('Terjadi kesalahan saat menghapus notifikasi');
    });
}
</script>
@endsection 