
<?php

use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\FacilityCatalogController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

// Halaman Login
Route::view('/login', 'login')->name('login');

// Halaman utama
Route::get('/', fn () => redirect()->route('login'));

// Halaman Mahasiswa
Route::prefix('faslink')->name('user.')->group(function () {

    Route::view('/', 'user.dashboard')->name('dashboard');

    // Katalog fasilitas
    Route::get('/katalog', [FacilityCatalogController::class, 'index'])
        ->name('catalog');

    // Detail fasilitas
    Route::get('/fasilitas/detail/{facility}', [FacilityCatalogController::class, 'show'])
        ->name('facility.detail');

    // Kalender
    Route::get('/kalender', [LoanController::class, 'calendar'])
        ->name('calendar');

    Route::get('/kalender/data', [LoanController::class, 'calendarEvents'])
        ->name('calendar.events');

    // Pengajuan peminjaman
    Route::get('/pengajuan/buat', [LoanController::class, 'create'])
        ->name('loan.create');

    Route::post('/pengajuan', [LoanController::class, 'store'])
        ->name('loan.store');

    Route::get('/pengajuan-saya', [LoanController::class, 'index'])
        ->name('loans');

    Route::get('/pengajuan/{loan}/dokumen/{document}', [LoanController::class, 'downloadDocument'])
        ->name('loan.document');

    Route::get('/pengajuan/{loan}/edit', [LoanController::class, 'edit'])
        ->name('loan.edit');

    Route::put('/pengajuan/{loan}', [LoanController::class, 'update'])
        ->name('loan.update');

    Route::delete('/pengajuan/{loan}', [LoanController::class, 'destroy'])
        ->name('loan.destroy');

    Route::get('/pengajuan/{loan}', [LoanController::class, 'show'])
        ->name('loan.detail');

    // Riwayat dan profil
    Route::view('/riwayat', 'user.history')->name('history');

    Route::view('/profil', 'user.profile')->name('profile');
});

// Halaman Admin
Route::prefix('faslink/admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::view('/', 'admin.dashboard', ['role' => 'admin'])
        ->name('dashboard');

    // Manajemen fasilitas
    Route::resource('facilities', FacilityController::class)->names([
        'index' => 'facilities',
        'create' => 'facilities.create',
        'store' => 'facilities.store',
        'show' => 'facilities.show',
        'edit' => 'facilities.edit',
        'update' => 'facilities.update',
        'destroy' => 'facilities.destroy',
    ]);

    // Pengajuan peminjaman Admin
    Route::get('/pengajuan', [LoanController::class, 'adminIndex'])
        ->name('loans');

    Route::get('/pengajuan/{loan}/dokumen/{document}', [LoanController::class, 'adminDownloadDocument'])
        ->name('loan.document');

    Route::get('/pengajuan/{loan}', [LoanController::class, 'adminShow'])
        ->name('loan.detail');

    // Menu Admin lainnya
    Route::view('/verifikasi', 'admin.verification', ['role' => 'admin'])
        ->name('verification');

    Route::view('/riwayat-persetujuan', 'admin.approvals', ['role' => 'admin'])
        ->name('approvals');

    Route::view('/serah-terima', 'admin.handover', ['role' => 'admin'])
        ->name('handover');

    Route::view('/pengembalian', 'admin.returns', ['role' => 'admin'])
        ->name('returns');

    Route::view('/kerusakan', 'admin.damage', ['role' => 'admin'])
        ->name('damage');

    Route::view('/laporan', 'admin.reports', ['role' => 'admin'])
        ->name('reports');

    Route::view('/pengguna', 'admin.users', ['role' => 'admin'])
        ->name('users');

    Route::view('/pengaturan', 'admin.profile', ['role' => 'admin'])
        ->name('profile');
});
