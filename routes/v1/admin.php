<?php

use App\Http\Controllers\V1\{ActionController, ApplicationController};
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth', 'role:admin,moderator,council'], 'as' => 'admin.'], function () {
    Route::group(['prefix' => 'application', 'as' => 'application.'], function () {
        Route::get('/', [ApplicationController::class, 'adminIndex'])->name('index');
    });

    Route::group(['prefix' => 'action', 'as' => 'action.'], function () {
        Route::get('/', [ActionController::class, 'adminIndex'])->name('index');
    });

});

