<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EducationalContentController;
use App\Http\Controllers\FactMythController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ReminderLogController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

// Yang before auth
// ==================== Auth ====================
Route::prefix('auth')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store']); //

    Route::post('/login', [AuthenticatedSessionController::class, 'store']) //
        ->middleware('guest')
        ->name('auth.login');

    Route::post('/forgot-password/send-otp', [PasswordResetLinkController::class, 'sendOtp']); //
    Route::post('/forgot-password/verify-otp', [PasswordResetLinkController::class, 'verifyOtp']); //
    Route::post('/forgot-password/reset', [NewPasswordController::class, 'resetPassword']); //

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/change-password', [NewPasswordController::class, 'changePassword']); //
        Route::delete('/delete-account', [AuthenticatedSessionController::class, 'deleteAccount']);
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('auth.logout');
    });
});

// ==================== Fact Myths ====================
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/fact-myths', [FactMythController::class, 'index']);
    Route::get('/fact-myths/{id}', [FactMythController::class, 'show']);
});

// ==================== Feed ====================
Route::middleware('auth:sanctum')->prefix('feed')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']); //
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);

    Route::post('/posts/{id}/likes', [PostLikeController::class, 'store']);//
    Route::delete('/posts/{id}/likes', [PostLikeController::class, 'destroy']);//

    Route::get('/posts/{id}/comments', [CommentController::class, 'index']);
    Route::post('/posts/{id}/comments', [CommentController::class, 'store']);//
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
});

// ==================== Screening ====================
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/screening-questions', [ScreeningController::class, 'questions']);//
    Route::post('/screening-answers', [ScreeningController::class, 'submitAnswers']);
    Route::get('/screening-sessions', [ScreeningController::class, 'index']);
    Route::get('/screening-sessions/{id}', [ScreeningController::class, 'show']);

    // ==================== Reminders ====================
    Route::get('/reminders', [ReminderController::class, 'index']);
    Route::post('/reminders', [ReminderController::class, 'store']);

    Route::get('/reminder-logs', [ReminderLogController::class, 'index']);
    Route::post('/reminder-logs', [ReminderLogController::class, 'store']);

    // ==================== Educational Contents ====================
    Route::get('/educational-contents', [EducationalContentController::class, 'index']);

    // ==================== User Profile ====================
    Route::get('/user/profile', [UserProfileController::class, 'show']);
});
