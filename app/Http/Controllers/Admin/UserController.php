<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        return $this->middleware('role:admin');
    }

    public function index()
    {
        $users = User::withTrashed()->where('id', '!=', auth()->id())->get();
        return view('admin.admin-users-index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin,moderator',
        ]);

        $user->syncRoles($request->role);

        return redirect()->back()->with('status', 'Rol actualizado correctamente.');
    }

    public function softDeleteUser($id)
    {
        $user = User::findOrFail($id);

        $user->posts()->delete();
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Usuario y sus posts han sido eliminados temporalmente.');
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->restore();
        $user->posts()->withTrashed()->restore();

        return redirect()->route('admin.users')->with('success', 'Usuario y sus posts han sido restaurados.');
    }

    public function forceDeleteUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->posts()->withTrashed()->forceDelete();
        $user->forceDelete();

        return redirect()->route('admin.users')->with('success', 'Usuario y sus posts han sido eliminados permanentemente.');
    }
}
