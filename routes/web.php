<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\PengujianController;

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


#Client
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/dashboard', function () {
        return view('client.dashboard');
    })->name('client.dashboard');

    Route::get('/pengujian/riwayat', [PengujianController::class, 'riwayat'])->name('client.pengujian.riwayat');
    Route::get('/pengujian/lihat/{id}', [PengujianController::class, 'lihat'])->name('client.pengujian.lihat');
    Route::delete('/pengujian/hapus/{id}', [PengujianController::class, 'hapus'])->name('client.pengujian.hapus');

});

#Professional
Route::middleware(['auth', 'role:professional'])->group(function () {
    Route::get('/professional/dashboard', function () {
        return view('professional.dashboard');
    })->name('professional.dashboard');



});

#Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');



});

