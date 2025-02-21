<?php

use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/posts', [AdminController::class, 'posts'])->name('admin.posts');

    // Rutas para administrar usuarios
    Route::delete('/admin/users/{user}', [AdminController::class, 'softDeleteUser'])->name('admin.users.softDelete');
    Route::post('/admin/users/{id}/restore', [AdminController::class, 'restoreUser'])->name('admin.users.restore');
    Route::delete('/admin/users/{id}/force-delete', [AdminController::class, 'forceDeleteUser'])->name('admin.users.forceDelete');

    Route::delete('/admin/posts/{id}', [AdminController::class, 'softDeletePost'])->name('admin.posts.softDelete');
    Route::patch('/admin/posts/{id}/restore', [AdminController::class, 'restorePost'])->name('admin.posts.restore');
    Route::delete('/admin/posts/{id}/forceDelete', [AdminController::class, 'forceDeletePost'])->name('admin.posts.forceDelete');
});
