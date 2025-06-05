<?php

use App\Livewire\Moderator\ModeratorComments;
use App\Livewire\Moderator\ModeratorDashboard;
use App\Livewire\Moderator\ModeratorPosts;
use App\Livewire\Moderator\ModeratorReports;
use App\Livewire\Moderator\ModeratorUsers;

Route::prefix('moderator')->middleware(['auth', 'role:moderator'])->group(function () {
    Route::get('/dashboard', ModeratorDashboard::class)->name('moderator.dashboard');
    Route::get('/users', ModeratorUsers::class)->name('moderator.users');
    Route::get('/posts', ModeratorPosts::class)->name('moderator.posts');
    Route::get('/comments', ModeratorComments::class)->name('moderator.comments');
    Route::get('/reports', ModeratorReports::class)->name('moderator.reports');
});
