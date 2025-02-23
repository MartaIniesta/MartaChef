<?php

use App\Http\Controllers\Moderator\ModeratorController;
use App\Http\Controllers\Moderator\PostController;

Route::middleware(['auth', 'role:moderator'])->group(function () {
    Route::get('/moderator/dashboard', [ModeratorController::class, 'index'])->name('moderator.dashboard');

    Route::get('/moderator/posts', [PostController::class, 'index'])->name('moderator.posts');
    Route::delete('/moderator/posts/{id}', [PostController::class, 'softDeletePost'])->name('moderator.posts.softDelete');
    Route::patch('/moderator/posts/{id}/restore', [PostController::class, 'restorePost'])->name('moderator.posts.restore');
    Route::delete('/moderator/posts/{id}/forceDelete', [PostController::class, 'forceDeletePost'])->name('moderator.posts.forceDelete');
});
