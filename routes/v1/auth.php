<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\OneIdController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [OneIdController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'loginPage'])->name('login.page');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/assignRole', [AuthController::class, 'assignRole']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

