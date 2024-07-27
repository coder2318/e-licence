<?php

use App\Http\Controllers\V1\ApplicationController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth', 'role:admin'], 'as' => 'admin.'], function () {
    Route::group(['prefix' => 'application', 'as' => 'application.'], function () {
        Route::get('/', [ApplicationController::class, 'adminIndex'])->name('index');
    });
});

