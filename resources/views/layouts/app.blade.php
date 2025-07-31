<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard DPC PKB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
        }
        .sidebar {
            min-width: 240px;
            max-width: 240px;
            min-height: 100vh;
            background: #0d6efd;
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1040;
        }
        .sidebar .sidebar-header {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1rem 1rem 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: #0d6efd;
            min-height: 64px;
        }
        .sidebar .sidebar-header .logo-bulat {
            width: 44px;
            height: 44px;
            /* Hapus background dan border-radius agar logo tampil kotak */
            background: none !important;
            border-radius: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            /* margin-right: 0.1rem; dihapus agar benar-benar rapat */
            flex-shrink: 0;
            padding: 0;
            box-shadow: none;
            cursor: pointer;
            position: relative;
        }
        .sidebar .sidebar-header .logo-bulat .logo-img { display: block; }
        .sidebar .sidebar-header .logo-bulat .logo-hamburger { display: none; }
        .sidebar.collapsed .sidebar-header .logo-bulat .logo-img { display: none; }
        .sidebar.collapsed .sidebar-header .logo-bulat .logo-hamburger { display: block; font-size: 1.7rem; color: #0d6efd; }
        .sidebar.collapsed .sidebar-header .brand-text { display: none !important; }
        .sidebar.collapsed .sidebar-header .collapse-btn { display: none; }
        .sidebar .sidebar-header .logo-bulat img {
            width: 36px;
            height: 36px;
            object-fit: contain;
            border-radius: 0;
            background: none !important;
            box-shadow: none !important;
        }
        .sidebar .sidebar-header .brand-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff;
            line-height: 1.1;
            margin-right: 1rem;
        }
        .sidebar .sidebar-header .brand-text .brand-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #fff;
        }
        .sidebar .sidebar-header .brand-text .brand-desc {
            font-size: 0.85rem;
            color: #fff;
            opacity: 0.85;
            font-weight: 400;
        }
        .sidebar .sidebar-header .close-btn {
            color: #fff;
            font-size: 1.2rem;
            background: transparent;
            border: none;
            outline: none;
            margin-left: auto;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        .sidebar .sidebar-header .close-btn:hover {
            opacity: 1;
        }
        .sidebar .nav-link {
            color: #fff;
            font-size: 1.05rem;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: #0b5ed7;
            color: #fff;
        }
        .sidebar .nav {
            flex-direction: column;
            margin-top: 1rem;
        }
        .sidebar .logout {
            margin-top: auto;
            margin-bottom: 1rem;
        }
        .main-content {
            margin-left: 240px;
            padding: 0;
            transition: margin-left 0.2s;
        }
        .sidebar.collapsed ~ .main-content {
            margin-left: 64px;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                left: -240px;
                transition: left 0.3s;
            }
            .sidebar.show {
                left: 0;
            }
            .main-content {
                margin-left: 0 !important;
            }
        }
        .navbar-avatar {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .navbar-avatar .avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }
        .sidebar .sidebar-header .logo-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 0.1rem;
        }
        .sidebar .sidebar-header .logo-img {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: #fff;
            padding: 2px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            object-fit: contain;
        }
        .sidebar .sidebar-header .logo {
            font-size: 1.1rem;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 0;
        }
        .sidebar .sidebar-header .desc {
            font-size: 0.85rem;
            color: #cfe2ff;
            margin-left: 0.5rem;
            margin-bottom: 0;
            font-weight: 400;
        }
        .navbar {
            min-height: 48px;
            padding-top: 0.2rem;
            padding-bottom: 0.2rem;
        }
        .sidebar.collapsed {
            max-width: 64px;
            min-width: 64px;
            transition: max-width 0.2s, min-width 0.2s;
        }
        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .logout {
            display: none !important;
        }
        .sidebar .sidebar-header .collapse-btn {
            color: #fff;
            font-size: 1.2rem;
            background: transparent;
            border: none;
            outline: none;
            margin-left: 0.5rem;
            opacity: 0.7;
            transition: opacity 0.2s;
            cursor: pointer;
        }
        .sidebar .sidebar-header .collapse-btn:hover {
            opacity: 1;
        }
        .sidebar .sidebar-header .expand-btn {
            color: #fff;
            font-size: 1.4rem;
            background: transparent;
            border: none;
            outline: none;
            margin-left: 0.5rem;
            opacity: 0.7;
            transition: opacity 0.2s;
            cursor: pointer;
            display: none;
        }
        .sidebar.collapsed .sidebar-header .expand-btn {
            display: block;
        }
        .sidebar.collapsed .sidebar-header .collapse-btn {
            display: none;
        }
        #mobileSidebarToggle {
            display: none;
            position: fixed;
            top: 16px;
            left: 16px;
            z-index: 2000;
            background: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 6px;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 2px 8px rgba(13,110,253,0.08);
        }
        @media (max-width: 991.98px) {
            #mobileSidebarToggle {
                display: flex;
            }
            .sidebar.show + #mobileSidebarToggle {
                display: none;
            }
        }
    </style>
