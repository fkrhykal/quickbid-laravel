<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/sign-up', [AuthController::class, 'showSignUp'])->name('sign-up');
    Route::post('/sign-up', [AuthController::class, 'processSignUp']);

    Route::get('/sign-in', [AuthController::class, 'showSignIn'])->name('login');
    Route::post('/sign-in', [AuthController::class, 'processSignIn']);
});

Route::middleware('auth')->group(function () {
    Route::post('/sign-out', [AuthController::class, 'processSignOut']);
    Route::get('/place-auction', [AuctionController::class, 'showPlaceAuction']);
});
