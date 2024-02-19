<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('admin.login');
    Route::post('register', [App\Http\Controllers\AuthController::class, 'register'])->name('user.register');

    Route::get('email-verify/{token}', [App\Http\Controllers\AuthController::class, 'emailVerify']);
    Route::post('resend-verify-mail', [App\Http\Controllers\AuthController::class, 'resendVerifyMail']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('user/status', [App\Http\Controllers\UserController::class, 'userStatus'])->name('bulk.user.status');
        Route::post('status/{user}/{status}', [App\Http\Controllers\UserController::class, 'singleStatusUpdate'])->name('single.status.update');
        Route::post('user/delete', [App\Http\Controllers\UserController::class, 'userDestroy'])->name('bulk.user.destroy');

        Route::resources([
            'user' => App\Http\Controllers\UserController::class,
        ]);
    });
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