</head>
<body>
    <nav class="sidebar" id="sidebarMenu">
        <div class="sidebar-header">
            <div class="logo-bulat" id="logoToggle">
                <img src="{{ asset('logo-pkb.png') }}" alt="Logo PKB" class="logo-img">
                <span class="logo-hamburger"><img src="{{ asset('logo-pkb.png') }}" alt="Logo PKB" style="width:28px;height:28px;"></span>
            </div>
            <div class="brand-text">
                <span class="brand-title">DPC PKB</span>
                <span class="brand-desc">Sistem Database</span>
            </div>
            <button class="collapse-btn" id="sidebarCollapse" aria-label="Perkecil Sidebar">&times;</button>
        </div>
        <ul class="nav nav-pills flex-column mb-auto">
            <li><a href="/dashboard" class="nav-link{{ request()->is('dashboard') ? ' active' : '' }}"><i class="bi bi-house-door"></i> <span>Dashboard</span></a></li>
            @if(auth()->user() && auth()->user()->role === 'user')
                <li><a href="/pemilih" class="nav-link{{ request()->is('pemilih*') ? ' active' : '' }}"><i class="bi bi-person-lines-fill"></i> <span>Input Data Pemilih</span></a></li>
                <li><a href="/rekap-pemilih" class="nav-link{{ request()->is('rekap-pemilih*') ? ' active' : '' }}"><i class="bi bi-clipboard-check"></i> <span>Rekap Data Pemilih</span></a></li>
            @else
                <li><a href="/anggota" class="nav-link{{ request()->is('anggota*') ? ' active' : '' }}"><i class="bi bi-people"></i> <span>Anggota</span></a></li>
                <li><a href="/kegiatan" class="nav-link{{ request()->is('kegiatan*') ? ' active' : '' }}"><i class="bi bi-calendar-event"></i> <span>Kegiatan</span></a></li>
                <li><a href="/struktur" class="nav-link{{ request()->is('struktur*') ? ' active' : '' }}"><i class="bi bi-diagram-3"></i> <span>Struktur Organisasi</span></a></li>
                <li><a href="/caleg" class="nav-link{{ request()->is('caleg*') ? ' active' : '' }}"><i class="bi bi-person-plus"></i> <span>Input Data Caleg</span></a></li>
                <li><a href="/pemilih" class="nav-link{{ request()->is('pemilih*') ? ' active' : '' }}"><i class="bi bi-person-lines-fill"></i> <span>Input Data Pemilih</span></a></li>
                <li><a href="/rekap-caleg" class="nav-link{{ request()->is('rekap-caleg*') ? ' active' : '' }}"><i class="bi bi-clipboard-data"></i> <span>Rekap Data Caleg</span></a></li>
                <li><a href="/perolehan-caleg" class="nav-link{{ request()->is('perolehan-caleg*') ? ' active' : '' }}"><i class="bi bi-bar-chart"></i> <span>Perolehan Suara Caleg</span></a></li>
                <li><a href="/rekap-pemilih" class="nav-link{{ request()->is('rekap-pemilih*') ? ' active' : '' }}"><i class="bi bi-clipboard-check"></i> <span>Rekap Data Pemilih</span></a></li>
                <li><a href="/rekap-tps" class="nav-link{{ request()->is('rekap-tps*') ? ' active' : '' }}"><i class="bi bi-building"></i> <span>Rekap Per TPS</span></a></li>
                <li><a href="/notifications" class="nav-link{{ request()->is('notifications*') ? ' active' : '' }}"><i class="bi bi-bell"></i> <span>Notifikasi</span></a></li>
                <li><a href="/user" class="nav-link{{ request()->is('user*') ? ' active' : '' }}"><i class="bi bi-person-circle"></i> <span>User Pengguna</span></a></li>
            @endif
        </ul>
        <div class="logout text-center">
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm mx-auto d-block"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
        </div>
    </nav>
    <button id="mobileSidebarToggle" aria-label="Buka Menu"><i class="bi bi-list"></i></button>
    <main class="main-content">
        <div class="container-fluid px-4 py-3">
            <div class="w-100 mb-2">
                <marquee behavior="scroll" direction="left" style="color:#198754;font-weight:bold;font-size:1.05rem;background:rgba(255,255,255,0.7);padding:4px 0;">
                    PROGRAM INI DIBUAT OLEH TIM IT DPC PKB KABUPATEN MEMPAWAH
                </marquee>
            </div>
            <div class="row mb-3">
                <div class="col-12 d-flex justify-content-end align-items-center flex-wrap">
                    @php $user = Auth::user(); @endphp
                    <div class="d-flex align-items-center gap-2" style="min-width:200px;">
                        @if(auth()->user() && auth()->user()->isSuperAdmin())
                        <div class="position-relative me-3 d-flex align-items-center">
                            <div class="me-2">
                                <button class="btn btn-outline-secondary btn-sm" onclick="toggleNotificationSound()" title="Toggle Suara Notifikasi">
                                    <i class="bi bi-volume-up" id="soundIcon"></i>
                                </button>
                            </div>
                            <a href="{{ route('notifications.index') }}" class="btn btn-outline-primary btn-sm position-relative">
                                <i class="bi bi-bell"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge" id="notificationBadge" style="display: none;">
                                    0
                                </span>
                            </a>
                        </div>
                        @endif
                        <img src="{{ asset('logo-pkb.png') }}" alt="Logo PKB" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                        <div class="d-flex flex-column">
                            <span class="fw-semibold" style="color:#0d6efd;">{{ $user ? $user->name : 'Super Admin' }}</span>
                            <span class="text-muted" style="font-size:0.95rem;">{{ $user ? ($user->isSuperAdmin() ? 'Super Admin' : 'User') : 'Super Admin' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </main>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/notification-sound.js') }}"></script>
    <script>
        // Sidebar toggle untuk mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarMenu = document.getElementById('sidebarMenu');
        if (sidebarToggle && sidebarMenu) {
            sidebarToggle.addEventListener('click', function() {
                sidebarMenu.classList.toggle('show');
            });
        }
        const sidebarClose = document.getElementById('sidebarClose');
        if (sidebarClose && sidebarMenu) {
            sidebarClose.addEventListener('click', function() {
                sidebarMenu.classList.remove('show');
            });
        }
        const sidebarCollapse = document.getElementById('sidebarCollapse');
        if (sidebarCollapse && sidebarMenu) {
            sidebarCollapse.addEventListener('click', function() {
                sidebarMenu.classList.toggle('collapsed');
            });
        }
        const logoToggle = document.getElementById('logoToggle');
        if (logoToggle && sidebarMenu) {
            logoToggle.addEventListener('click', function() {
                if (sidebarMenu.classList.contains('collapsed')) {
                    sidebarMenu.classList.remove('collapsed');
                }
            });
        }
        const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
        if (mobileSidebarToggle && sidebarMenu) {
            mobileSidebarToggle.addEventListener('click', function() {
                sidebarMenu.classList.add('show');
            });
        }

        // Notification system untuk super admin
        @if(auth()->user() && auth()->user()->isSuperAdmin())
        let lastNotificationCount = 0;
        let notificationSound = null;
        let soundEnabled = localStorage.getItem('notificationSoundEnabled') !== 'false'; // Default enabled
        
        // Inisialisasi notification sound
        document.addEventListener('DOMContentLoaded', function() {
            if (window.NotificationSound) {
                notificationSound = new NotificationSound();
            }
            updateSoundIcon();
        });
        
        function updateNotificationBadge() {
            fetch('{{ route("notifications.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notificationBadge');
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'block';
                        
                        // Play sound jika ada notifikasi baru
                        if (data.count > lastNotificationCount && lastNotificationCount > 0) {
                            // Ambil notifikasi terbaru untuk menentukan tipe suara
                            fetch('{{ route("notifications.latest") }}')
                                .then(response => response.json())
                                .then(notificationData => {
                                    if (notificationData.notification) {
                                        playNotificationSound(notificationData.notification.type);
                                    } else {
                                        playNotificationSound();
                                    }
                                })
                                .catch(error => {
                                    playNotificationSound();
                                });
                        }
                    } else {
                        badge.style.display = 'none';
                    }
                    lastNotificationCount = data.count;
                })
                .catch(error => console.error('Error updating notification badge:', error));
        }

        function playNotificationSound(type = 'default') {
            if (!soundEnabled) return; // Skip jika suara dinonaktifkan
            
            if (notificationSound) {
                notificationSound.playCustomSound(type);
            } else {
                // Fallback ke audio sederhana
                const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT');
                audio.volume = 0.3;
                audio.play().catch(e => console.log('Audio play failed:', e));
            }
        }

        function toggleNotificationSound() {
            soundEnabled = !soundEnabled;
            localStorage.setItem('notificationSoundEnabled', soundEnabled);
            updateSoundIcon();
            
            // Test suara jika diaktifkan
            if (soundEnabled) {
                playNotificationSound('default');
            }
        }

        function updateSoundIcon() {
            const icon = document.getElementById('soundIcon');
            if (icon) {
                icon.className = soundEnabled ? 'bi bi-volume-up' : 'bi bi-volume-mute';
            }
        }

        // Update notifikasi setiap 30 detik
        setInterval(updateNotificationBadge, 30000);
        
        // Update notifikasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            updateNotificationBadge();
        });
        @endif
    </script>
</body>
</html>
