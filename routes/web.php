<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\PengujianController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\WebAdminController;

Route::get('/', function () {
    return view('landing');
});


Route::get('/register', [WebAuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [WebAuthController::class, 'register'])->name('register');
Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [WebAuthController::class, 'login'])->name('login');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

Route::get('/pengujian/disclaimer', [PengujianController::class, 'pengujianDisclaimer'])->name('disclaimer');
Route::match(['get', 'post'], '/pengujian/dass21', [PengujianController::class, 'pengujianDass21'])->name('pengujiandass21');
Route::get('/pengujian/hasil/{id?}', [PengujianController::class, 'hasil'])->name('hasil');
Route::get('/konsultasi/daftarprofesional', [ProfessionalController::class, 'daftarProfessional'])->name('daftarprofesional');

#Client
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/dashboard', function () {
        return view('client.dashboard');
    })->name('client.dashboard');

    Route::get('/pengujian/riwayat', [PengujianController::class, 'riwayat'])->name('client.pengujian.riwayat');
    Route::get('/pengujian/lihat/{id}', [PengujianController::class, 'lihat'])->name('client.pengujian.lihat');
    Route::delete('/pengujian/hapus/{id}', [PengujianController::class, 'hapus'])->name('client.pengujian.hapus');

    Route::get('/konsultasi/pemesanan/{professional}', [KonsultasiController::class, 'showBookingPage'])->name('booking.page');
    Route::post('/konsultasi/pemesanan/store', [KonsultasiController::class, 'store'])->name('booking.store');
    Route::get('/konsultasi/detail/{konsultasi}', [KonsultasiController::class, 'detail'])->name('client.konsultasi.detail');
    Route::get('/konsultasi/riwayat', [KonsultasiController::class, 'index'])->name('client.konsultasi.index');
    Route::get('/konsultasi/riwayat/edit/{konsultasi}', [KonsultasiController::class, 'edit'])->name('client.konsultasi.edit');
    Route::put('/konsultasi/riwayat/update/{konsultasi}', [KonsultasiController::class, 'update'])->name('client.konsultasi.update');
    Route::delete('/konsultasi/riwayat/hapus/{konsultasi}', [KonsultasiController::class, 'destroy'])->name('client.konsultasi.destroy');

});

#Professional
Route::middleware(['auth', 'role:professional'])->group(function () {
    Route::get('/professional/dashboard', function () {
        return view('professional.dashboard');
    })->name('professional.dashboard');

    Route::get('/professional/konsultasi', [ProfessionalController::class, 'myClients'])->name('professional.konsultasi.index');
    Route::get('/professional/klien', [ProfessionalController::class, 'daftarKlien'])->name('professional.klien.index');
    Route::get('/professional/klien/{id}', [ProfessionalController::class, 'detailKlien'])->name('professional.klien.detail');

});

#Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [WebAdminController::class, 'dashboard'])->name('admin.dashboard');

    // Manajemen Professional (CRUD)
    Route::get('/admin/professionals', [WebAdminController::class, 'indexProfessional'])->name('admin.professionals.index');
    Route::get('/admin/professionals/create', [WebAdminController::class, 'createProfessional'])->name('admin.professionals.create');
    Route::post('/admin/professionals', [WebAdminController::class, 'storeProfessional'])->name('admin.professionals.store');
    Route::get('/admin/professionals/{professional}/edit', [WebAdminController::class, 'editProfessional'])->name('admin.professionals.edit');
    Route::put('/admin/professionals/{professional}', [WebAdminController::class, 'updateProfessional'])->name('admin.professionals.update');
    Route::delete('/admin/professionals/{professional}', [WebAdminController::class, 'destroyProfessional'])->name('admin.professionals.destroy');

    // Manajemen Layanan (CRUD)
    Route::get('/admin/layanans', [WebAdminController::class, 'indexlayanan'])->name('admin.layanans.index');
    Route::get('/admin/layanans/create', [WebAdminController::class, 'createlayanan'])->name('admin.layanans.create');
    Route::post('/admin/layanans', [WebAdminController::class, 'storelayanan'])->name('admin.layanans.store');
    Route::get('/admin/layanans/{layanan}/edit', [WebAdminController::class, 'editlayanan'])->name('admin.layanans.edit');
    Route::put('/admin/layanans/{layanan}', [WebAdminController::class, 'updatelayanan'])->name('admin.layanans.update');
    Route::delete('/admin/layanans/{layanan}', [WebAdminController::class, 'destroylayanan'])->name('admin.layanans.destroy');
});
