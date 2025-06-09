<?php

use App\Livewire\FavoriteList;
use App\Livewire\UserHistory;
use App\Http\Controllers\{NotificationController,
    PdfController,
    PostController,
    ProfileController,
    UserController,
    BlogController,
    UserHistoryPdfController};
use Illuminate\Support\Facades\Route;

Route::get('/', [BlogController::class, 'index'])->name('blog');
Route::get('recipes', [PostController::class, 'recipes'])->name('posts.recipes');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->middleware('verified')->name('dashboard');

    Route::get('/myRecipes', [PostController::class, 'myPosts'])->name('posts.myPosts');
    Route::get('/sharedPosts', [PostController::class, 'sharedPosts'])->name('posts.shared');

    Route::prefix('posts')->group(function () {
        Route::get('/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/', [PostController::class, 'store'])->name('posts.store');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

        Route::get('/{post}/pdf', [PdfController::class, 'downloadPDF'])->name('posts.pdf');
    });

    Route::post('/users/{user}/follow', [UserController::class, 'follow'])->name('users.follow');
    Route::post('/users/{user}/unfollow', [UserController::class, 'unfollow'])->name('users.unfollow');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/favorites', FavoriteList::class)->name('favorites.index');

    Route::prefix('user-history')->middleware('role:admin|moderator')->group(function () {
        Route::get('/{userId}', UserHistory::class)->name('user-history');
        Route::get('/{user}/download', [UserHistoryPdfController::class, 'download'])->name('user-history.download');
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });
});

Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
