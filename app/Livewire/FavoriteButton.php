<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteButton extends Component
{
    public $postId;
    public $isFavorite;

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->isFavorite = Favorite::where('user_id', Auth::id())
            ->where('post_id', $this->postId)->exists();
    }

    public function toggleFavorite()
    {
        if ($this->isFavorite) {
            Favorite::where('user_id', Auth::id())
                ->where('post_id', $this->postId)
                ->delete();
            $this->isFavorite = false;
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'post_id' => $this->postId
            ]);
            $this->isFavorite = true;
        }
    }

    public function render()
    {
        return view('livewire.favorite-button');
    }
}
