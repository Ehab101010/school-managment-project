<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

 

Route::get('/', fn() => redirect()->route('login'));

Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

 Route::get('/change-password',  [AuthController::class, 'showChangePassword'])->name('password.change');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});