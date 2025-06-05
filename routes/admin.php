<?php

use App\Livewire\Admin\AdminComments;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\AdminPosts;
use App\Livewire\Admin\AdminReports;
use App\Livewire\Admin\AdminUsers;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/users', AdminUsers::class)->name('admin.users');
    Route::get('/posts', AdminPosts::class)->name('admin.posts');
    Route::get('/comments', AdminComments::class)->name('admin.comments');
    Route::get('/reports', AdminReports::class)->name('admin.reports');
});
