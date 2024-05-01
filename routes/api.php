<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\Api\Auth\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    //route to add user types
    Route::get('/user-types', [UserTypeController::class, 'index']);
    Route::post('/user-types', [UserTypeController::class, 'store']);
    Route::get('/user-types/{userType}', [UserTypeController::class, 'show']);
    Route::put('/user-types/{userType}', [UserTypeController::class, 'update']);
    Route::delete('/user-types/{userType}', [UserTypeController::class, 'destroy']);
    Route::put('/user-types/{userType}/restore', [UserTypeController::class, 'restore']);
    Route::delete('/user-types/{userType}/force-delete', [UserTypeController::class, 'forceDelete']);

    //route to show profile and update profile
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('update-profile', [AuthController::class, 'updateProfile']);
    
    //route to add user by admin
    Route::post('/create-user', [AuthController::class, 'register'])->middleware('admin');
});
