<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FavoriteList extends Component
{
    public $favorites;
    public $note;
    public $creatingNoteForPostId = null;
    public $editingNoteForPostId = null;

    public function mount()
    {
        $this->loadFavorites();
    }

    public function loadFavorites()
    {
        $this->favorites = Auth::user()->favoritePosts()->with(['user'])->withPivot('note')->get();
    }

    public function startCreating($postId)
    {
        $this->creatingNoteForPostId = $postId;
        $this->editingNoteForPostId = null;
        $this->note = '';
    }

    public function createNote()
    {
        $this->validate([
            'note' => 'required|string|min:5|max:255',
        ]);

        Auth::user()->favoritePosts()->updateExistingPivot($this->creatingNoteForPostId, [
            'note' => $this->note
        ]);

        $this->resetInteraction();
    }

    public function editNote($postId)
    {
        $favorite = Auth::user()->favoritePosts()->where('post_id', $postId)->first();

        if ($favorite) {
            $this->editingNoteForPostId = $postId;
            $this->creatingNoteForPostId = null;
            $this->note = $favorite->pivot->note ?? '';
        }
    }

    public function updateNote()
    {
        $this->validate([
            'note' => 'required|string|min:5|max:255',
        ]);

        Auth::user()->favoritePosts()->updateExistingPivot($this->editingNoteForPostId, [
            'note' => $this->note
        ]);

        $this->resetInteraction();
    }

    public function deleteNote($postId)
    {
        Auth::user()->favoritePosts()->updateExistingPivot($postId, ['note' => null]);
        $this->loadFavorites();
    }

    public function cancelEdit()
    {
        $this->resetInteraction();
    }

    private function resetInteraction()
    {
        $this->note = '';
        $this->creatingNoteForPostId = null;
        $this->editingNoteForPostId = null;
        $this->loadFavorites();
    }

    public function render()
    {
        return view('livewire.favorite-list')
            ->layout('layouts.app');
    }
}
