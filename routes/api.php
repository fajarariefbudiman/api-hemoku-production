<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
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

Route::prefix('auth')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest')
        ->name('auth.register');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest')
        ->name('auth.login');

    Route::post('/forgot-password/send-otp', [AuthenticatedSessionController::class, 'sendOtp']);
    Route::post('/forgot-password/verify-otp', [AuthenticatedSessionController::class, 'verifyOtp']);
    Route::post('/forgot-password/reset', [AuthenticatedSessionController::class, 'resetPassword']);
    Route::middleware('auth:sanctum')->post('/change-password', [AuthenticatedSessionController::class, 'changePassword']);
    Route::middleware('auth:sanctum')->delete('/delete-account', [AuthenticatedSessionController::class, 'deleteAccount']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:sanctum')
        ->name('auth.logout');



    // Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    //     ->middleware('guest')
    //     ->name('auth.password.email');

    // Route::post('/reset-password', [NewPasswordController::class, 'store'])
    //     ->middleware('guest')
    //     ->name('auth.password.store');

    // Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    //     ->middleware(['auth', 'signed', 'throttle:6,1'])
    //     ->name('auth.verification.verify');

    // Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //     ->middleware(['auth', 'throttle:6,1'])
    //     ->name('auth.verification.send');

});

Route::middleware('auth:sanctum')->get('/fact-myths', [FactMythController::class, 'index']);
Route::middleware('auth:sanctum')->get('/fact-myths/{id}', [FactMythController::class, 'show']);
Route::middleware('auth:sanctum')->prefix('feed')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    Route::post('/posts/{id}/likes', [PostLikeController::class, 'store']);
    Route::delete('/posts/{id}/likes', [PostLikeController::class, 'destroy']);

    Route::get('/posts/{id}/comments', [CommentController::class, 'index']);
    Route::post('/posts/{id}/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/screening-questions', [ScreeningController::class, 'questions']);
    Route::post('/screening-answers', [ScreeningController::class, 'submitAnswers']);
    Route::get('/screening-sessions/{id}', [ScreeningController::class, 'show']);

    Route::get('/reminders', [ReminderController::class, 'index']);
    Route::post('/reminders', [ReminderController::class, 'store']);

    Route::get('/reminder-logs', [ReminderLogController::class, 'index']);
    Route::post('/reminder-logs', [ReminderLogController::class, 'store']);
});

Route::middleware('auth:sanctum')->get('/educational-contents', [EducationalContentController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user/profile', [UserProfileController::class, 'show']);
