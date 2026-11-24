
<?php

use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::view('/login', 'login')->name('login');
Route::get('/', fn () => redirect()->route('login'));

Route::prefix('faslink')->name('user.')->group(function () {
    Route::view('/', 'user.dashboard')->name('dashboard');
    Route::view('/katalog', 'user.catalog')->name('catalog');
    Route::view('/fasilitas/detail', 'user.facility-detail')->name('facility.detail');

    Route::get('/kalender', [LoanController::class, 'calendar'])->name('calendar');
    Route::get('/kalender/data', [LoanController::class, 'calendarEvents'])->name('calendar.events');

    Route::get('/pengajuan/buat', [LoanController::class, 'create'])->name('loan.create');
    Route::post('/pengajuan', [LoanController::class, 'store'])->name('loan.store');
    Route::get('/pengajuan-saya', [LoanController::class, 'index'])->name('loans');
    Route::get('/pengajuan/{loan}/dokumen/{document}', [LoanController::class, 'downloadDocument'])
        ->name('loan.document');

    Route::get('/pengajuan/{loan}/edit', [LoanController::class, 'edit'])->name('loan.edit');
    Route::put('/pengajuan/{loan}', [LoanController::class, 'update'])->name('loan.update');
    Route::delete('/pengajuan/{loan}', [LoanController::class, 'destroy'])->name('loan.destroy');
    Route::get('/pengajuan/{loan}', [LoanController::class, 'show'])->name('loan.detail');

    Route::view('/riwayat', 'user.history')->name('history');
    Route::view('/profil', 'user.profile')->name('profile');
});

Route::prefix('faslink/admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.dashboard', ['role' => 'admin'])->name('dashboard');
    Route::view('/fasilitas', 'admin.facilities.index', ['role' => 'admin'])->name('facilities');
    Route::view('/fasilitas/tambah', 'admin.facilities.form', ['role' => 'admin'])->name('facilities.create');

    Route::get('/pengajuan', [LoanController::class, 'adminIndex'])->name('loans');

    Route::get('/pengajuan/{loan}/dokumen/{document}', [LoanController::class, 'adminDownloadDocument'])
        ->name('loan.document');

    Route::get('/pengajuan/{loan}', [LoanController::class, 'adminShow'])->name('loan.detail');

    Route::view('/verifikasi', 'admin.verification', ['role' => 'admin'])->name('verification');
    Route::view('/riwayat-persetujuan', 'admin.approvals', ['role' => 'admin'])->name('approvals');
    Route::view('/serah-terima', 'admin.handover', ['role' => 'admin'])->name('handover');
    Route::view('/pengembalian', 'admin.returns', ['role' => 'admin'])->name('returns');
    Route::view('/kerusakan', 'admin.damage', ['role' => 'admin'])->name('damage');
    Route::view('/laporan', 'admin.reports', ['role' => 'admin'])->name('reports');
    Route::view('/pengguna', 'admin.users', ['role' => 'admin'])->name('users');
    Route::view('/pengaturan', 'admin.profile', ['role' => 'admin'])->name('profile');
});