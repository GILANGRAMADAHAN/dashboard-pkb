<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Dashboard DPC PKB Kabupaten Mempawah

Sistem database untuk mengelola data anggota, kegiatan, caleg, dan pemilih DPC PKB Kabupaten Mempawah.

## Fitur Utama

### Sistem Login User
- **Super Admin**: Dapat mengakses semua data dan fitur
- **User (Petugas Lapangan)**: Hanya dapat melihat dan mengelola data pemilih yang mereka input sendiri

### Akun Test
Berikut adalah akun test yang dapat digunakan:

#### Super Admin
- Email: `admin@pkb.com`
- Password: `password`
- Akses: Semua fitur dan data

#### Petugas Lapangan
- Email: `petugas1@pkb.com`, `petugas2@pkb.com`, `petugas3@pkb.com`
- Password: `password`
- Akses: Hanya data pemilih yang mereka input

### Keamanan Data
- Setiap user hanya dapat melihat data pemilih yang mereka input sendiri
- Super admin dapat melihat semua data dan informasi user yang membuat data
- Middleware `CheckUserOwnership` memastikan keamanan akses data
- Halaman error 403 dan 404 yang informatif

### Sistem Notifikasi
- **Notifikasi Real-time**: Super admin akan mendapat notifikasi setiap ada input data baru
- **Jenis Notifikasi**: 
  - Input data pemilih baru
  - Input data caleg baru
  - Input data anggota baru
  - Input data kegiatan baru
- **Fitur Notifikasi**:
  - Badge counter di header (hanya untuk super admin)
  - Update otomatis setiap 30 detik
  - Efek suara saat ada notifikasi baru
  - Halaman notifikasi lengkap dengan pagination
  - Tandai sebagai dibaca (individu atau semua)
  - Informasi detail untuk setiap notifikasi

### Fitur Data Pemilih
- Input data pemilih dengan validasi
- Rekap data pemilih dengan filter berdasarkan user
- Export PDF data pemilih
- Edit dan hapus data pemilih (hanya pemilik data atau super admin)

## Instalasi

1. Clone repository ini
2. Install dependencies: `composer install`
3. Copy file `.env.example` ke `.env` dan sesuaikan konfigurasi database
4. Generate key: `php artisan key:generate`
5. Jalankan migration: `php artisan migrate`
6. Jalankan seeder: `php artisan db:seed`
7. Serve aplikasi: `php artisan serve`

## Struktur Database

### Tabel Users
- `id`: Primary key
- `name`: Nama user
- `email`: Email user (unique)
- `password`: Password terenkripsi
- `role`: Role user ('superadmin' atau 'user')

### Tabel Pemilihs
- `id`: Primary key
- `user_id`: Foreign key ke tabel users (nullable)
- `nik`: NIK pemilih (unique)
- `nama`: Nama pemilih
- `jenis_kelamin`: Jenis kelamin ('L' atau 'P')
- `alamat`: Alamat pemilih
- `rt`: RT
- `rw`: RW
- `kecamatan`: Kecamatan
- `kelurahan`: Kelurahan/Desa
- `tps`: Tempat Pemungutan Suara
- `dapil`: Dapil (otomatis berdasarkan kecamatan)
- `koordinator`: Nama koordinator
- `petugas_lapangan`: Nama petugas lapangan
- `ktp`: File KTP (path)
- `created_at`: Waktu pembuatan
- `updated_at`: Waktu update

### Tabel Notifications
- `id`: Primary key
- `type`: Jenis notifikasi ('pemilih_baru', 'caleg_baru', 'anggota_baru', 'kegiatan_baru')
- `message`: Pesan notifikasi
- `data`: Data tambahan dalam format JSON
- `is_read`: Status dibaca (boolean)
- `read_at`: Waktu dibaca (timestamp)
- `created_at`: Waktu pembuatan
- `updated_at`: Waktu update

## Relasi Database

- `User` has many `Pemilih`
- `Pemilih` belongs to `User`

## Middleware

- `CheckUserOwnership`: Memastikan user hanya dapat mengakses data yang mereka buat
- Diterapkan pada route: show, edit, update, destroy pemilih

## Controllers

- `NotificationController`: Menangani sistem notifikasi
  - `index()`: Menampilkan semua notifikasi
  - `getUnreadCount()`: Mendapatkan jumlah notifikasi belum dibaca
  - `getUnreadNotifications()`: Mendapatkan notifikasi belum dibaca
  - `markAsRead()`: Tandai notifikasi sebagai dibaca
  - `markAllAsRead()`: Tandai semua notifikasi sebagai dibaca

## Routes

- `/notifications`: Halaman notifikasi
- `/notifications/unread-count`: API untuk jumlah notifikasi belum dibaca
- `/notifications/unread`: API untuk notifikasi belum dibaca
- `/notifications/{id}/mark-read`: API untuk tandai sebagai dibaca
- `/notifications/mark-all-read`: API untuk tandai semua sebagai dibaca

## Halaman Error

- `403.blade.php`: Halaman akses ditolak
- `404.blade.php`: Halaman tidak ditemukan

## Penggunaan

1. Login dengan akun yang sesuai
2. User biasa hanya dapat melihat menu "Input Data Pemilih" dan "Rekap Data Pemilih"
3. Super admin dapat melihat semua menu
4. Data pemilih akan otomatis terhubung dengan user yang membuatnya
5. Export PDF akan memfilter data berdasarkan user yang login
