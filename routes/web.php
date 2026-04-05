<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('user')->group(function () {
    Route::middleware(['web', 'guest:sanctum'])->group(function () {
        Route::post('/register', [UserController::class, 'register'])->name('user.register');
        Route::post('/login', [UserController::class, 'login'])->name('user.login');
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/get-logged-in-user', [UserController::class, 'getLoggedInUser'])->name('user.get_logged_in_user');
        Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('job')->group(function () {
        Route::post('/create', [JobController::class, 'create'])->name('job.create');
        Route::get('/list', [JobController::class, 'index'])->name('job.list');
    });
});



Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
