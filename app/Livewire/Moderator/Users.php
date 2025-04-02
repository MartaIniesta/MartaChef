<?php

namespace App\Livewire\Moderator;

use Livewire\Component;
use App\Models\User;

class Users extends Component
{
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
        return view('livewire.moderator.users', [
            'users' => User::withTrashed()->VisibleProfiles()->get(),
        ]);
    }
}
