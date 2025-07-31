# Fitur Suara Notifikasi Dashboard PKB

## Deskripsi
Sistem suara notifikasi telah ditambahkan ke dashboard PKB untuk memberikan feedback audio ketika ada notifikasi baru masuk.

## Fitur yang Ditambahkan

### 1. Sistem Suara Notifikasi
- **Web Audio API**: Menggunakan Web Audio API untuk menghasilkan suara notifikasi yang berkualitas tinggi
- **Fallback System**: Jika Web Audio API tidak didukung, sistem akan menggunakan HTML5 Audio sebagai fallback
- **Volume Control**: Kontrol volume suara notifikasi (0.3 atau 30%)

### 2. Jenis Suara Berbeda
Sistem mendukung 5 jenis suara notifikasi yang berbeda:

1. **Default Sound** - Suara standar untuk notifikasi umum
   - Frekuensi: 800Hz → 600Hz → 800Hz
   - Durasi: 300ms

2. **Pemilih Baru** - Suara khusus untuk notifikasi pemilih baru
   - Pola: 2 beep pendek
   - Frekuensi: 600Hz
   - Durasi: 400ms

3. **Caleg Baru** - Suara khusus untuk notifikasi caleg baru
   - Pola: 3 beep pendek
   - Frekuensi: 800Hz
   - Durasi: 550ms

4. **Kegiatan Baru** - Suara khusus untuk notifikasi kegiatan baru
   - Pola: Melodi naik (400Hz → 500Hz → 600Hz → 700Hz)
   - Durasi: 400ms

5. **Urgent** - Suara untuk notifikasi urgent
   - Pola: Beep panjang
   - Frekuensi: 1000Hz
   - Durasi: 500ms

### 3. Kontrol Suara
- **Toggle Button**: Tombol untuk mengaktifkan/menonaktifkan suara notifikasi
- **Icon Indicator**: Icon berubah sesuai status suara (volume-up/volume-mute)
- **Persistent Setting**: Pengaturan suara disimpan di localStorage

### 4. Test Suara
- **Test Button**: Tombol untuk menguji semua jenis suara notifikasi
- **Sequential Play**: Memainkan semua jenis suara secara berurutan dengan delay 1 detik

### 5. Clear Notifikasi
- **Hapus Individual**: Tombol hapus untuk setiap notifikasi
- **Hapus Dibaca**: Hapus semua notifikasi yang sudah dibaca
- **Hapus Semua**: Hapus semua notifikasi (dengan konfirmasi ganda)
- **Konfirmasi Keamanan**: Dialog konfirmasi untuk mencegah penghapusan tidak sengaja

### 6. Filter & Statistik
- **Filter Status**: Filter berdasarkan status dibaca/belum dibaca
- **Filter Tipe**: Filter berdasarkan tipe notifikasi
- **Filter Tanggal**: Filter berdasarkan tanggal notifikasi
- **Statistik**: Tampilan statistik notifikasi (total, belum dibaca, sudah dibaca, 7 hari terakhir)

### 7. Export PDF
- **Export dengan Filter**: Export notifikasi sesuai filter yang aktif
- **Template PDF**: Template PDF yang rapi dengan statistik dan detail notifikasi
- **Format Lengkap**: Informasi lengkap termasuk tipe, status, tanggal, dan data tambahan

## File yang Ditambahkan/Dimodifikasi

### File Baru:
- `public/js/notification-sound.js` - Library untuk menghasilkan suara notifikasi
- `resources/views/notifications/pdf.blade.php` - Template PDF untuk notifikasi

### File yang Dimodifikasi:
- `resources/views/layouts/app.blade.php` - Menambahkan sistem notifikasi dengan suara
- `app/Http/Controllers/NotificationController.php` - Menambahkan endpoint untuk notifikasi terbaru dan fitur clear
- `routes/web.php` - Menambahkan route untuk endpoint notifikasi terbaru dan clear
- `resources/views/notifications/index.blade.php` - Menambahkan tombol test suara dan fitur clear notifikasi

