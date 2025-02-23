<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class BlogController extends Controller
{
    public function index()
    {
        $latestPosts = Post::visibilityPublic()
            ->latest('created_at')
            ->take(3)
            ->get();

        $categoriesToShow = ['Tartas', 'Bizcochos', 'Galletas'];
        $categories = Category::whereIn('name', $categoriesToShow)->get();
        $categoryPosts = $categories->mapWithKeys(function($category) {
            $post = $category->posts()
                ->visibilityPublic()
                ->withAvg('ratings', 'rating')
                ->orderByDesc('ratings_avg_rating')
                ->first();

            return [$category->name => $post];
        });

        $topUsers = User::withCount('followers')
            ->orderByDesc('followers_count')
            ->take(3)
            ->get();

        return view('blog', compact('latestPosts', 'categoryPosts', 'topUsers'));
    }
}
