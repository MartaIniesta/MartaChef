<?php

namespace App\Livewire\Moderator;

use Livewire\Component;
use App\Models\Report;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

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
        $this->posts = Post::where('user_id', $userId)->get();
        $this->comments = Comment::with('post')->where('user_id', $userId)->get();
    }

    public function render()
    {
        return view('livewire.moderator.user-history')
            ->layout('layouts.app');
    }
}
