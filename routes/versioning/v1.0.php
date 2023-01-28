<?php

use App\Http\Controllers\AuthCheckerController;
use App\Http\Controllers\FoodTypeController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RecipeController;
use App\Http\Middleware\AuthApi;
use Illuminate\Support\Facades\Route;

Route::get('/apiCheck', [AuthCheckerController::class, 'isAlive']);

/** Api consumers authorized routes */
Route::group([
    'middleware' => AuthApi::class,
], function () {
    Route::get('/authCheck', [AuthCheckerController::class, 'isAllowed'])->name('GET/authCheck');

    Route::get('/recipe', [RecipeController::class, 'index'])->name('GET/recipe');
    Route::get('/recipe/{id}', [RecipeController::class, 'show'])->name('GET/recipe/{id}');
    Route::put('/recipe/{id}', [RecipeController::class, 'update'])->name('PUT/recipe/{id}');
    Route::post('/recipe', [RecipeController::class, 'store'])->name('POST/recipe');

    /** Only Admins routes TODO: make admin middleware */
    Route::get('/rating', [RatingController::class, 'index'])->name('GET/rating');
    Route::post('/rating', [RatingController::class, 'store'])->name('POST/rating');

    Route::get('/foodType', [FoodTypeController::class, 'index'])->name('GET/foodType');
    Route::post('/foodType', [FoodTypeController::class, 'store'])->name('POST/foodType');
});
