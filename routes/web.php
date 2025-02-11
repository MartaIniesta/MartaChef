<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('blog', [PostController::class, 'index'])->name('posts.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/sharedPosts', [PostController::class, 'sharedPosts'])->name('posts.shared');
    Route::get('/myPosts', [PostController::class, 'myPosts'])->name('posts.myPosts');

    Route::middleware(['can:create-posts'])->group(function () {
        Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    });

    Route::middleware(['can:edit-posts'])->group(function () {
        Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    });

    Route::middleware(['can:delete-posts'])->group(function () {
        Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::middleware(['can:delete-comments'])->group(function () {
        Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Rutas solo para administradores
/*Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});*/

require __DIR__.'/auth.php';
