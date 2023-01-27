<?php

use App\Http\Controllers\AuthCheckerController;
use App\Http\Middleware\AuthApi;
use Illuminate\Support\Facades\Route;

Route::get('/apiCheck', [AuthCheckerController::class, 'isAlive']);

/** Api consumers authorized routes */
Route::group([
    'middleware' => AuthApi::class,
], function () {
    Route::get('/authCheck', [AuthCheckerController::class, 'isAllowed'])->name('GET/authCheck');

    /** Only Admins routes TODO: make admin middleware */
    Route::get('/foodType', [AuthCheckerController::class, 'index'])->name('GET/foodType');
    Route::get('/rating', [AuthCheckerController::class, 'index'])->name('GET/rating');
    Route::post('/foodType', [AuthCheckerController::class, 'store'])->name('POST/foodType');
    Route::post('/rating', [AuthCheckerController::class, 'store'])->name('POST/rating');
});
