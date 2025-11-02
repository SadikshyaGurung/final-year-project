<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;

/*
|--------------------------------------------------------------------------
| Web Routes (Sanctum SPA)
|--------------------------------------------------------------------------
| Session-based authentication routes for SPA frontend
*/

Route::middleware('web')->group(function () {

    // CSRF + login/logout/register
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // Password reset
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'sendResetLink']);
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);

    // Email verification
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1');
    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
});

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';
