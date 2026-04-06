<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobOfferController;
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
        Route::delete('/{job}', [JobController::class, 'destroy'])->name('job.destroy');
    });

    Route::prefix('company')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('company.index');
        Route::post('/', [CompanyController::class, 'store'])->name('company.store');
        Route::get('/{company}/employees', [CompanyController::class, 'employees'])->name('company.employees');
    });

    Route::prefix('job-offer')->group(function () {
        Route::get('/', [JobOfferController::class, 'index'])->name('job_offer.index');
        Route::get('/{jobOffer}', [JobOfferController::class, 'show'])->name('job_offer.show');
        Route::post('/', [JobOfferController::class, 'store'])->name('job_offer.store');
    });
});



Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
