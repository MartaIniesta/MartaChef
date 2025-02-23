<?php

use App\Http\Controllers\{PdfController, PostController, ProfileController, UserController, BlogController};
use Illuminate\Support\Facades\Route;

require __DIR__.'/admin.php';
require __DIR__.'/moderator.php';

Route::get('/', [BlogController::class, 'index'])->name('blog');
Route::get('recipes', [PostController::class, 'recipes'])->name('posts.recipes');

// Ruta para ver la lista de usuarios (no necesita autenticación)
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/sharedPosts', [PostController::class, 'sharedPosts'])->name('posts.shared');
    Route::get('/myRecipes', [PostController::class, 'myPosts'])->name('posts.myPosts');

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

    // Usuarios
    Route::post('/users/{user}/follow', [UserController::class, 'follow'])->name('users.follow');
    Route::post('/users/{user}/unfollow', [UserController::class, 'unfollow'])->name('users.unfollow');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/posts/{post}/pdf', [PdfController::class, 'generatePDF'])->name('posts.pdf');
});

Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

require __DIR__.'/auth.php';
