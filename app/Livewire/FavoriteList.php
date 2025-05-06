<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteList extends Component
{
    public $favorites;
    public $note;
    public $favoriteId;
    public $isEditing = false;
    public $isCreating = false;

    public function mount()
    {
        $this->loadFavorites();
    }

    public function loadFavorites()
    {
        $this->favorites = Favorite::where('user_id', Auth::id())->get();
    }

    public function startCreating($favoriteId)
    {
        $this->favoriteId = $favoriteId;
        $this->note = '';
        $this->isCreating = true;
        $this->isEditing = false;
    }

    public function createNote()
    {
        if (empty($this->note)) {
            session()->flash('error', 'La nota no puede estar vacía.');
            return;
        }

        $favorite = Favorite::find($this->favoriteId);

        if ($favorite && $favorite->user_id == Auth::id()) {
            $favorite->note = $this->note;
            $favorite->save();

            $this->loadFavorites();
            $this->isCreating = false;
            $this->resetFields();
        }
    }

    public function editNote($favoriteId)
    {
        $favorite = Favorite::find($favoriteId);

        if ($favorite && $favorite->user_id == Auth::id()) {
            $this->favoriteId = $favorite->id;
            $this->note = $favorite->note ?? '';
            $this->isEditing = true;
            $this->isCreating = false;
        }
    }

    public function updateNote()
    {
        $favorite = Favorite::find($this->favoriteId);

        if ($favorite && $favorite->user_id == Auth::id()) {
            $favorite->note = $this->note;
            $favorite->save();

            $this->loadFavorites();
            $this->isEditing = false;
            $this->favoriteId = null;
            $this->resetFields();
        }
    }

    public function deleteNote($favoriteId)
    {
        $favorite = Favorite::find($favoriteId);

        if ($favorite && $favorite->user_id == Auth::id()) {
            $favorite->note = null;
            $favorite->save();

            $this->loadFavorites();
        }
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->isCreating = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->note = '';
        $this->favoriteId = null;
    }

    public function render()
    {
        return view('livewire.favorite-list')
            ->layout('layouts.app');
    }
}
