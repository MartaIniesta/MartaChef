<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register'])->name('api.register');
Route::post('login', [AuthController::class, 'login'])->name('api.login');

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('api.posts.index');
    Route::get('/{post}', [PostController::class, 'show'])->name('api.posts.show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [PostController::class, 'store'])->name('api.posts.store');
        Route::put('/{post}', [PostController::class, 'update'])->name('api.posts.update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('api.posts.destroy');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/myPosts', [PostController::class, 'myPosts'])->name('api.myPosts');
    Route::get('/sharedPosts', [PostController::class, 'sharedPosts'])->name('api.sharedPosts');
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('api.users.index');
    Route::get('{user}', [UserController::class, 'show'])->name('api.users.show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('{user}/follow', [UserController::class, 'follow'])->name('api.users.follow');
        Route::post('{user}/unfollow', [UserController::class, 'unfollow'])->name('api.users.unfollow');
    });
});

Route::prefix('ratings')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [RatingController::class, 'index'])->name('api.ratings.index');
        Route::get('/post/{post_id}', [RatingController::class, 'show'])->name('api.ratings.show');
        Route::post('/', [RatingController::class, 'store'])->name('api.ratings.store');
        Route::put('/post/{post_id}', [RatingController::class, 'update'])->name('api.ratings.update');
        Route::delete('/post/{post_id}', [RatingController::class, 'destroy'])->name('api.ratings.destroy');
    });
});
