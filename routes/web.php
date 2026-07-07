<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DokumentasiController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KehadiranController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PelatihanController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\Admin\PimpinanController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\SertifikatController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\User\RiwayatController;
use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    $categories = KategoriPelatihan::withCount(['pelatihan' => function ($query) {
        $query->where('status', 'publish');
    }])->get();

    $latestTrainings = Pelatihan::with(['kategori'])
        ->whereIn('status', ['publish', 'closed'])
        ->latest()
        ->get();

    $stats = [
        'total_pelatihan' => Pelatihan::count(),
        'total_peserta' => User::count(),
        'total_sertifikat' => Sertifikat::count(),
    ];

    return view('landing', compact('categories', 'latestTrainings', 'stats'));
})->name('landing');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Accounts
    Route::resource('accounts', AccountController::class);

    // Kategori
    Route::resource('kategori', KategoriController::class);

    // Pelatihan
    Route::resource('pelatihan', PelatihanController::class);
    Route::patch('pelatihan/{pelatihan}/status', [PelatihanController::class, 'updateStatus'])->name('pelatihan.updateStatus');

    // Pendaftaran
    Route::get('pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::patch('pendaftaran/{pendaftaran}/setujui', [PendaftaranController::class, 'setujui'])->name('pendaftaran.setujui');
    Route::patch('pendaftaran/{pendaftaran}/tolak', [PendaftaranController::class, 'tolak'])->name('pendaftaran.tolak');

    // Kehadiran
    Route::get('kehadiran', [KehadiranController::class, 'index'])->name('kehadiran.index');
    Route::get('kehadiran/{pelatihan}', [KehadiranController::class, 'show'])->name('kehadiran.show');
    Route::patch('kehadiran/{pendaftaran}', [KehadiranController::class, 'update'])->name('kehadiran.update');
    Route::patch('kehadiran/{pelatihan}/toggle-mode', [KehadiranController::class, 'toggleMode'])->name('kehadiran.toggleMode');

    // Dokumentasi
    Route::resource('dokumentasi', DokumentasiController::class)->except(['show']);

    // Sertifikat
    Route::get('sertifikat', [SertifikatController::class, 'index'])->name('sertifikat.index');
    Route::post('sertifikat/generate/{pelatihan}', [SertifikatController::class, 'generate'])->name('sertifikat.generate');
    Route::get('sertifikat/pelatihan/{pelatihan}', [SertifikatController::class, 'showPelatihan'])->name('sertifikat.pelatihan.show');
    Route::post('sertifikat/generate-bulk/{pelatihan}', [SertifikatController::class, 'generateBulk'])->name('sertifikat.generate.bulk');
    Route::post('sertifikat/revoke-bulk/{pelatihan}', [SertifikatController::class, 'revokeBulk'])->name('sertifikat.revoke.bulk');
    Route::get('sertifikat/{sertifikat}/download', [SertifikatController::class, 'download'])->name('sertifikat.download');

    // Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/export/{format}', [LaporanController::class, 'export'])->name('laporan.export');

    // Pimpinan
    Route::get('pimpinan', [PimpinanController::class, 'index'])->name('pimpinan.index');
    Route::patch('pimpinan', [PimpinanController::class, 'update'])->name('pimpinan.update');

    // Profil
    Route::get('profil', [ProfilController::class, 'edit'])->name('profil');
    Route::patch('profil', [ProfilController::class, 'update'])->name('profil.update');
});

// User Routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

    // Pelatihan (public listing for users)
    Route::get('pelatihan', [App\Http\Controllers\User\PelatihanController::class, 'index'])->name('pelatihan.index');
    Route::get('pelatihan/{pelatihan}', [App\Http\Controllers\User\PelatihanController::class, 'show'])->name('pelatihan.show');

    // Pendaftaran
    Route::post('pendaftaran/{pelatihan}', [App\Http\Controllers\User\PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('pendaftaran-saya', [App\Http\Controllers\User\PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::post('pendaftaran/{pendaftaran}/presensi', [App\Http\Controllers\User\PendaftaranController::class, 'presensiMandiri'])->name('pendaftaran.presensi');

    // Kehadiran
    Route::get('kehadiran', [App\Http\Controllers\User\KehadiranController::class, 'index'])->name('kehadiran.index');
    Route::post('kehadiran/{pendaftaran}', [App\Http\Controllers\User\KehadiranController::class, 'store'])->name('kehadiran.store');

    // Riwayat
    Route::get('riwayat', [RiwayatController::class, 'index'])->name('riwayat');

    // Profil
    Route::get('profil', [App\Http\Controllers\User\ProfilController::class, 'edit'])->name('profil');
    Route::patch('profil', [App\Http\Controllers\User\ProfilController::class, 'update'])->name('profil.update');

    // Sertifikat
    Route::get('sertifikat', [App\Http\Controllers\User\SertifikatController::class, 'index'])->name('sertifikat.index');
    Route::get('sertifikat/{sertifikat}/download', [App\Http\Controllers\User\SertifikatController::class, 'download'])->name('sertifikat.download');
});

// Notification Routes
Route::middleware('auth')->group(function () {
    Route::post('notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::post('notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
});
