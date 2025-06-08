<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FavoriteButton extends Component
{
    public $postId;
    public $isFavorite;

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->isFavorite = Auth::user()
            ->favoritePosts()
            ->where('post_id', $this->postId)
            ->exists();
    }

    public function toggleFavorite()
    {
        $user = Auth::user();

        if ($this->isFavorite) {
            $user->favoritePosts()->detach($this->postId);
            $this->isFavorite = false;
        } else {
            $user->favoritePosts()->attach($this->postId);
            $this->isFavorite = true;
        }
    }

    public function render()
    {
        return view('livewire.favorite-button');
    }
}
