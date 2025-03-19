<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Affiche la page d'inscription.
     */
    public function create(): View
    {
        return view('auth.register'); // Plus besoin de passer les rôles
    }

    /**
     * Gère l'inscription d'un nouvel utilisateur.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation des données
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Récupérer le rôle par défaut (Agent)
        $role = Role::where('name', 'Agent')->first();

        // Vérifier si le rôle existe
        if (!$role) {
            return back()->withErrors(['role' => 'Le rôle par défaut (Agent) n’existe pas.']);
        }

        // Création de l'utilisateur avec le rôle par défaut
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id, // Rôle par défaut : Agent
        ]);

        // Déclenche l'événement d'inscription
        event(new Registered($user));

        // Connexion automatique de l'utilisateur
        Auth::login($user);

        // Redirection selon le rôle
        return $this->redirectToDashboard($user);
    }

    /**
     * Redirige l'utilisateur vers le bon tableau de bord en fonction de son rôle.
     */
    protected function redirectToDashboard(User $user): RedirectResponse
    {
        // Récupérer le rôle de l'utilisateur
        $role = Role::find($user->role_id);

        // Vérifier si le rôle existe
        if (!$role) {
            return redirect()->route('home')->with('error', 'Rôle non trouvé.');
        }

        // Redirection en fonction du nom du rôle
        switch ($role->name) {
            case 'Administrateur':
                return redirect()->route('admin.dashboard');
            case 'Secretaire_Municipal':
                return redirect()->route('secretaire.dashboard');
            case 'Agent':
                return redirect()->route('agent.dashboard');
            default:
                return redirect()->route('dashboard'); // Redirection par défaut
        }
    }
}