<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminUsers extends Component
{
    use WithPagination;

    public $roles = [];

    public function updatingPage()
    {
        $this->roles = [];
    }

    public function updateRole($userId)
    {
        $this->validate([
            "roles.$userId" => 'required|in:user,admin,moderator',
        ]);

        $user = User::findOrFail($userId);
        $newRole = $this->roles[$userId];

        $user->syncRoles($newRole);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "El usuario {$user->name} ahora tiene el rol de {$newRole}.",
        ]);
    }

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
        $users = User::withTrashed()->VisibleProfiles()->paginate(10);

        foreach ($users as $user) {
            if (!isset($this->roles[$user->id])) {
                $this->roles[$user->id] = $user->getRoleNames()->first() ?? 'user';
            }
        }

        return view('livewire.admin.admin-users', [
            'users' => $users,
        ])->layout('layouts.app');
    }
}
