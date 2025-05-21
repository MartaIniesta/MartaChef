<?php

use App\Livewire\Admin\AdminComments;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\AdminPosts;
use App\Livewire\Admin\AdminReports;
use App\Livewire\Admin\AdminUsers;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/admin/users', AdminUsers::class)->name('admin.users');
    Route::get('/admin/posts', AdminPosts::class)->name('admin.posts');
    Route::get('/admin/comments', AdminComments::class)->name('admin.comments');
    Route::get('/admin/reports', AdminReports::class)->name('admin.reports');
});
