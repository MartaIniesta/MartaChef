<?php

use App\Livewire\Moderator\ModeratorComments;
use App\Livewire\Moderator\ModeratorDashboard;
use App\Livewire\Moderator\ModeratorPosts;
use App\Livewire\Moderator\ModeratorReports;
use App\Livewire\Moderator\ModeratorUsers;

Route::middleware(['auth', 'role:moderator'])->group(function () {
    Route::get('/moderator/dashboard', ModeratorDashboard::class)->name('moderator.dashboard');
    Route::get('/moderator/users', ModeratorUsers::class)->name('moderator.users');
    Route::get('/moderator/posts', ModeratorPosts::class)->name('moderator.posts');
    Route::get('/moderator/comments', ModeratorComments::class)->name('moderator.comments');
    Route::get('/moderator/reports', ModeratorReports::class)->name('moderator.reports');
});
