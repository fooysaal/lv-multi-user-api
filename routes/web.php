<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/register', function () {
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Manage profile routes
Route::get('/profile', [HomeController::class, 'profile'])->name('profile')->middleware('auth');
Route::put('/profile', [HomeController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
Route::delete('/profile', [HomeController::class, 'destroyProfile'])->name('profile.destroy')->middleware('auth');

// Admin routes
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