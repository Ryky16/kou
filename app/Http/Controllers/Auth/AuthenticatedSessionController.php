<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Role;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    { 
        //dd($request->all());

        // Authentifier l'utilisateur
        $request->authenticate();

        // Régénérer la session
        $request->session()->regenerate();

        // Récupérer l'utilisateur authentifié avec son rôle
        $user = Auth::user();
       

        
        // Debug pour voir si l'utilisateur et son rôle sont bien récupérés
    if (!$user || !$user->role) {
        return redirect()->route('login')->with('error', 'Votre rôle n\'est pas défini.');
    }

        // Vérifier si le rôle existe
        if (!$user->role) {
            return redirect()->route('dashboard')->with('error', 'Rôle non trouvé.');
        }

        // Redirection en fonction du rôle
       switch ($user->role->name) {
            case Role::Administrateur:
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Connexion réussie.');
            case Role::Secretaire_Municipal:
                return redirect()->intended(route('secretaire.dashboard'))->with('success', 'Connexion réussie.');
            case Role::Agent:
                return redirect()->intended(route('agent.dashboard'))->with('success', 'Connexion réussie.');
            default:
                return redirect()->intended(route('dashboard'))->with('error', 'Rôle non reconnu.');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Déconnexion réussie.');
    }
}