<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\DetectionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Api\MessageController;

// --------------------------
// Public Routes
// --------------------------

// Contact & About
Route::post('/contact', [MessageController::class, 'store']); // store message
Route::get('/about', [AboutController::class, 'show']);

// Auth: Registration & Login
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Password Reset
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
Route::post('/reset-password', [NewPasswordController::class, 'store']);

// Email Verification
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware('throttle:6,1');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// --------------------------
// Protected Routes (Authenticated via Sanctum)
// --------------------------
Route::middleware('auth:sanctum')->group(function () {

    // User Profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword']);

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // Get authenticated user info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Detection Routes
    Route::post('/detect', [DetectionController::class, 'detect']);
    Route::get('/history/store', [DetectionController::class, 'storeFromAI']);

    // --------------------------
    // Admin Routes
    // --------------------------
    Route::prefix('admin')->middleware('admin')->group(function () {

        // Users
        Route::get('/users', [AdminController::class, 'users']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);

        // Histories
        Route::get('/histories', [AdminController::class, 'histories']);
        Route::delete('/histories/{id}', [AdminController::class, 'deleteHistory']);

        // Messages (via MessageController)
        Route::get('/messages', [MessageController::class, 'index']);
        Route::delete('/messages/{id}', [MessageController::class, 'destroy']);

        // Contacts
        Route::get('/contacts', [ContactController::class, 'index']);
        Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);

        // About content
        Route::put('/about', [AboutController::class, 'update']);
    });
});