## Cara Penggunaan

### 1. Mengontrol Suara Notifikasi
- Klik tombol volume di navbar (sebelah icon notifikasi)
- Icon akan berubah dari volume-up ke volume-mute atau sebaliknya
- Pengaturan akan disimpan dan tetap aktif sampai diubah

### 2. Menguji Suara Notifikasi
- Buka halaman Notifikasi
- Klik tombol "Test Suara"
- Sistem akan memainkan semua jenis suara secara berurutan

### 3. Suara Otomatis
- Suara akan otomatis diputar ketika ada notifikasi baru
- Jenis suara akan disesuaikan dengan tipe notifikasi
- Hanya aktif jika suara diaktifkan

### 4. Clear Notifikasi
- **Hapus Individual**: Klik tombol trash (🗑️) pada setiap notifikasi
- **Hapus Dibaca**: Klik tombol "Hapus Dibaca" untuk menghapus notifikasi yang sudah dibaca
- **Hapus Semua**: Klik tombol "Hapus Semua" untuk menghapus semua notifikasi (memerlukan konfirmasi ganda)

### 5. Filter Notifikasi
- Gunakan form filter untuk mencari notifikasi berdasarkan status, tipe, atau tanggal
- Klik "Filter" untuk menerapkan filter
- Klik "Reset" untuk menghapus semua filter

### 6. Export PDF
- Klik tombol "Export PDF" untuk mengunduh laporan notifikasi dalam format PDF
- Export akan mengikuti filter yang sedang aktif
- PDF berisi statistik dan detail lengkap notifikasi

## Teknis Implementasi

### Web Audio API
```javascript
// Membuat oscillator untuk menghasilkan suara
const oscillator = this.audioContext.createOscillator();
const gainNode = this.audioContext.createGain();

// Set properti suara
oscillator.frequency.setValueAtTime(800, this.audioContext.currentTime);
oscillator.type = 'sine';

// Mainkan suara
oscillator.start(this.audioContext.currentTime);
oscillator.stop(this.audioContext.currentTime + 0.3);
```

### Fallback System
```javascript
// Generate suara menggunakan data URI
const audio = new Audio();
const wavData = this.float32ToWav(audioData, sampleRate);
const blob = new Blob([wavData], { type: 'audio/wav' });
const url = URL.createObjectURL(blob);
audio.src = url;
```

### Kontrol Suara
```javascript
// Toggle suara notifikasi
function toggleNotificationSound() {
    soundEnabled = !soundEnabled;
    localStorage.setItem('notificationSoundEnabled', soundEnabled);
    updateSoundIcon();
}
```

## Browser Support
- **Modern Browsers**: Chrome, Firefox, Safari, Edge (Web Audio API)
- **Legacy Browsers**: Fallback ke HTML5 Audio
- **Mobile Browsers**: Dukungan terbatas, menggunakan fallback

## Troubleshooting

### Suara Tidak Berfungsi
1. Pastikan browser mendukung Web Audio API
2. Periksa apakah suara diaktifkan (icon volume-up)
3. Periksa volume sistem
4. Periksa console untuk error

### Suara Terlalu Keras/Lemah
- Volume suara diatur ke 30% (0.3)
- Untuk mengubah volume, edit file `notification-sound.js`

### Suara Tidak Otomatis
1. Pastikan ada notifikasi baru
2. Periksa apakah suara diaktifkan
3. Periksa koneksi internet (untuk fetch notifikasi)

## Keamanan
- Suara hanya diputar untuk super admin
- Tidak ada akses ke file sistem
- Semua suara di-generate secara dinamis
- Tidak ada file audio eksternal yang diunduh

## Performa
- Suara di-generate secara real-time
- Tidak ada file audio yang disimpan
- Memory usage minimal
- Tidak mempengaruhi performa aplikasi 