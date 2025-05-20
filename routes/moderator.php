<?php

use App\Http\Controllers\Moderator\ModeratorController;
use App\Livewire\Moderator\ModeratorComments;
use App\Livewire\Moderator\ModeratorPosts;
use App\Livewire\Moderator\ModeratorReports;
use App\Livewire\Moderator\UserHistory;
use App\Livewire\Moderator\ModeratorUsers;

Route::middleware(['auth', 'role:moderator'])->group(function () {
    Route::get('/moderator/dashboard', [ModeratorController::class, 'index'])->name('moderator.dashboard');

    Route::get('/moderator/users', ModeratorUsers::class)->name('moderator.users');
    Route::get('/moderator/posts', ModeratorPosts::class)->name('moderator.posts');
    Route::get('/moderator/comments', ModeratorComments::class)->name('moderator.comments');
    Route::get('/moderator/reports', ModeratorReports::class)->name('moderator.reports');
    Route::get('/moderator/user-history/{userId}', UserHistory::class)->name('moderator.user-history');
    Route::get('/moderator/user-history/{user}/pdf', [ModeratorController::class, 'downloadUserHistoryPdf'])->name('moderator.user-history.pdf');
});
