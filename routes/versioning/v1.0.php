<?php

use App\Http\Controllers\AuthCheckerController;
use App\Http\Middleware\AuthApi;
use Illuminate\Support\Facades\Route;

Route::get('/apiCheck', [AuthCheckerController::class, 'isAlive']);

Route::group([
    'middleware' => AuthApi::class,
], function () {
    Route::get('/authCheck', [AuthCheckerController::class, 'isAllowed']);
});
