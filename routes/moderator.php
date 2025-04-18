<?php

use App\Http\Controllers\Moderator\ModeratorController;
use App\Livewire\Moderator\Comments;
use App\Livewire\Moderator\Posts;
use App\Livewire\Moderator\Reports;
use App\Livewire\Moderator\UserHistory;
use App\Livewire\Moderator\Users;

Route::middleware(['auth', 'role:moderator'])->group(function () {
    Route::get('/moderator/dashboard', [ModeratorController::class, 'index'])->name('moderator.dashboard');

    Route::get('/moderator/users', Users::class)->name('moderator.users');
    Route::get('/moderator/posts', Posts::class)->name('moderator.posts');
    Route::get('/moderator/comments', Comments::class)->name('moderator.comments');
    Route::get('/moderator/reports', Reports::class)->name('moderator.reports');
    Route::get('/moderator/user-history/{userId}', UserHistory::class)->name('moderator.user-history');
    Route::get('/moderator/user-history/{user}/pdf', [ModeratorController::class, 'downloadUserHistoryPdf'])->name('moderator.user-history.pdf');
});
