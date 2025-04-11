<?php

use App\Http\Controllers\Moderator\CommentController;
use App\Http\Controllers\Moderator\ModeratorController;
use App\Http\Controllers\Moderator\PostController;
use App\Http\Controllers\Moderator\UserController;
use App\Http\Controllers\Moderator\UserHistoryController;
use App\Livewire\Moderator\Reports;

Route::middleware(['auth', 'role:moderator'])->group(function () {
    Route::get('/moderator/dashboard', [ModeratorController::class, 'index'])->name('moderator.dashboard');

    Route::get('/moderator/users', [UserController::class, 'index'])->name('moderator.users');
    Route::get('/moderator/posts', [PostController::class, 'index'])->name('moderator.posts');
    Route::get('/moderator/comments', [CommentController::class, 'index'])->name('moderator.comments');
    Route::get('/moderator/reports', Reports::class)->name('moderator.reports');
    Route::get('/moderator/user-history/{userId}', [UserHistoryController::class, 'show'])->name('moderator.user-history');
});
