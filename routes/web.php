<?php
use Illuminate\Support\Facades\Route;

// ROUTE DEMO FRONTEND FASLINK — belum memakai autentikasi/database.
Route::view('/login', 'login')->name('login');
Route::get('/', fn () => redirect()->route('login'));
Route::prefix('faslink')->name('user.')->group(function () {
    Route::view('/', 'user.dashboard')->name('dashboard');
    Route::view('/katalog', 'user.catalog')->name('catalog');
    Route::view('/fasilitas/detail', 'user.facility-detail')->name('facility.detail');
    Route::view('/pengajuan/buat', 'user.loan-create')->name('loan.create');
    Route::view('/pengajuan-saya', 'user.loans')->name('loans');
    Route::view('/pengajuan/detail', 'user.loan-detail')->name('loan.detail');
    Route::view('/riwayat', 'user.history')->name('history');
    Route::view('/profil', 'user.profile')->name('profile');
});
Route::prefix('faslink/admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.dashboard', ['role' => 'admin'])->name('dashboard');
    Route::view('/fasilitas', 'admin.facilities.index', ['role' => 'admin'])->name('facilities');
    Route::view('/fasilitas/tambah', 'admin.facilities.form', ['role' => 'admin'])->name('facilities.create');
    Route::view('/pengajuan', 'admin.loans', ['role' => 'admin'])->name('loans');
    Route::view('/verifikasi', 'admin.verification', ['role' => 'admin'])->name('verification');
    Route::view('/riwayat-persetujuan', 'admin.approvals', ['role' => 'admin'])->name('approvals');
    Route::view('/serah-terima', 'admin.handover', ['role' => 'admin'])->name('handover');
    Route::view('/pengembalian', 'admin.returns', ['role' => 'admin'])->name('returns');
    Route::view('/kerusakan', 'admin.damage', ['role' => 'admin'])->name('damage');
    Route::view('/laporan', 'admin.reports', ['role' => 'admin'])->name('reports');
    Route::view('/pengguna', 'admin.users', ['role' => 'admin'])->name('users');
    Route::view('/pengaturan', 'admin.profile', ['role' => 'admin'])->name('profile');
});
