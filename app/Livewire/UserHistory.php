<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Livewire\Component;

class UserHistory extends Component
{
    public $userId;
    public $user;
    public $reports;
    public $posts;
    public $comments;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::findOrFail($userId);
        $this->reports = Report::where('reported_id', $userId)->get();
        $this->posts = Post::withTrashed()->where('user_id', $userId)->get();
        $this->comments = Comment::withTrashed()->with('post')->where('user_id', $userId)->get();
    }

    public function render()
    {
        return view('livewire.user-history')
            ->layout('layouts.app');
    }
}
