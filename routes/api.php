<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserTypeController;
use App\Http\Controllers\Api\Auth\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    //route to add user types
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/user-types', [UserTypeController::class, 'index']);
        Route::post('/user-types', [UserTypeController::class, 'store']);
        Route::get('/user-types/{id}', [UserTypeController::class, 'show']);
        Route::put('/user-types/{id}', [UserTypeController::class, 'update']);
        Route::delete('/user-types/{id}', [UserTypeController::class, 'destroy']);
        Route::put('/user-types/{id}/restore', [UserTypeController::class, 'restore']);
        Route::delete('/user-types/{id}/force-delete', [UserTypeController::class, 'forceDelete']);    
        
        //route to add user by admin
        Route::post('/create-user', [AuthController::class, 'register']);
    });

    //route to show profile and update profile
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('update-profile', [AuthController::class, 'updateProfile']);
});
