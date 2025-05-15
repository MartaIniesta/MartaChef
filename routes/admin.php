<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Livewire\Admin\PostManage;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Rutas para administrar usuarios
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::put('/admin/users/{user}/update-role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::delete('/admin/users/{user}', [UserController::class, 'softDeleteUser'])->name('admin.users.softDelete');
    Route::post('/admin/users/{id}/restore', [UserController::class, 'restoreUser'])->name('admin.users.restore');
    Route::delete('/admin/users/{id}/force-delete', [UserController::class, 'forceDeleteUser'])->name('admin.users.forceDelete');

    // Rutas para administrar posts
    Route::get('/admin/posts', PostManage::class)->name('admin.posts');
});
