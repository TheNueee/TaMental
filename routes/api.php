<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;


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


Route::post('/login', [userController::class, 'loginUser'])->name('login');
Route::post('/register', [userController::class, 'register'])->name('register');
// Route::get('profile', [userController::class, 'getUser']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [userController::class, 'getUser']);
    Route::post('/logout', [userController::class, 'logout']);
});

    

