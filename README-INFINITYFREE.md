# Cara Deploy Dashboard PKB ke InfinityFree

## Langkah-langkah:

### 1. Buat Akun InfinityFree
- Buka [infinityfree.net](https://infinityfree.net)
- Sign up gratis
- Verifikasi email

### 2. Buat Hosting Account
- Login ke InfinityFree
- Klik "Create Account"
- Pilih subdomain (contoh: dashboard-pkb)
- Pilih server Asia

### 3. Buat Database MySQL
- Di dashboard InfinityFree, buat MySQL database
- Catat: hostname, username, password, database name

### 4. Upload File
- Download semua file dari GitHub
- Upload ke folder `htdocs` via File Manager
- Pastikan struktur folder tetap sama

### 5. Setup Environment
- Rename `env-infinityfree.txt` menjadi `.env`
- Update database credentials di file `.env`
- Update APP_URL sesuai subdomain Anda

### 6. Install Dependencies
- Buka terminal di InfinityFree (jika ada)
- Atau upload folder `vendor` dari local

### 7. Setup Database
- Run migrations: `php artisan migrate --seed`
- Atau import database manual

### 8. Set Permissions
- Folder `storage` dan `bootstrap/cache` harus writable
- Set permission 755 untuk folder tersebut

### 9. Akses Website
- Buka subdomain Anda: `https://dashboard-pkb.infinityfreeapp.com`
- Login dengan kredensial default

## Kredensial Login Default:
- Email: `superadmin@pkb.id`
- Password: `password`

## Troubleshooting:
- Jika error 500: cek file `.env` dan permissions
- Jika database error: cek kredensial database
- Jika blank page: cek error log di hosting 