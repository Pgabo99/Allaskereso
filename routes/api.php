<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
   Route::prefix('user')->group(function () {
       Route::post('/register', [UserController::class, 'register'])->name('user.register');
   });
});
