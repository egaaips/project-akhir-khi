<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\UserController;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::resource('absensi', AbsensiController::class);
    Route::post('/absensi/masuk', [AbsensiController::class, 'absenMasuk'])->name('absensi.masuk');
    Route::post('/absensi/keluar', [AbsensiController::class, 'absenKeluar'])->name('absensi.keluar');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/pegawai', function () {
    return view('pegawai');
});

Route::fallback(function () {
    return view('errors.404');
});

Route::resource('pegawai', PegawaiController::class)->middleware('isAdmin');

Route::resource('users', UserController::class)->middleware('isAdmin');
Route::post('user-update-role',[UserController::class,'updateRole'])->name('users.update-role');

Route::resource('departemen', DepartemenController::class)->middleware('isAdmin');
Route::resource('jadwal', JadwalController::class)->middleware('isAdmin');
Route::resource('laporan', LaporanController::class)->middleware('isAdmin');

Route::get('/laporan/export-pdf/{id}', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
// Route::get('/truncate', function () {
//     Pegawai::truncate();
// });
