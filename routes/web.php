<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\CalegController;
use App\Http\Controllers\RekapCalegController;
use App\Http\Controllers\PemilihController;
use App\Http\Controllers\RekapPemilihController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\PerolehanCalegController;
use App\Http\Controllers\RekapTpsController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota');
Route::get('/anggota/tambah', [AnggotaController::class, 'create'])->name('anggota.create');
Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
Route::get('/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
Route::put('/anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
Route::get('/anggota/{id}', [AnggotaController::class, 'show'])->name('anggota.show');
Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan');
Route::get('/kegiatan/tambah', [KegiatanController::class, 'create'])->name('kegiatan.create');
Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
Route::get('/struktur', [StrukturOrganisasiController::class, 'index'])->name('struktur');
Route::get('/struktur/tambah', [StrukturOrganisasiController::class, 'create'])->name('struktur.create');
Route::post('/struktur', [StrukturOrganisasiController::class, 'store'])->name('struktur.store');
Route::get('/caleg', [CalegController::class, 'create'])->name('caleg.create');
Route::post('/caleg', [CalegController::class, 'store'])->name('caleg.store');
Route::get('/rekap-caleg', [RekapCalegController::class, 'index'])->name('rekap-caleg');
Route::get('/rekap-caleg/{id}', [RekapCalegController::class, 'show'])->name('rekap-caleg.show');
Route::get('/rekap-caleg/{id}/edit', [RekapCalegController::class, 'edit'])->name('rekap-caleg.edit');
Route::put('/rekap-caleg/{id}', [RekapCalegController::class, 'update'])->name('rekap-caleg.update');
Route::delete('/rekap-caleg/{id}', [RekapCalegController::class, 'destroy'])->name('rekap-caleg.destroy');
Route::get('/rekap-caleg/export/pdf', [App\Http\Controllers\RekapCalegController::class, 'exportPdf'])->name('rekap-caleg.export.pdf');
Route::get('/pemilih', [PemilihController::class, 'create'])->name('pemilih.create');
Route::post('/pemilih', [PemilihController::class, 'store'])->name('pemilih.store');
Route::get('/rekap-pemilih', [RekapPemilihController::class, 'index'])->name('rekap-pemilih');
Route::get('/rekap-pemilih/{id}', [RekapPemilihController::class, 'show'])->name('rekap-pemilih.show')->middleware('check.ownership');
Route::get('/rekap-pemilih/{id}/edit', [RekapPemilihController::class, 'edit'])->name('rekap-pemilih.edit')->middleware('check.ownership');
Route::put('/rekap-pemilih/{id}', [RekapPemilihController::class, 'update'])->name('rekap-pemilih.update')->middleware('check.ownership');
Route::delete('/rekap-pemilih/{id}', [RekapPemilihController::class, 'destroy'])->name('rekap-pemilih.destroy')->middleware('check.ownership');
Route::get('/rekap-pemilih/export/pdf', [App\Http\Controllers\RekapPemilihController::class, 'exportPdf'])->name('rekap-pemilih.export.pdf');
Route::resource('user', UserController::class)->except(['create']);
Route::get('/login', function() { return view('login'); })->name('login');
Route::post('/login', function(Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }
    return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
})->name('login.attempt');
Route::post('/logout', function(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
Route::get('/perolehan-caleg', [PerolehanCalegController::class, 'index'])->name('perolehan-caleg');
Route::post('/perolehan-caleg', [PerolehanCalegController::class, 'update'])->name('perolehan-caleg.update');

// Rekap Per TPS
Route::get('/rekap-tps', [RekapTpsController::class, 'index'])->name('rekap-tps');
Route::get('/rekap-tps/{tps}/{kecamatan}', [RekapTpsController::class, 'detail'])->name('rekap-tps.detail');
Route::get('/rekap-tps/export/pdf', [RekapTpsController::class, 'exportPdf'])->name('rekap-tps.export.pdf');

// Notifications
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
Route::get('/notifications/unread', [NotificationController::class, 'getUnreadNotifications'])->name('notifications.unread');
Route::get('/notifications/latest', [NotificationController::class, 'getLatestNotification'])->name('notifications.latest');
Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
Route::delete('/notifications/clear-all', [NotificationController::class, 'clearAllNotifications'])->name('notifications.clear-all');
Route::delete('/notifications/clear-read', [NotificationController::class, 'clearReadNotifications'])->name('notifications.clear-read');
Route::delete('/notifications/{id}', [NotificationController::class, 'deleteNotification'])->name('notifications.delete');
Route::get('/notifications/export/pdf', [NotificationController::class, 'exportPdf'])->name('notifications.export.pdf');


