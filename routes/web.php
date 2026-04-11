<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ApplicationController;
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
        Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.update_profile');
        Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('job')->group(function () {
        Route::post('/create', [JobController::class, 'create'])->name('job.create');
        Route::get('/list', [JobController::class, 'index'])->name('job.list');
        Route::put('/{job}', [JobController::class, 'update'])->name('job.update');
        Route::delete('/{job}', [JobController::class, 'destroy'])->name('job.destroy');
    });

    Route::prefix('company')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('company.index');
        Route::get('/can_create_job_offers/{company}', [CompanyController::class, 'canCreateJobOffers'])->name('company.can_create_job_offers');
        Route::post('/', [CompanyController::class, 'store'])->name('company.store');
        Route::put('/{company}', [CompanyController::class, 'update'])->name('company.update');
        Route::delete('/{company}', [CompanyController::class, 'destroy'])->name('company.destroy');
        Route::get('/{company}/employees', [CompanyController::class, 'employees'])->name('company.employees');
        Route::post('/{company}/employees', [CompanyController::class, 'addEmployee'])->name('company.employees.add');
        Route::post('/{company}/employees/register', [CompanyController::class, 'registerEmployee'])->name('company.employees.register');
        Route::put('/{company}/employees/{employee}', [CompanyController::class, 'updateEmployee'])->name('company.employees.update');
        Route::delete('/{company}/employees/{employee}', [CompanyController::class, 'removeEmployee'])->name('company.employees.remove');
    });

    Route::get('/application', [ApplicationController::class, 'index'])->name('application.index');
    Route::post('/application', [ApplicationController::class, 'store'])->name('application.store');
    Route::delete('/application/{application}', [ApplicationController::class, 'destroy'])->name('application.destroy');
    Route::get('/job-offer/{jobOffer}/applications', [ApplicationController::class, 'forJobOffer'])->name('application.for_job_offer');
    Route::patch('/application/{application}/status', [ApplicationController::class, 'updateStatus'])->name('application.update_status');

    Route::prefix('job-offer')->group(function () {
        Route::get('/', [JobOfferController::class, 'index'])->name('job_offer.index');
        Route::get('/{jobOffer}', [JobOfferController::class, 'show'])->name('job_offer.show');
        Route::post('/', [JobOfferController::class, 'store'])->name('job_offer.store');
        Route::put('/{jobOffer}', [JobOfferController::class, 'update'])->name('job_offer.update');
        Route::delete('/{jobOffer}', [JobOfferController::class, 'destroy'])->name('job_offer.destroy');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    });
});



Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
