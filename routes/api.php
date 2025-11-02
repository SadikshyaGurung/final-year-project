<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController; // <-- add this
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\DetectionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DiagnosisController;

// 📨 Public contact form route (no auth required)
Route::post('/messages', [MessageController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(function () {

    // 🧍‍♂️ Profile routes
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword']);

    // Fetch other user by username
    Route::get('/user-profile/{username}', [ProfileController::class, 'showByUsername']);

    // 🤖 Detection
    Route::post('/detect', [DetectionController::class, 'detect']);
    Route::get('/history/store', [DetectionController::class, 'storeFromAI']);

    Route::post('/diagnosis', [DiagnosisController::class, 'store']);
    Route::get('/diagnosis', [DiagnosisController::class, 'index']);
    // 📄 Download diagnosis report
    Route::post('/download-diagnosis', [DiagnosisController::class, 'downloadDiagnosis']);

    // 👨‍💼 Admin routes
    Route::prefix('admin')->middleware('is_admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'getDashboardData']);
        Route::get('/users', [AdminController::class, 'users']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
        Route::get('/histories', [AdminController::class, 'histories']);
        Route::delete('/histories/{id}', [AdminController::class, 'deleteHistory']);
        Route::get('/messages', [AdminController::class, 'messages']);
        Route::delete('/messages/{id}', [AdminController::class, 'destroyMessage']);
    });
});
