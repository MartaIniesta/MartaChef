<?php

use App\Http\Controllers\Admin\AdminController;
use App\Livewire\Admin\AdminComments;
use App\Livewire\Admin\AdminPosts;
use App\Livewire\Admin\AdminUsers;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/users', AdminUsers::class)->name('admin.users');
    Route::get('/admin/posts', AdminPosts::class)->name('admin.posts');
    Route::get('/admin/comments', AdminComments::class)->name('admin.comments');
});
