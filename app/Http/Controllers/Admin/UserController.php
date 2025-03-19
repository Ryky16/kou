<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Afficher la liste des utilisateurs
    public function index()
    {
        $users = User::with('role')->get(); // Récupère tous les utilisateurs avec leur rôle
        $roles = Role::all(); // Récupère tous les rôles disponibles
        return view('admin.users.index', compact('users', 'roles'));
    }

    // Mettre à jour le rôle d'un utilisateur
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => ['required', 'exists:roles,id'], // Vérifie que le rôle existe
        ]);

        // Met à jour le rôle de l'utilisateur
        $user->role_id = $request->role_id;
        $user->save();

        // Redirige avec un message de succès
        return back()->with('success', 'Rôle mis à jour avec succès.');
    }
}