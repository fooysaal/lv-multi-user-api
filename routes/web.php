<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/register', function () {
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/profile', [HomeController::class, 'profile'])->name('profile')->middleware('auth');
Route::put('/profile', [HomeController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
Route::delete('/profile', [HomeController::class, 'destroyProfile'])->name('profile.destroy')->middleware('auth');

// Route::group(['middleware' => 'admin'], function () {
//     Route::get('/register-user', [RegisterController::class, 'index'])->name('register-user');
//     Route::post('/register-user', [RegisterController::class, 'register'])->name('register-user.store');

//     Route::get('/user-types', [UserTypeController::class, 'index'])->name('user-types');
//     Route::get('/user-types/create', [UserTypeController::class, 'create'])->name('user-types.create');
//     Route::post('/user-types', [UserTypeController::class, 'store'])->name('user-types.store');
//     Route::get('/user-types/{id}/edit', [UserTypeController::class, 'edit'])->name('user-types.edit');
//     Route::put('/user-types/{id}', [UserTypeController::class, 'update'])->name('user-types.update');
//     Route::delete('/user-types/{id}', [UserTypeController::class, 'destroy'])->name('user-types.destroy');
// });

// create route group with middleware of admin
Route::middleware(['admin'])->group(function () {
    Route::get('/register-user', [RegisterController::class, 'index'])->name('register-user');
    Route::post('/register-user', [RegisterController::class, 'register'])->name('register-user.store');

    Route::get('/user-types', [UserTypeController::class, 'index'])->name('user-types');
    Route::get('/user-types/create', [UserTypeController::class, 'create'])->name('user-types.create');
    Route::post('/user-types', [UserTypeController::class, 'store'])->name('user-types.store');
    Route::get('/user-types/{id}/edit', [UserTypeController::class, 'edit'])->name('user-types.edit');
    Route::put('/user-types/{id}', [UserTypeController::class, 'update'])->name('user-types.update');
    Route::delete('/user-types/{id}', [UserTypeController::class, 'destroy'])->name('user-types.destroy');
});