<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvailableCarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('')->name('')->group(function () {
    Route::post('login', [AuthController::class, 'login'])
        ->name('login');

    Route::middleware('auth:api')->group(function () {
        Route::prefix('auth')->name('auth.')->group(function () {
            Route::get('me', [UserController::class, 'me'])->name('me');
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        });

        Route::get('available-cars', AvailableCarController::class)
            ->name('available-cars');
    });
});
