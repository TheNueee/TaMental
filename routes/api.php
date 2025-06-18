<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TestingApiController;
use App\Http\Controllers\Api\AdminApiController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', [AuthApiController::class, 'authenticate'])->name('login');
Route::post('/register', [AuthApiController::class, 'register'])->name('register');


Route::get('/pengujian/pertanyaan', [TestingApiController::class, 'getPertanyaan']);

// User profile routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthApiController::class, 'getUser']);
    Route::post('/user/update-profile', [AuthApiController::class, 'updateProfile']);
    Route::post('/logout', [AuthApiController::class, 'logout']);
});

Route::prefix('pengujian')->group(function () {
    // Anonymous route for submitting tests without authentication
    Route::post('/submit/anonymous', [TestingApiController::class, 'submitPengujian']);
    
    Route::middleware(['auth:sanctum'])->group(function () {
        // Authenticated route for submitting tests
        Route::post('/submit', [TestingApiController::class, 'submitPengujian']);
        Route::get('/riwayat', [TestingApiController::class, 'getRiwayat']);
        Route::get('/detailpengujian/{id}', [TestingApiController::class, 'getDetail']);
        Route::delete('/hapusPengujian/{id}', [TestingApiController::class, 'hapusPengujian']);
    });
});

// Admin routes for professional account management
Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Professional management
    Route::post('/create-professional', [AdminApiController::class, 'createProfessional']);
    Route::get('/professionals', [AdminApiController::class, 'getProfessionals']);
    Route::get('/professionals/{id}', [AdminApiController::class, 'getProfessionalDetail']);
    Route::put('/professionals/{id}', [AdminApiController::class, 'updateProfessional']);
    Route::delete('/professionals/{id}', [AdminApiController::class, 'deleteProfessional']);

    // License management
    Route::get('/professionals/{id}/licenses', [AdminApiController::class, 'getProfessionalLicenses']);
});

// Professional routes
Route::prefix('professional')->middleware(['auth:sanctum', 'role:professional'])->group(function () {
    Route::get('/profile', [AuthApiController::class, 'getProfessionalProfile']);
    Route::put('/profile', [AuthApiController::class, 'updateProfessionalProfile']);
});
