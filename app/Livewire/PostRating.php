<?php

namespace App\Livewire;

use App\Models\{Post, Rating};
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class PostRating extends Component
{
    use AuthorizesRequests;

    public Post $post;
    public ?int $userRating = null;
    public float $averageRating = 0;

    public function mount(Post $post)
    {
        $this->post = $post;

        if (Auth::check()) {
            $rating = Rating::where('post_id', $post->id)
                ->where('user_id', Auth::id())
                ->first();
            if ($rating) {
                $this->userRating = $rating->rating;
            }
        }
        $this->calculateAverage();
    }

    public function rate(int $rating)
    {
        $this->authorize('rate', $this->post);

        if ($rating < 1 || $rating > 5) {
            return;
        }

        Rating::updateOrCreate(
            [
                'post_id' => $this->post->id,
                'user_id' => Auth::id(),
            ],
            [
                'rating' => $rating,
            ]
        );

        $this->userRating = $rating;
        $this->calculateAverage();
    }

    protected function calculateAverage()
    {
        $this->averageRating = (float) Rating::where('post_id', $this->post->id)->avg('rating');
    }

    public function render()
    {
        return view('livewire.post-rating');
    }
}
