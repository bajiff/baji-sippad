<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    $categories = \App\Models\KategoriPelatihan::withCount(['pelatihan' => function ($query) {
        $query->where('status', 'publish');
    }])->get();

    $latestTrainings = \App\Models\Pelatihan::with(['kategori'])
        ->where('status', 'publish')
        ->latest()
        ->take(3)
        ->get();

    $stats = [
        'total_pelatihan' => \App\Models\Pelatihan::whereIn('status', ['publish', 'selesai'])->count(),
        'total_peserta' => \App\Models\User::where('role', 'user')->count(),
        'total_sertifikat' => \App\Models\Sertifikat::count(),
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

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Kategori
    Route::resource('kategori', \App\Http\Controllers\Admin\KategoriController::class);

    // Pelatihan
    Route::resource('pelatihan', \App\Http\Controllers\Admin\PelatihanController::class);
    Route::patch('pelatihan/{pelatihan}/status', [\App\Http\Controllers\Admin\PelatihanController::class, 'updateStatus'])->name('pelatihan.updateStatus');

    // Pendaftaran
    Route::get('pendaftaran', [\App\Http\Controllers\Admin\PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::patch('pendaftaran/{pendaftaran}/setujui', [\App\Http\Controllers\Admin\PendaftaranController::class, 'setujui'])->name('pendaftaran.setujui');
    Route::patch('pendaftaran/{pendaftaran}/tolak', [\App\Http\Controllers\Admin\PendaftaranController::class, 'tolak'])->name('pendaftaran.tolak');

    // Kehadiran
    Route::get('kehadiran', [\App\Http\Controllers\Admin\KehadiranController::class, 'index'])->name('kehadiran.index');
    Route::get('kehadiran/{pelatihan}', [\App\Http\Controllers\Admin\KehadiranController::class, 'show'])->name('kehadiran.show');
    Route::patch('kehadiran/{pendaftaran}', [\App\Http\Controllers\Admin\KehadiranController::class, 'update'])->name('kehadiran.update');

    // Dokumentasi
    Route::resource('dokumentasi', \App\Http\Controllers\Admin\DokumentasiController::class)->except(['show']);

    // Sertifikat
    Route::get('sertifikat', [\App\Http\Controllers\Admin\SertifikatController::class, 'index'])->name('sertifikat.index');
    Route::post('sertifikat/generate/{pelatihan}', [\App\Http\Controllers\Admin\SertifikatController::class, 'generate'])->name('sertifikat.generate');

    // Laporan
    Route::get('laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/export/{format}', [\App\Http\Controllers\Admin\LaporanController::class, 'export'])->name('laporan.export');
});

// User Routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

    // Pelatihan (public listing for users)
    Route::get('pelatihan', [\App\Http\Controllers\User\PelatihanController::class, 'index'])->name('pelatihan.index');
    Route::get('pelatihan/{pelatihan}', [\App\Http\Controllers\User\PelatihanController::class, 'show'])->name('pelatihan.show');

    // Pendaftaran
    Route::post('pendaftaran/{pelatihan}', [\App\Http\Controllers\User\PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('pendaftaran-saya', [\App\Http\Controllers\User\PendaftaranController::class, 'index'])->name('pendaftaran.index');

    // Riwayat
    Route::get('riwayat', [\App\Http\Controllers\User\RiwayatController::class, 'index'])->name('riwayat');

    // Profil
    Route::get('profil', [\App\Http\Controllers\User\ProfilController::class, 'edit'])->name('profil');
    Route::patch('profil', [\App\Http\Controllers\User\ProfilController::class, 'update'])->name('profil.update');

    // Sertifikat
    Route::get('sertifikat/{sertifikat}/download', [\App\Http\Controllers\User\SertifikatController::class, 'download'])->name('sertifikat.download');
});
