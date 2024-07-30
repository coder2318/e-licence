<?php

use App\Http\Controllers\V1\{AuthController, EimzoController, OneIdController};
use Illuminate\Support\Facades\Route;


Route::post('/login', [OneIdController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'loginPage'])->name('login.page');

Route::group(['prefix' => 'one-id', 'as' => 'one-id.'], function () {
    Route::get('redirect', [OneIdController::class, 'redirect'])->name('redirect');
    Route::get('callback', [OneIdController::class, 'callback'])->name('callback');
});

Route::group(['prefix' => 'e-imzo', 'as' => 'e-imzo.'], function () {
    Route::get('challenge', [EimzoController::class, 'challenge'])->name('challenge');
    Route::post('auth', [EimzoController::class, 'auth'])->name('auth');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/assignRole', [AuthController::class, 'assignRole']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

