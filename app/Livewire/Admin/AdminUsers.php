<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminUsers extends Component
{
    use WithPagination;

    public $roles = [];

    // Cada vez que se monta el componente, inicializamos los roles con los actuales de los usuarios de la primera página
    public function mount()
    {
        $users = User::withTrashed()->VisibleProfiles()->paginate(10);
        foreach ($users as $user) {
            $this->roles[$user->id] = $user->getRoleNames()->first() ?? 'user';
        }
    }

    // Método que se dispara al cambiar página para refrescar los roles actuales en la nueva página
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
        $user->syncRoles($this->roles[$userId]);

        session()->flash('status', "Rol actualizado para usuario ID {$userId}");
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

        // Si hay usuarios nuevos en la página que no están en $roles, los añadimos
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
