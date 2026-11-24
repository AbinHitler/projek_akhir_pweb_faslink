<?php

use App\Http\Controllers\Admin\FacilityController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

/*
| Modul Manajemen Fasilitas (prototype)
| Route admin belum memakai middleware auth karena project ini masih
| menggunakan halaman login/demo dan belum memiliki alur autentikasi aktif.
| Aktifkan middleware auth + middleware role admin setelah autentikasi siap.
*/
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', fn () => redirect()->route('admin.facilities'))->name('dashboard');

        Route::resource('facilities', FacilityController::class)
            ->names([
                'index' => 'facilities',
                'create' => 'facilities.create',
                'store' => 'facilities.store',
                'show' => 'facilities.show',
                'edit' => 'facilities.edit',
                'update' => 'facilities.update',
                'destroy' => 'facilities.destroy',
            ]);
    });
