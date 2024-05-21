<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;

Route::get('/account-not-active', function () {
    return view('account-not-active');
})->name('account-not-active');

Auth::routes(['verify' => false]);

Route::get('/register', function () {
    return redirect()->route('login');
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth', 'verified', 'active');

Route::get('/verify-email', [VerificationController::class, 'show'])->name('verification.notice')->middleware('auth');
Route::post('/verify-email', [VerificationController::class, 'verify'])->name('verification.verify')->middleware('auth');
Route::post('/resend-otp', [VerificationController::class, 'resend'])->name('verification.resend')->middleware('auth');

// Manage profile routes
Route::middleware('auth', 'verified', 'active')->group(function() {
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::put('/profile', [HomeController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [HomeController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [AccountController::class, 'destroyProfile'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['admin', 'active'])->group(function () {
    Route::get('/register-user', [RegisterController::class, 'index'])->name('register-user');
    Route::post('/register-user', [RegisterController::class, 'register'])->name('register-user.store');
    Route::put('/update/user-type/{id}', [AccountController::class, 'UpdateUserType'])->name('user-type.update');

    Route::put('users/{id}/restore', [AccountController::class, 'restoreUsers'])->name('users.restore');
    Route::delete('users/{id}/delete', [AccountController::class, 'forceDeleteUser'])->name('users.forceDelete');

    Route::get('/user-types', [UserTypeController::class, 'index'])->name('user-types');
    Route::get('/user-types/create', [UserTypeController::class, 'create'])->name('user-types.create');
    Route::post('/user-types', [UserTypeController::class, 'store'])->name('user-types.store');
    Route::get('/user-types/{id}/edit', [UserTypeController::class, 'edit'])->name('user-types.edit');
    Route::put('/user-types/{id}', [UserTypeController::class, 'update'])->name('user-types.update');
    Route::delete('/user-types/{id}', [UserTypeController::class, 'destroy'])->name('user-types.destroy');
    Route::get('/user-types/trashed', [UserTypeController::class, 'trashed'])->name('user-types.trashed');
    Route::put('/user-types/{id}/restore', [UserTypeController::class, 'restore'])->name('user-types.restore');
    Route::delete('/user-types/{id}/delete', [UserTypeController::class, 'forceDelete'])->name('user-types.forceDelete');
});