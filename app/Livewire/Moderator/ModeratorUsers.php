<?php

namespace App\Livewire\Moderator;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class ModeratorUsers extends Component
{
    use WithPagination;

    public function softDeleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->posts()->delete();
        $user->delete();
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        $user->posts()->withTrashed()->restore();
    }

    public function forceDeleteUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->posts()->withTrashed()->forceDelete();
        $user->forceDelete();
    }

    public function render()
    {
        return view('livewire.moderator.moderator-users', [
            'users' => User::withTrashed()->VisibleProfiles()->paginate(10),
        ])->layout('layouts.app');
    }
}
