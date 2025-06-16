<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;


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
// Route::get('profile', [userController::class, 'getUser']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/getUser', [AuthApiController::class, 'getUser']);
    Route::post('/logout', [AuthApiController::class, 'logout']);
});

    

