<?php

use App\Http\Controllers\V1\ApplicationController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth']], function () {

    Route::resource('application', ApplicationController::class)->names('application');
});

